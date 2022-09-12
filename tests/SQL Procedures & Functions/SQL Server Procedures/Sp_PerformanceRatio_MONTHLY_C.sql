USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[Sp_PerformanceRatio_MONTHLY_C]    Script Date: 13-04-2022 10:59:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
 
ALTER  PROCEDURE [dbo].[Sp_PerformanceRatio_MONTHLY_C]  
  
@StartDate  VARCHAR(10),  
@EndDate  VARCHAR(10),  
@FundTypeID INT,
--@FunctionName VARCHAR(25),  
@RiskFreeReturn float  
  
 AS  
    
  
BEGIN
SET NOCOUNT ON;  
  

  
  DECLARE @FundCode NVARCHAR(50);  
  
  CREATE TABLE #FINALRATIODATA  
   (  
    FUNDCODE   VARCHAR(25),  
    COVAR  FLOAT NULL ,  
    VARIANCE  FLOAT NULL,  
    RETURNVALUEINDEX  FLOAT NULL,  
    CAGRVALUE   FLOAT NULL,  
    BETAVALUE   FLOAT NULL,  
    JENSENVALUE   FLOAT NULL,  
    SHARPEVALUE   FLOAT NULL,  
    TRACKINGVALUE  FLOAT NULL,  
    INFVALUE   FLOAT NULL,  
    STDEVVALUE   FLOAT NULL,  
    RSQUAREVALUE  FLOAT NULL,  
    TREYNORVALUE  FLOAT NULL,  
    SKEWVALUE   FLOAT NULL,  
    KURTOSISVALUE  FLOAT NULL,  
    COEFFVARVALUE  FLOAT NULL,  
    RISKADJVALUE  FLOAT NULL  
   )  
  
  DECLARE CURSOR1 CURSOR  FOR SELECT m.FundCode FROM TbFundMaster m  
                    where m.FundTypeID=@FundTypeID and  m.OpDate<=CONVERT(DATETIME, @StartDate, 103)      
      OPEN CURSOR1      
      
    FETCH NEXT FROM CURSOR1 INTO @FundCode      
          
    WHILE @@FETCH_STATUS = 0  
     BEGIN        
        
      EXEC Sp_GetBetaMR @StartDate,@EndDate,@FundCode,@RiskFreeReturn  
        
      FETCH NEXT FROM CURSOR1 INTO @FundCode    
        
     END  
    CLOSE CURSOR1  
         DEALLOCATE CURSOR1   
      

  INSERT INTO dbo.tb_MonthlyRanking
  (
  FundCode   ,  
    STDEVVALUE  ,
	BETAVALUE,  
    JENSENVALUE ,
	STARTDATE,
	ENDDATE,
   FundTypeID
  )
      
     SELECT  #FINALRATIODATA.FUNDCODE as FundCode,#FINALRATIODATA.STDEVVALUE AS STDEVVALUE, 
	 #FINALRATIODATA.BETAVALUE AS BETAVALUE , #FINALRATIODATA.JENSENVALUE as JENSENVALUE ,
	 CONVERT(DATETIME, @StartDate, 103) AS STARTDATE,CONVERT(DATETIME, @EndDate, 103) AS ENDDATE,@FundTypeID 
	      FROM #FINALRATIODATA 
		  --INNER JOIN TBFUNDMASTER  
            --        ON #FINALRATIODATA.FUNDCODE = TBFUNDMASTER.FUNDCODE   
                    where BETAVALUE is not null  or STDEVVALUE is not null or JENSENVALUE is not null
      -- ORDER BY TBFUNDMASTER.NameOfFund ASC  
	  order by #FINALRATIODATA.FUNDCODE
 
    

 /*update dbo.tb_MonthlyRanking
 set  STARTDATE = CONVERT(DATETIME, @StartDate, 103)
    ,ENDDATE = CONVERT(DATETIME, @EndDate, 103)
	,FUNDTYPEID =@FundTypeID;
  
  select * from dbo.tb_MonthlyRankingC*/
END  