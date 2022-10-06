USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[Sp_RollingReturn]    Script Date: 02-03-2022 18:31:44 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[Sp_RollingReturn] @StartDate VARCHAR(10),
    @EndDate VARCHAR(10),
    @FundCode NVARCHAR(50) AS BEGIN
SET
    NOCOUNT ON;

DECLARE @EntryDate DATETIME,
@ClosingNav FLOAT,
@PreVal FLOAT,
@PercentageChange FLOAT CREATE TABLE #TmpFundMaster
(
    EntryDate DATETIME,
    ClosingNav FLOAT NULL,
    PercentageChange FLOAT NULL
)
INSERT INTO
    #TmpFundMaster (EntryDate,ClosingNav) 
SELECT
    EntryDate,
    ClosingNav
FROM
    TbFundDetail
WHERE
    FundCode = @FundCode
    AND EntryDate BETWEEN dateadd(dd, -30, CONVERT(DATETIME, @StartDate, 103))
    and CONVERT(DATETIME, @EndDate, 103)
order by
    EntryDate desc DECLARE MYCURSOR CURSOR FOR
SELECT
    EntryDate,
    ClosingNav
FROM
    #TmpFundMaster
    OPEN MYCURSOR FETCH NEXT
FROM
    MYCURSOR INTO @EntryDate,
    @ClosingNav WHILE @ @FETCH_STATUS = 0 BEGIN
SET
    @PreVal = (
        SELECT
            ClosingNav
        FROM
            #TmpFundMaster 
        where
            EntryDate = dateadd(dd, -30, @EntryDate)
    )
SET
    @PercentageChange =((@ClosingNav - @PreVal) / @PreVal * 100 * 12)
update
    #TmpFundMaster set PercentageChange=@PercentageChange
where
    EntryDate = @EntryDate FETCH NEXT
FROM
    MYCURSOR INTO @EntryDate,
    @ClosingNav
END CLOSE MYCURSOR DEALLOCATE MYCURSOR
SET
    @PercentageChange = (
        SELECT
            AVG(PercentageChange)
        from
            #TmpFundMaster 
        WHERE
            EntryDate >= CONVERT(DATETIME, @StartDate, 103)
    )
select
    NameOfFund NAMEOFFUND,
    @PercentageChange RATIO
from
    TbFundMaster
where
    FundCode = @FundCode --select * from #TmpFundMaster 
    --		WHERE  EntryDate >= CONVERT(DATETIME, @StartDate, 103)
    --order by EntryDate desc
    drop TABLE #TmpFundMaster
END