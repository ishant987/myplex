USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[SpIndicesComposition_other]    Script Date: 28-02-2022 20:54:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
--EXEC SpIndicesComposition_other 2, 2019
ALTER PROCEDURE [dbo].[SpIndicesComposition_other]
@MonthNo		INT,
@YearNo			INT
AS
BEGIN
		SELECT DISTINCT SCRIPNAME FROM TbMCAPEPS WHERE
		MONTH(ENTRYDATE) = @MonthNo AND YEAR(ENTRYDATE) = @YearNo
		ORDER BY SCRIPNAME
END