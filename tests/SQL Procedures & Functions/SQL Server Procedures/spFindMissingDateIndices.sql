USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[spFindMissingDateIndices]    Script Date: 04-03-2022 15:11:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER  PROCEDURE [dbo].[spFindMissingDateIndices]

@IndicesName	VARCHAR(50),
@StartDate date,
@EndDate date

 AS
		

BEGIN

SET NOCOUNT ON;
    
    SELECT
        FORMAT(DayInBetween,'dd-MM-yyyy') AS missingDate,
        @IndicesName AS IndicesName
    FROM dbo.GetAllDaysInBetween(CONVERT(DATETIME, @StartDate, 103), CONVERT(DATETIME, @EndDate, 103)) AS AllDaysInBetween
    WHERE NOT EXISTS 
        (SELECT IndicesName FROM tbIndicesdetail WHERE 
		entrydate = AllDaysInBetween.DayInBetween AND IndicesName = @IndicesName )
    
     
END
