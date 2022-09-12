USE [MYPLEXUSDB_70803_COPY]
GO
    /****** Object:  StoredProcedure [dbo].[Sp_GetBetaMR]    Script Date: 13-04-2022 11:56:10 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[Sp_GetBetaMR] @StartDate VARCHAR(10),
    @EndDate VARCHAR(10),
    @FundCode NVARCHAR(50),
    @RiskFreeReturn FLOAT AS BEGIN DECLARE @EntryDate DATE,
    @EntryDate1 DATE,
    @ClosingNav FLOAT,
    @ClosingNav1 FLOAT,
    @ClosingValue FLOAT,
    @ClosingValue1 FLOAT,
    @STDate DATE,
    @LastDate DATE
SET
    NOCOUNT ON;

CREATE TABLE #TmpFundMaster      
(
    EntryDate DATE,
    ClosingValue FLOAT NULL,
    ClosingNav FLOAT NULL,
    Nav_Change FLOAT NULL,
    index_Change FLOAT NULL,
    Nav_Change_less_Avg FLOAT NULL,
    index_Change_less_Avg FLOAT NULL,
    multiple_nclv_iclv FLOAT NULL
)
INSERT INTO
    #TmpFundMaster 
    (EntryDate, ClosingValue, ClosingNav)
select
    i.EntryDate,
    isnull(i.ClosingValue, 0.00),
    isnull(f.ClosingNav, 0.00)
from
    TbFundDetail_MR f
    inner join TbFundMaster m on m.FundCode = f.FundCode
    inner join TbIndicesDetail_MR i on i.EntryDate = f.EntryDate
    and i.IndicesName = m.IndicesName
where
    m.FundCode = @FundCode
    and f.ClosingNav > 0
    and i.Holiday = 0
    and i.EntryDate between CONVERT(DATETIME, @StartDate, 103)
    and CONVERT(DATETIME, @EndDate, 103)
order by
    1 desc
SET
    @STDate = (
        SELECT
            top 1 EntryDate
        FROM
            #TmpFundMaster order by EntryDate);      
        SET
            @LastDate = (
                SELECT
                    top 1 EntryDate
                FROM
                    #TmpFundMaster order by EntryDate desc);        
                    DECLARE MYCURSOR CURSOR FOR
                SELECT
                    EntryDate,
                    ClosingNav,
                    ClosingValue
                FROM
                    #TmpFundMaster   --order by 1 desc   
                    DECLARE MYCURSOR1 CURSOR FOR
                SELECT
                    EntryDate,
                    ClosingNav,
                    ClosingValue
                FROM
                    #TmpFundMaster WHERE EntryDate < @LastDate    --order by 1 desc  
                    OPEN MYCURSOR OPEN MYCURSOR1 FETCH NEXT
                FROM
                    MYCURSOR INTO @EntryDate,
                    @ClosingNav,
                    @ClosingValue FETCH NEXT
                FROM
                    MYCURSOR1 INTO @EntryDate1,
                    @ClosingNav1,
                    @ClosingValue1 WHILE @ @FETCH_STATUS = 0 BEGIN
                UPDATE
                    #TmpFundMaster SET       
                    index_Change = (
                        (@ClosingValue - @ClosingValue1) / @ClosingValue1
                    ) * 100,
                    Nav_Change = ((@ClosingNav - @ClosingNav1) / @ClosingNav1) * 100
                WHERE
                    EntryDate = @EntryDate FETCH NEXT
                FROM
                    MYCURSOR INTO @EntryDate,
                    @ClosingNav,
                    @ClosingValue FETCH NEXT
                FROM
                    MYCURSOR1 INTO @EntryDate1,
                    @ClosingNav1,
                    @ClosingValue1
            END CLOSE MYCURSOR CLOSE MYCURSOR1 DEALLOCATE MYCURSOR DEALLOCATE MYCURSOR1 DECLARE @NAV_CHANGE_AVG FLOAT;

DECLARE @INDEX_CHANGE_AVG FLOAT;

DECLARE @SUM_multiple_nclv_iclv FLOAT;

DECLARE @COVARIENCE FLOAT;

DECLARE @VARIENCE FLOAT;

DECLARE @CL_ST FLOAT;

DECLARE @CL_EN FLOAT;

DECLARE @IV_ST FLOAT;

DECLARE @IV_EN FLOAT;

DECLARE @volatility FLOAT;

DECLARE @TrackingErr FLOAT;

DECLARE @Day INT DECLARE @CAGR FLOAT;

DECLARE @pow FLOAT;

DECLARE @Portfolio_Return FLOAT;

DECLARE @Market_Return FLOAT;

DECLARE @Beta FLOAT;

DECLARE @cnt BIGINT;

DECLARE @H247 FLOAT;

DECLARE @H247CNT FLOAT;

DECLARE @L13 FLOAT;

DECLARE @P35 FLOAT;

DECLARE @X FLOAT;

DECLARE @Y FLOAT;

DECLARE @XY FLOAT;

DECLARE @X2 FLOAT;

DECLARE @Y2 FLOAT;

DECLARE @O11 FLOAT;

DECLARE @O13X FLOAT;

DECLARE @O13Y FLOAT;

DECLARE @O13 FLOAT;

DECLARE @B4 FLOAT;

DECLARE @B6 FLOAT;

SELECT
    @CL_ST = ClosingNav,
    @IV_ST = ClosingValue
FROM
    #TmpFundMaster where EntryDate = @STDate;      
SELECT
    @CL_EN = ClosingNav,
    @IV_EN = ClosingValue
FROM
    #TmpFundMaster where EntryDate = @LastDate;      
SELECT
    @volatility = STDEV(ClosingNav)
FROM
    #TmpFundMaster;      
SET
    @Day = DATEDIFF(
        DAY,
        CONVERT(DATETIME, @StartDate, 103),
        CONVERT(DATETIME, @EndDate, 103)
    );

SET
    @RiskFreeReturn = ((@RiskFreeReturn / 365) * @Day);

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

DELETE FROM
    #TmpFundMaster WHERE EntryDate = @STDate;        
SET
    @cnt = (
        SELECT
            COUNT(index_Change)
        FROM
            #TmpFundMaster);      
        SELECT
            @NAV_CHANGE_AVG = AVG(ISNULL(Nav_Change, 0)),
            @INDEX_CHANGE_AVG = AVG(ISNULL(index_Change, 0))
        FROM
            #TmpFundMaster
        UPDATE
            #TmpFundMaster
        SET
            Nav_Change_less_Avg = ISNULL(Nav_Change, 0) - @NAV_CHANGE_AVG,
            index_Change_less_Avg = ISNULL(index_Change, 0) - @INDEX_CHANGE_AVG
        UPDATE
            #TmpFundMaster 
        SET
            multiple_nclv_iclv = ISNULL(Nav_Change_less_Avg, 0) * ISNULL(index_Change_less_Avg, 0)
        SELECT
            @SUM_multiple_nclv_iclv = SUM(multiple_nclv_iclv)
        FROM
            #TmpFundMaster
        SELECT
            @COVARIENCE = @SUM_multiple_nclv_iclv / @cnt
        SELECT
            @VARIENCE = VAR(index_Change)
        FROM
            #TmpFundMaster;
            --SELECT @Beta	= ((SUM(index_Change * Nav_Change) - SUM(index_Change) * SUM(Nav_Change) / @cnt) / @cnt) / VAR(index_Change) FROM #TmpFundMaster;      
        SELECT
            @Beta = @COVARIENCE / @VARIENCE
        SELECT
            @Portfolio_Return = ((@CL_EN - @CL_ST) / @CL_ST) * 100;

SELECT
    @Market_Return = ((@IV_EN - @IV_ST) / @IV_ST) * 100;

SELECT
    @H247 = SUM(SQUARE(Nav_Change - index_Change))
FROM
    #TmpFundMaster;        	
SELECT
    @H247CNT = (@H247 / @cnt);

SELECT
    @TrackingErr = CASE
        WHEN @H247CNT > 0 THEN SQRT(@H247CNT)
        ELSE 0
    END;

SET
    @L13 = @Market_Return - @RiskFreeReturn;

SET
    @L13 = @L13 * @Beta;

SELECT
    @P35 = (@Portfolio_Return - @RiskFreeReturn);

SET
    @X = (
        SELECT
            SUM(ClosingNav)
        FROM
            #TmpFundMaster);      
        SET
            @Y = (
                SELECT
                    SUM(ClosingValue)
                FROM
                    #TmpFundMaster);      
                SET
                    @XY = (
                        SELECT
                            SUM(ClosingNav * ClosingValue)
                        FROM
                            #TmpFundMaster);      
                        SET
                            @X2 = (
                                SELECT
                                    SUM(SQUARE(ClosingNav))
                                FROM
                                    #TmpFundMaster);      
                                SET
                                    @Y2 = (
                                        SELECT
                                            SUM(SQUARE(ClosingValue))
                                        FROM
                                            #TmpFundMaster);      
                                        SET
                                            @O11 = ((@cnt * @XY) - (@X * @Y));

SET
    @O13X = (@cnt * @X2) - SQUARE(@X);

SET
    @O13Y = (@cnt * @Y2) - SQUARE(@Y);

SELECT
    @O13 = CASE
        WHEN (
            @O13X > 0
            AND @O13Y > 0
        ) THEN SQRT(@O13X) * SQRT(@O13Y)
        ELSE 0
    END;

SELECT
    @B4 = AVG(Nav_Change - @RiskFreeReturn),
    @B6 = STDEV(Nav_Change)
FROM
    #TmpFundMaster; 
INSERT INTO
    #FINALRATIODATA 
    (
        FUNDCODE,
        VARIANCE,
        BETAVALUE,
        STDEVVALUE,
        TRACKINGVALUE,
        SHARPEVALUE,
        TREYNORVALUE,
        RSQUAREVALUE,
        JENSENVALUE,
        INFVALUE,
        CAGRVALUE
    )
SELECT
    @FundCode,
    VAR(index_Change) 'Variance',
    @Beta 'Beta',
    @volatility 'Volatility',
    @TrackingErr 'Tracking error',
    --CASE WHEN (@volatility = 0 OR @volatility = null) THEN 
    --	null
    --ELSE 
    --	(@P35/@volatility) 
    --END AS 'Sharpe ratio',
    --CASE WHEN (@Beta = 0 or @Beta = null) THEN 
    --	null
    --ELSE 
    --	(@P35/@Beta) 
    --END AS 'Treynor Ratio',
    CASE
        WHEN (
            @B6 = 0
            OR @B6 = null
        ) THEN null
        ELSE (@B4 / @B6)
    END AS 'Sharpe ratio',
    CASE
        WHEN (
            @Beta = 0
            or @Beta = null
        ) THEN null
        ELSE (@B4 / @Beta)
    END AS 'Treynor Ratio',
    CASE
        WHEN (
            @O13 = 0
            or @O13 = null
        ) THEN null
        ELSE SQUARE(@O11 / @O13)
    END AS 'R-SQR',
    (@P35 - @L13) AS 'Alpha',
    CASE
        WHEN (
            @TrackingErr = 0
            or @TrackingErr = null
        ) THEN null
        ELSE (
            (@Portfolio_Return - @Market_Return) / @TrackingErr
        )
    END AS 'Information Ratio',
    @CAGR 'CAGR'
FROM
    #TmpFundMaster;   
    --SELECT * FROM #TmpFundMaster;      
    DROP TABLE #TmpFundMaster      
END