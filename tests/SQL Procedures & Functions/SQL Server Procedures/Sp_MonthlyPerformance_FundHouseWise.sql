USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[Sp_MonthlyPerformance_FundHouseWise]    Script Date: 28-02-2022 12:03:30 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[Sp_MonthlyPerformance_FundHouseWise]
	@EndDate        VARCHAR(10),
	@ForceCalculate VARCHAR(01)
AS 
    DECLARE @CountAlreadyRowsPresent int;
   
    select @CountAlreadyRowsPresent = count(*)
    from dbo.TbMonthlyFundHousePerformance
    where dated = CONVERT(DATETIME, @EndDate, 103);
   
	IF @CountAlreadyRowsPresent = 0 OR @ForceCalculate = 'Y'
	   BEGIN
	    DECLARE @FundTypeID       BIGINT;
	    DECLARE @FundTypeName     NVARCHAR(255);
	    DECLARE @FundName         NVARCHAR(255);
		DECLARE	@FundCode         NVARCHAR(50);
		DECLARE @TimeName         VARCHAR(20);
		DECLARE @TimeSpan         INT;
		DECLARE @DaysAdjust       INT;
		DECLARE @StartDate        VARCHAR(10);
		DECLARE @RiskFreeExecuted BIT;
	
	    CREATE TABLE #TEMPCOVDATA
	       (
	        FUNDCODE   VARCHAR(25),
	        FUNDNAME   VARCHAR(255),
	        COVAR      FLOAT NULL
	       )
	       ;
	
		CREATE TABLE #TEMPRISKDATA
	       (
	        FUNDNAME       VARCHAR(255),
			FUNDCODE       VARCHAR(25),
			SIXMNTH        FLOAT NULL,
	        ONEYR          FLOAT NULL,
			TWOYR          FLOAT NULL,
			THREEYR        FLOAT NULL
	       )
	       ;
	
		CREATE TABLE #FINALRATIODATA
		   (  
		    FUNDCODE         VARCHAR(25),  
		    COVAR            FLOAT NULL ,  
		    VARIANCE         FLOAT NULL,  
			MEANAVERAGE		 FLOAT NULL ,
			RETURNVALUENAV   FLOAT NULL,
			RETURNVALUEINDEX FLOAT NULL,
		    CAGRVALUE        FLOAT NULL,  
		    BETAVALUE        FLOAT NULL,  
		    JENSENVALUE      FLOAT NULL,  
		    SHARPEVALUE      FLOAT NULL,  
		    TRACKINGVALUE    FLOAT NULL,  
		    INFVALUE         FLOAT NULL,  
		    STDEVVALUE       FLOAT NULL,  
		    RSQUAREVALUE     FLOAT NULL,  
		    TREYNORVALUE     FLOAT NULL,  
		    SKEWVALUE        FLOAT NULL,  
		    KURTOSISVALUE    FLOAT NULL,  
		    COEFFVARVALUE    FLOAT NULL,  
		    RISKADJVALUE     FLOAT NULL  
		   )  
		;
	
		CREATE TABLE #RETURNRATIODATA 
			(
			 Classification varchar(255),
			 TimeSpan       varchar(20),
			 NameOfFund     varchar(255),
			 FundHouse      varchar(255),
			 FundCode       varchar(50),
			 FundTypeId     int,
			 CAGRVALUE      FLOAT NULL, 
			 CAGRRank	    INT,
			 RETLESSIDX     FLOAT NULL,
		     RetLessIdxRank	INT,
		     JENSENVALUE    FLOAT NULL,  
		 	 JensenRank	    INT,
		  	 BETAVALUE      FLOAT NULL,  
			 BetaRank	    INT,
			 COVAR          FLOAT NULL , 
			 COVRank	    INT
			)
		;
	
		-- Initialize variable
		SET @RiskFreeExecuted = 0;
	
		-- Declare the three intervals in a table variable
		-- Storing months - 1 to be able to use in DATEDIFF function
		DECLARE @timeIntervals TABLE (TimeName varchar(20),TimeSpan int,DaysAdjust int);
		insert into @timeIntervals values('#6M',5,0),('1 Y',11,-1),('3 Y',35,-1);
	
		-- Run a cursor to process all stored intervals
		DECLARE csr_TimeIntervals CURSOR FOR
	       select TimeName
	             ,TimeSpan
				 ,DaysAdjust
		   from @timeIntervals
		   ;
	
		OPEN csr_TimeIntervals;
	
		FETCH NEXT FROM csr_TimeIntervals INTO @TimeName, @TimeSpan, @DaysAdjust;
	
		WHILE @@FETCH_STATUS = 0
			BEGIN	
			    -- Reset temporary tables
				TRUNCATE TABLE #TEMPCOVDATA;
				TRUNCATE TABLE #FINALRATIODATA;
	
				-- Get list of required fund types
				DECLARE csr_FundTypes CURSOR FOR
					select TypeName
							,FundTypeID
					from dbo.TbFundType tft
					WHERE MonthlyPerformance = 'Y'
					;
	    
				OPEN csr_FundTypes;
	
				FETCH NEXT FROM csr_FundTypes INTO @FundTypeName, @FundTypeID;
		   
				WHILE @@FETCH_STATUS = 0
					BEGIN
						PRINT '--------------------------------------------------------';
						PRINT 'Processing FundType: ' + @FundTypeName + ' ' + @TimeName;
						PRINT '---------------------------------------------------------';
	
						-- Set EndDate
						select @StartDate = FORMAT(DATEADD(DAY,@DaysAdjust,DATEADD(MONTH, DATEDIFF(MONTH, 0, CONVERT(DATE, @EndDate, 103))-@TimeSpan, 0)), 'dd/MM/yyyy');
						PRINT 'Start Date: ' + @StartDate;
	           
						-- Get a list of Funds
						DECLARE csr_funds CURSOR  FOR
							select FundCode
								  ,NameOfFund
								from dbo.TbFundMaster 
								where FundTypeID = @FundTypeID
								and OpDate  <= CONVERT(DATETIME, @StartDate, 103)
							;
				   
						OPEN csr_funds;
				   
						FETCH NEXT FROM csr_funds INTO @FundCode, @FundName;
				   
						WHILE @@FETCH_STATUS = 0
							BEGIN
								PRINT 'Processing Fund: ' + @FundName;
						
								EXEC Sp_GetBeta1 @StartDate,@EndDate,@FundCode,6.5
		               
								FETCH NEXT FROM csr_funds INTO @FundCode, @FundName;
							END
						
							CLOSE csr_funds;
					
		    				DEALLOCATE csr_funds;
		    	
		    			INSERT INTO #TEMPCOVDATA
		    			EXEC SpPerformanceRankingClassification @StartDate,@EndDate,@FundTypeID,'COEFFVAR';
	
						-- As this index does not depend on timespan and returns data for all 
						-- timespans together, run this only once. This will reduce some execution
						-- time
						IF @RiskFreeExecuted = 0
							INSERT INTO #TEMPRISKDATA
		    				EXEC SpMonthlyReturnLessIndex @EndDate,@FundTypeID;
							
						FETCH NEXT FROM csr_FundTypes INTO @FundTypeName, @FundTypeID;
					END
			
				CLOSE csr_FundTypes;
					
				DEALLOCATE csr_FundTypes;
	
				insert into #RETURNRATIODATA 
				select b.Classification,
					   @TimeName,
					   b.NameOfFund,
					   b.FundHouse,	
					   b.FundCode,
					   b.FundTypeID,
					   a.CAGRVALUE,
					   RANK() OVER(PARTITION BY b.Classification ORDER BY a.CAGRVALUE DESC) CAGRRank,
					   CASE
					     WHEN @TimeSpan =  5 then d.SIXMNTH
						 WHEN @TimeSpan = 11 then d.ONEYR
						 WHEN @TimeSpan = 35 then d.THREEYR
					   END RETLESSIDX,
					   RANK() OVER(PARTITION BY b.Classification ORDER BY d.SIXMNTH DESC) RetLessIdxRank,
					   a.JENSENVALUE,
					   RANK() OVER(PARTITION BY b.Classification ORDER BY a.JENSENVALUE DESC) JensenRank,
					   a.BETAVALUE,	
					   RANK() OVER(PARTITION BY b.Classification ORDER BY a.BETAVALUE ASC) BetaRank,
					   c.COVAR,
					   RANK() OVER(PARTITION BY b.Classification ORDER BY c.COVAR ASC) COVRank
				from #FINALRATIODATA a inner join dbo.TbFundMaster b on a.FUNDCODE = b.FundCode
									   inner join #TEMPCOVDATA c on b.FUNDCODE = c.FundCode
									   inner join #TEMPRISKDATA d on c.FUNDCODE = d.FundCode
				order by b.NameOfFund			
				;
	
				-- Set indicator to executed
				SET @RiskFreeExecuted = 1;
	
				FETCH NEXT FROM csr_TimeIntervals INTO @TimeName, @TimeSpan, @DaysAdjust;
			END
			;
	
			DECLARE @CountDated   INT;
	
			SELECT @CountDated = count(*)
			from dbo.TbMonthlyFundHousePerformance
			where dated = CONVERT(DATETIME, @EndDate, 103)
			;
	
			BEGIN TRANSACTION;
			IF @CountDated > 0
				DELETE FROM	dbo.TbMonthlyFundHousePerformance
				where dated = CONVERT(DATETIME, @EndDate, 103)
				;
			
			INSERT INTO dbo.TbMonthlyFundHousePerformance
			(Dated, FundTypeId, Timespan, FundCode, CAGR, CAGRRank, RetLessIdx, RetLessIdxRank, Jensen, JensenRank, Beta, BetaRank, CoVar, CoVarRank)
			SELECT CONVERT(DATETIME, @EndDate, 103), FundTypeId, TimeSpan, FundCode, CAGRVALUE, CAGRRank, RETLESSIDX, RetLessIdxRank, JENSENVALUE, JensenRank, BETAVALUE, BetaRank, COVAR, COVRank
			FROM #RETURNRATIODATA
			;
			COMMIT;
		END

--		select v01.Classification,
--		       v01.TimeSpan,
--			   e.fundCount Population,
--			   NameOfFund,
--			   FundHouse,
--			   Round(CAGRVALUE, 2) CAGRVALUE,
--			   CAGRRank,
--			   Round(RETLESSIDX, 2) RETLESSIDX,
--			   RetLessIdxRank,
--			   Round(JENSENVALUE, 2) JENSENVALUE,
--			   JensenRank,
--			   Round(BETAVALUE, 2) BETAVALUE,
--			   BetaRank,
--			   Round(COVAR, 2) COVAR,
--			   COVRank
--			from #RETURNRATIODATA v01 inner join (
--			   select e1.classification, e1.timespan, count(*) as fundCount
--			   from #RETURNRATIODATA e1
--			   group by e1.classification, e1.timespan
--			)  as e on v01.Classification = e.Classification and v01.TimeSpan = e.TimeSpan
--		;
	
		select tfm.Classification,
		       v01.TimeSpan,
			   e.fundCount Population,
			   tfm.NameOfFund,
			   tfm.FundHouse,
			   CAGR,
			   CAGRRank,
			   CAGRRankImprovement,
			   RETLESSIDX,
			   RetLessIdxRank,
			   RetLessIdxRankImprovement,
			   JENSEN,
			   JensenRank,
			   JensenRankImprovement,
			   BETA,
			   BetaRank,
			   BetaRankImprovement,
			   COVAR,
			   COVarRank,
			   COVarRankImprovement
			from dbo.TbMonthlyFundHousePerformance v01 inner join (
			   select e1.FundTypeId, e1.timespan, count(*) as fundCount
			   from dbo.TbMonthlyFundHousePerformance e1
			   where e1.dated = CONVERT(DATETIME, @EndDate, 103)
			   group by e1.FundTypeId, e1.timespan
			)  as e on v01.FundTypeId = e.FundTypeId and v01.TimeSpan = e.TimeSpan
			   inner join dbo.tbFundMaster tfm on v01.fundcode = tfm.fundcode
			where v01.dated = CONVERT(DATETIME, @EndDate, 103)
			order by tfm.fundhouse, v01.timespan, tfm.classification, tfm.nameoffund
		;
