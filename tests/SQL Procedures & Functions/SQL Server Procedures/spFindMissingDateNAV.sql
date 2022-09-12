USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[spFindMissingDateNAV]    Script Date: 26-02-2022 10:39:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER  PROCEDURE [dbo].[spFindMissingDateNAV]

@FundCode	VARCHAR(50),
@StartDate date,
@EndDate date

 AS
		

BEGIN

SET NOCOUNT ON;
    
    SELECT
        FORMAT(DayInBetween,'dd-MM-yyyy') AS missingDate,(SELECT NameOfFund FROM TbFundMaster WHERE FundCode = @FundCode ) as fundname,
        @FundCode AS fundcode
    FROM dbo.GetAllDaysInBetween(CONVERT(DATETIME, @StartDate, 103), CONVERT(DATETIME, @EndDate, 103)) AS AllDaysInBetween
    WHERE NOT EXISTS 
        (SELECT fundcode FROM tbfunddetail WHERE 
		entrydate = AllDaysInBetween.DayInBetween AND fundcode = @FundCode )
   
END
