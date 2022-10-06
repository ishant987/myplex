USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[spFindMissingDateCurrency]    Script Date: 04-03-2022 15:13:50 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER  PROCEDURE [dbo].[spFindMissingDateCurrency]

@CurrencyId	INT,
@StartDate date,
@EndDate date

 AS
		

BEGIN

SET NOCOUNT ON;
    
    SELECT
        FORMAT(DayInBetween,'dd-MM-yyyy') AS missingDate,(SELECT CurrencyName FROM TbCurrencyMaster WHERE CurrencyId = @CurrencyId ) as currencyname,
        @CurrencyId AS CurrencyId
    FROM dbo.GetAllDaysInBetween(CONVERT(DATETIME, @StartDate, 103), CONVERT(DATETIME, @EndDate, 103)) AS AllDaysInBetween
    WHERE NOT EXISTS 
        (SELECT CurrencyId FROM tbcurrencydetail WHERE 
		entrydate = AllDaysInBetween.DayInBetween AND CurrencyId = @CurrencyId )
    
     
END
