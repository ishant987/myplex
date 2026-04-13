USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[Sp_GetCAGR]    Script Date: 03-03-2022 15:15:40 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[Sp_GetCAGR] @StartDate VARCHAR(10),
    @EndDate VARCHAR(10),
    @FundcodeIN VARCHAR(50),
    @FundtypeId int --@RiskFreeReturn		FLOAT            
    AS BEGIN DECLARE @EntryDate DATE,
    @EntryDate1 DATE,
    @ClosingNav FLOAT,
    @ClosingNav1 FLOAT,
    @ClosingValue FLOAT,
    @ClosingValue1 FLOAT,
    @STDate DATE,
    @LastDate DATE
SET
    NOCOUNT ON;

CREATE TABLE #FINALRATIODATA  
(
    FUNDCODE VARCHAR(25),
    CAGRVALUE FLOAT NULL,
    QUARTILE INT NULL,
    DECILE INT NULL
);

CREATE TABLE #TmpFundMaster      
(
    FundCode VARCHAR(50),
    EntryDate DATE,
    ClosingNav FLOAT NULL
)
INSERT INTO
    #TmpFundMaster 
    (FundCode, EntryDate, ClosingNav)
select
    m.FundCode,
    f.EntryDate,
    isnull(f.ClosingNav, 0.00)
from
    TbFundDetail f
    inner join TbFundMaster m on m.FundCode = f.FundCode
where
    m.FundTypeID = @FundtypeId
    and f.ClosingNav > 0
    and f.Holiday = 0
    and f.EntryDate between CONVERT(DATETIME, @StartDate, 103)
    and CONVERT(DATETIME, @EndDate, 103) --order by 2 desc        
    --SET @STDate		=	(SELECT top 1 EntryDate FROM #TmpFundMaster order by EntryDate);      
    --SET @LastDate	=	(SELECT top 1 EntryDate FROM #TmpFundMaster order by EntryDate desc);        
    DECLARE @CL_ST FLOAT;

DECLARE @CL_EN FLOAT;

DECLARE @Day INT DECLARE @CAGR FLOAT;

DECLARE @pow FLOAT;

DECLARE @FundCode NVARCHAR(50);

DECLARE CURSOR1 CURSOR FOR
SELECT
    m1.FundCode
FROM
    TbFundMaster m1
where
    OpDate <= CONVERT(DATETIME, @StartDate, 103)
    and m1.FundTypeId = @FundTypeId OPEN CURSOR1 FETCH NEXT
FROM
    CURSOR1 INTO @FundCode WHILE @ @FETCH_STATUS = 0 BEGIN
SELECT
    @CL_ST = ClosingNav
FROM
    #TmpFundMaster where EntryDate = (SELECT top 1 EntryDate FROM #TmpFundMaster where fundcode=@FundCode order by EntryDate ) and fundcode=@FundCode;      
SELECT
    @CL_EN = ClosingNav
FROM
    #TmpFundMaster where EntryDate = (SELECT top 1 EntryDate FROM #TmpFundMaster where fundcode=@FundCode order by EntryDate desc ) and fundcode=@FundCode;   
SET
    @Day = DATEDIFF(
        DAY,
        CONVERT(DATETIME, @StartDate, 103),
        CONVERT(DATETIME, @EndDate, 103)
    );

IF @Day > 365
SET
    @pow = @Day / 365.0
    ELSE
SET
    @pow = 1
SET
    @pow = 1.0 / @pow;

SET
    @CAGR = (POWER((@CL_EN / @CL_ST), @pow) - 1) * 100;

INSERT INTO
    #FINALRATIODATA 
    (FUNDCODE, CAGRVALUE)
VALUES
    (@FundCode, @CAGR);

FETCH NEXT
FROM
    CURSOR1 INTO @FundCode
END CLOSE CURSOR1 DEALLOCATE CURSOR1 EXEC SpQuartileCompute_CAGR;

EXEC SpDecileCompute_CAGR;

SELECT
    #FINALRATIODATA.FUNDCODE, #FINALRATIODATA.CAGRVALUE AS RATIO ,#FINALRATIODATA.QUARTILE ,#FINALRATIODATA.DECILE 
FROM
    #FINALRATIODATA  
where
    CAGRVALUE is not null
    and #FINALRATIODATA.FUNDCODE= @FundcodeIN 
    --   ORDER BY #FINALRATIODATA.CAGRVALUE DESC  ;
    DROP TABLE #TmpFundMaster      
END