USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[Sp_MonthlyRanking_AAUM]    Script Date: 13-04-2022 11:01:24 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
--EXEC Sp_MonthlyRanking '30/11/2019', 50
ALTER  PROCEDURE [dbo].[Sp_MonthlyRanking_AAUM]    
@EndDate  VARCHAR(10)    ,
 @TypeID  INT        
AS         
BEGIN    
		SET NOCOUNT ON;  
		DECLARE      
				@StartDate				DATETIME,
				@EntryDate				DATE,      
				@EntryDate1				DATE,      
				@ClosingNav				FLOAT,        
				@ClosingNav1			FLOAT,      
				@ClosingValue			FLOAT,      
				@ClosingValue1			FLOAT,      
				@STDate					DATE,      
				@LastDate				DATE 

		declare @FundCode				NVARCHAR(50)
		DECLARE @CL_ST					FLOAT;      
		DECLARE @CL_EN					FLOAT;       
		DECLARE @IV_ST					FLOAT;      
		DECLARE @IV_EN					FLOAT; 
		DECLARE @Day					INT;
		DECLARE @Day_R					INT;
		DECLARE @CAGR					FLOAT;      
		DECLARE @pow					FLOAT;
		DECLARE @V_AAUM					FLOAT;

		CREATE TABLE #TmpFund
		(
			FundCode		NVARCHAR(50),
			NameOfFund		NVARCHAR(510),
			OpDate			DATETIME,
			AAUM			FLOAT,
			return_percent	FLOAT NOT NULL DEFAULT 0    ,
			FundTypeID		INT    
		)

		CREATE TABLE #TmpFundMaster      
		(   
			FundCode		NVARCHAR(50),
			EntryDate		DATE,         
			ClosingValue	FLOAT NULL DEFAULT 0,         
			ClosingNav		FLOAT NULL,      
			Nav_Change		FLOAT NOT NULL DEFAULT 0,      
			index_Change	FLOAT NOT NULL DEFAULT 0			
		) 

		SET @StartDate = DATEADD(YEAR, -1, CONVERT(DATETIME, @EndDate, 103))

		INSERT INTO #TmpFund
		(
				FundCode,
				NameOfFund,
				OpDate	,
				FundTypeID	
		)
		SELECT	FundCode, 
				NameOfFund,
				OpDate,
				FundTypeID
		FROM	TbFundMaster 
		WHERE	FundTypeID = @TypeID

		INSERT INTO #TmpFundMaster 
		(
				FundCode,
				EntryDate,
				--ClosingValue,
				ClosingNav
		)       
        
		SELECT 
				m.FundCode,
				f.EntryDate,
				f.ClosingNav       
		FROM	TbFundDetail_MR as f       
		INNER JOIN TbFundMaster m ON m.FundCode = f.FundCode       
		WHERE m.FundCode IN (SELECT FundCode FROM #TmpFund)  
		AND ClosingNav > 0     
		AND f.Holiday = 0 
		AND f.EntryDate BETWEEN CONVERT(DATETIME, @StartDate, 103) AND CONVERT(DATETIME, @EndDate, 103)      
		ORDER BY 1 DESC 

		DECLARE C CURSOR 
		FOR 
		SELECT DISTINCT FundCode FROM #TmpFundMaster ORDER BY FundCode 

		OPEN C
		FETCH NEXT FROM C INTO @FundCode

		WHILE @@FETCH_STATUS = 0
			BEGIN
				SET @STDate		= (SELECT TOP 1 EntryDate FROM #TmpFundMaster WHERE FundCode = @FundCode ORDER BY EntryDate);      
				SET @LastDate	= (SELECT TOP 1 EntryDate FROM #TmpFundMaster WHERE FundCode = @FundCode ORDER BY EntryDate DESC);       
				SELECT @CL_ST = 0, @CL_EN = 0, @IV_ST = 0, @IV_EN = 0, @CAGR = 0

				 
				DECLARE MYCURSOR CURSOR  
				FOR 
				SELECT EntryDate, ClosingNav FROM #TmpFundMaster WHERE FundCode = @FundCode       

				DECLARE MYCURSOR1 CURSOR  
				FOR 
				SELECT EntryDate, ClosingNav FROM #TmpFundMaster WHERE EntryDate < @LastDate AND FundCode = @FundCode     

				OPEN MYCURSOR      
				OPEN MYCURSOR1      
          
				FETCH NEXT FROM MYCURSOR INTO @EntryDate, @ClosingNav      
				FETCH NEXT FROM MYCURSOR1 INTO @EntryDate1, @ClosingNav1     

				WHILE @@FETCH_STATUS = 0
					BEGIN
						UPDATE	#TmpFundMaster 
						SET     --index_Change	=	((@ClosingValue-@ClosingValue1)/@ClosingValue1)*100     
								Nav_Change		=	((@ClosingNav-@ClosingNav1)/@ClosingNav1)*100      
						WHERE	EntryDate = @EntryDate      
						AND		FundCode = @FundCode

						FETCH NEXT FROM MYCURSOR INTO @EntryDate, @ClosingNav --, @ClosingValue      
						FETCH NEXT FROM MYCURSOR1 INTO @EntryDate1, @ClosingNav1 --, @ClosingValue1      
					END
				CLOSE MYCURSOR
				CLOSE MYCURSOR1

				DEALLOCATE MYCURSOR       
				DEALLOCATE MYCURSOR1       
				
				SELECT @CL_ST = ISNULL(ClosingNav,0) FROM #TmpFundMaster WHERE EntryDate = @STDate AND FundCode = @FundCode;      
				SELECT @CL_EN = ISNULL(ClosingNav,0) FROM #TmpFundMaster WHERE EntryDate = @LastDate AND FundCode = @FundCode; 

				/*SELECT @CL_ST = ClosingNav FROM #TmpFundMaster where EntryDate = (SELECT top 1 EntryDate FROM #TmpFundMaster where fundcode=@FundCode order by EntryDate ) and fundcode=@FundCode;      
				SELECT @CL_EN = ClosingNav FROM #TmpFundMaster where EntryDate = (SELECT top 1 EntryDate FROM #TmpFundMaster where fundcode=@FundCode order by EntryDate desc ) and fundcode=@FundCode;    */          
	
        		SET @CAGR =0;		
				SET @Day = DATEDIFF(DAY, CONVERT(DATETIME, @StartDate, 103), CONVERT(DATETIME, @EndDate, 103));

				SET @Day_R = DATEDIFF(DAY, CONVERT(DATETIME, @STDate, 103), CONVERT(DATETIME, @LastDate, 103));

				/*IF @Day > 365 
				     
					SET @pow = @Day / 365.0      
				ELSE      
					SET @pow = 1      

				SET @pow = 1.0 / @pow;   

				IF  @Day > 364
					
					SET @CAGR = (POWER((@CL_EN/@CL_ST),@pow)-1)*100; */
				
				--SET @CAGR =0;
					--SET @Day_R=365;
				--else 
				
				
				--Portfolio_Return
				--SET @CAGR = ((@CL_EN - @CL_ST) / @CL_ST)*100

				IF @Day > 365      
					SET @pow = @Day / 365.0      
				ELSE      
					SET @pow = 1      

				SET @pow = 1.0 / @pow;      

				SET @CAGR = (POWER((@CL_EN / @CL_ST), @pow) - 1) * 100;      

				UPDATE	#TmpFund
				SET		return_percent = ISNULL(@CAGR,0)
				WHERE	FundCode = @FundCode;

				UPDATE	#TmpFund
				SET		AAUM = (SELECT DISTINCT CorpusEntry  FROM TbCorpusEntry  
WHERE EntryDate = CONVERT(DATETIME, @EndDate, 103)  and FundCode= @FundCode)
				WHERE	FundCode = @FundCode
					
				FETCH NEXT FROM C INTO @FundCode
			END
		CLOSE C
		DEALLOCATE C

		-- SET @StartDate = DATEADD(MONTH, DATEDIFF(MONTH, -1, CONVERT(DATETIME, @EndDate, 103))-1, -1)

/*------------------- to be deleted --------------------------
DROP TABLE dbo.tb_MonthlyRanking_AAUM ;

  CREATE TABLE dbo.tb_MonthlyRanking_AAUM  
   (  
    FundCode   VARCHAR(25),  
    NameOfFund  VARCHAR(75),  
    OpDate   DATE,  
    AAUM   FLOAT NULL,  
	PRE_AAUM FLOAT NULL, 
    AAUM_RETURN  FLOAT NULL,   
    FundTypeID INT,
	RUNDATE DATE
   )  

 ---------------------end------------------------------------
 select *  FROM	#TmpFund;*/


INSERT INTO dbo.tb_MonthlyRanking_AAUM
  (
  FundCode   ,  
    NameOfFund  ,
	OpDate,  
    AAUM ,
	PRE_AAUM,
	AAUM_RETURN,
   FundTypeID,
   RUNDATE
  )
  
		SELECT	T.FundCode,
				T.NameOfFund,
				T.OpDate OpDate, 
				T.AAUM, 
				PRE.CorpusEntry PRE_AAUM, 
				T.return_percent 'RETURN',
				T.FundTypeID ,
				CONVERT(DATETIME, @EndDate, 103)
		FROM	#TmpFund T
		LEFT JOIN (SELECT DISTINCT FundCode, CorpusEntry FROM TbCorpusEntry WHERE EntryDate = CONVERT(DATETIME, @EndDate, 103)) C ON C.FundCode=T.FundCode
		LEFT JOIN (SELECT DISTINCT FundCode, CorpusEntry FROM TbCorpusEntry WHERE EntryDate = CONVERT(DATETIME, @StartDate, 103)) PRE ON PRE.FundCode = T.FundCode
		ORDER BY NameOfFund    ;

UPDATE [MYPLEXUSDB_70803].[dbo].[tb_MonthlyRanking_AAUM]
SET [AAUM_RETURN]=NULL
WHERE DATEDIFF(DAY, CONVERT(DATETIME, OpDate, 103), CONVERT(DATETIME, RUNDATE, 103))<365	;
		     
END 