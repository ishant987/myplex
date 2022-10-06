USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[SpMRDataConsolidation]    Script Date: 24-02-2022 20:07:58 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
 
ALTER  PROCEDURE [dbo].[SpMRDataConsolidation]  
  
--@EndDate  VARCHAR(10),  
@RiskFreeReturn float  
  
 AS  
  DECLARE
		@opDate1	varchar(10),
		@opDate2	varchar(10),
		@opDate3	varchar(10),
		@opDate4	varchar(10),
		@opDate1_end	varchar(10),
		@opDate2_end	varchar(10),
		@opDate3_end	varchar(10),
		@opDate4_end	varchar(10),

		@stdate	date,
		@endate	date,

		@FundTypeID int; 
  
BEGIN
SET NOCOUNT ON;  

TRUNCATE TABLE dbo.tb_MonthlyRanking;
TRUNCATE TABLE dbo.tb_MonthlyRanking_AAUM;
TRUNCATE TABLE dbo.TbFundDetail_MR;
TRUNCATE TABLE dbo.TbIndicesDetail_MR;
  
  SET @opDate1=(SELECT CONVERT(varchar(10),date1_start ,103) from tb_MonthlyRankingDates)	;
  SET @opDate1_end=(SELECT CONVERT(varchar(10),date1_end ,103) from tb_MonthlyRankingDates)	;
 SET @opDate2=(SELECT CONVERT(varchar(10),date2_start ,103) from tb_MonthlyRankingDates)	;
  SET @opDate2_end=(SELECT CONVERT(varchar(10),date2_end ,103) from tb_MonthlyRankingDates)	;
 SET @opDate3=(SELECT CONVERT(varchar(10),date3_start ,103) from tb_MonthlyRankingDates)	;
  SET @opDate3_end=(SELECT CONVERT(varchar(10),date3_end ,103) from tb_MonthlyRankingDates)	;
 SET @opDate4=(SELECT CONVERT(varchar(10),date4_start ,103) from tb_MonthlyRankingDates)	;
  SET @opDate4_end=(SELECT CONVERT(varchar(10),date4_end ,103) from tb_MonthlyRankingDates)	;

  
   SET @stdate=(SELECT date4_start  from tb_MonthlyRankingDates)	;
  SET @endate=(SELECT date1_end from tb_MonthlyRankingDates)	;
 

INSERT INTO dbo.TbFundDetail_MR
SELECT * FROM dbo.TbFundDetail
WHERE entrydate>=@stdate and EntryDate<=@endate; 

INSERT INTO dbo.TbIndicesDetail_MR
SELECT * FROM dbo.TbIndicesDetail
WHERE entrydate>=@stdate and EntryDate<=@endate; 

  
  DECLARE CURSOR11 CURSOR  FOR SELECT c.FundTypeID FROM TbFundType c   
    
    OPEN CURSOR11      
      
    FETCH NEXT FROM CURSOR11 INTO @FundTypeID      
          
    WHILE @@FETCH_STATUS = 0  
     BEGIN        
        
      EXEC Sp_PerformanceRatio_MONTHLY_C @OpDate1,@opDate1_end,@FundTypeID,@RiskFreeReturn  ;
	  EXEC Sp_PerformanceRatio_MONTHLY_C @OpDate2,@opDate2_end,@FundTypeID,@RiskFreeReturn  ;
	  EXEC Sp_PerformanceRatio_MONTHLY_C @OpDate3,@opDate3_end,@FundTypeID,@RiskFreeReturn  ;
	  EXEC Sp_PerformanceRatio_MONTHLY_C @OpDate4,@opDate4_end,@FundTypeID,@RiskFreeReturn  ;
      --EXEC Sp_MonthlyRanking_AAUM @opDate1_end,@FundTypeID;  

      FETCH NEXT FROM CURSOR11 INTO @FundTypeID    
        
     END  
   CLOSE CURSOR11  
   DEALLOCATE CURSOR11   
      
  DECLARE CURSOR2 CURSOR  FOR SELECT c1.FundTypeID FROM TbFundType c1   
    
    OPEN CURSOR2      
      
    FETCH NEXT FROM CURSOR2 INTO @FundTypeID      
          
    WHILE @@FETCH_STATUS = 0  
     BEGIN        
        
      EXEC Sp_MonthlyRanking_AAUM @opDate1_end,@FundTypeID; 
        
      FETCH NEXT FROM CURSOR2 INTO @FundTypeID    
        
     END  
   CLOSE CURSOR2
   DEALLOCATE CURSOR2
   
   /*
   DECLARE CURSOR3 CURSOR  FOR SELECT c.FundTypeID FROM TbFundType c   
    
    OPEN CURSOR3      
      
    FETCH NEXT FROM CURSOR3 INTO @FundTypeID      
          
    WHILE @@FETCH_STATUS = 0  
     BEGIN        
        
      EXEC Sp_PerformanceRatio_MONTHLY_C @OpDate3,@opDate3_end,@FundTypeID,@RiskFreeReturn  
        
      FETCH NEXT FROM CURSOR3 INTO @FundTypeID    
        
     END  
   CLOSE CURSOR3
   DEALLOCATE CURSOR3  

  DECLARE CURSOR4 CURSOR  FOR SELECT c.FundTypeID FROM TbFundType c   
    
    OPEN CURSOR4      
      
    FETCH NEXT FROM CURSOR4 INTO @FundTypeID      
          
    WHILE @@FETCH_STATUS = 0  
     BEGIN        
        
      EXEC Sp_PerformanceRatio_MONTHLY_C @OpDate4,@opDate4_end,@FundTypeID,@RiskFreeReturn  
        
      FETCH NEXT FROM CURSOR4 INTO @FundTypeID    
        
     END  
   CLOSE CURSOR4
   DEALLOCATE CURSOR4
   */
 END  