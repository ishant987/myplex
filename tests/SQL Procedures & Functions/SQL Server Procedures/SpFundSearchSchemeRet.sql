USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[SpFundSearchSchemeRet]    Script Date: 03-03-2022 15:23:38 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[SpFundSearchSchemeRet] @EntryDate VARCHAR(10),
    @FundCode varchar(50) AS BEGIN DECLARE @Day int,
    @POW float,
    @Day2 int,
    @POW2 float,
    @Day3 int,
    @POW3 float,
    @Day5 int,
    @POW5 float;

SET
    NOCOUNT ON;

SET
    @Day = DATEDIFF(
        DAY,
        DATEADD(YEAR, -1, CONVERT(DATETIME, @EntryDate, 103)),
        CONVERT(DATETIME, @EntryDate, 103)
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
    @Day2 = DATEDIFF(
        DAY,
        DATEADD(YEAR, -2, CONVERT(DATETIME, @EntryDate, 103)),
        CONVERT(DATETIME, @EntryDate, 103)
    );

IF @Day2 > 365
SET
    @pow2 = @Day2 / 365.0
    ELSE
SET
    @pow2 = 1
SET
    @pow2 = 1.0 / @pow2;

SET
    @Day3 = DATEDIFF(
        DAY,
        DATEADD(YEAR, -3, CONVERT(DATETIME, @EntryDate, 103)),
        CONVERT(DATETIME, @EntryDate, 103)
    );

IF @Day3 > 365
SET
    @pow3 = @Day3 / 365.0
    ELSE
SET
    @pow3 = 1
SET
    @pow3 = 1.0 / @pow3;

SET
    @Day5 = DATEDIFF(
        DAY,
        DATEADD(YEAR, -5, CONVERT(DATETIME, @EntryDate, 103)),
        CONVERT(DATETIME, @EntryDate, 103)
    );

IF @Day5 > 365
SET
    @pow5 = @Day5 / 365.0
    ELSE
SET
    @pow5 = 1
SET
    @pow5 = 1.0 / @pow5;

SELECT
    X.NAMEOFFUND,
    X.INDICESNAME,
    "SEVENDAYS" = CASE
        WHEN (
            X.STARTVALUE7 <> 0
            AND X.CLOSINGVALUE7 <> 0
        ) THEN (
            ((X.CLOSINGVALUE7 - X.STARTVALUE7) / X.STARTVALUE7) * 100
        )
        WHEN X.STARTVALUE7 = 0 THEN 0
        WHEN X.CLOSINGVALUE7 = 0 THEN 0
    END,
    "FORTEENDAYS" = CASE
        WHEN (
            X.STARTVALUE14 <> 0
            AND X.CLOSINGVALUE14 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE14 - X.STARTVALUE14) / X.STARTVALUE14
            ) * 100
        )
        WHEN X.STARTVALUE14 = 0 THEN 0
    END,
    "THIRTYDAYS" = CASE
        WHEN (
            X.STARTVALUE30 <> 0
            AND X.CLOSINGVALUE30 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE30 - X.STARTVALUE30) / X.STARTVALUE30
            ) * 100
        )
        WHEN X.STARTVALUE30 = 0 THEN 0
    END,
    "SIXTYDAYS" = CASE
        WHEN (
            X.STARTVALUE60 <> 0
            AND X.CLOSINGVALUE60 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE60 - X.STARTVALUE60) / X.STARTVALUE60
            ) * 100
        )
        WHEN X.STARTVALUE60 = 0 THEN 0
    END,
    "NINTYDAYS" = CASE
        WHEN (
            X.STARTVALUE90 <> 0
            AND X.CLOSINGVALUE90 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE90 - X.STARTVALUE90) / X.STARTVALUE90
            ) * 100
        )
        WHEN X.STARTVALUE90 = 0 THEN 0
    END,
    "SIXMONTHS" = CASE
        WHEN (
            X.STARTVALUE6 <> 0
            AND CLOSINGVALUE6 <> 0
        ) THEN (
            ((X.CLOSINGVALUE6 - X.STARTVALUE6) / X.STARTVALUE6) * 100
        )
        WHEN X.STARTVALUE6 = 0 THEN 0
    END,
    "ONEYEAR" = CASE
        --WHEN (X.STARTVALUE1 <> 0 AND X.CLOSINGVALUE1 <> 0) THEN (((X.CLOSINGVALUE1 - X.STARTVALUE1)/ X.STARTVALUE1)*100)
        WHEN (
            X.STARTVALUE1 <> 0
            AND X.CLOSINGVALUE1 <> 0
        ) THEN (
            (
                POWER((X.CLOSINGVALUE1 / X.STARTVALUE1), @pow) - 1
            ) * 100
        ) --(POWER((X.CLOSINGVALUE1 / X.STARTVALUE1), 1) - 1) * 100;  
        WHEN X.STARTVALUE1 = 0 THEN 0
    END,
    /* (POWER((RETURNDATA.FUNDBOTTOM/RETURNDATA.FUNDTOP), 1/@Term) - 1) * 100 */
    "TWOYEAR" = CASE
        WHEN (
            X.STARTVALUE2 <> 0
            AND X.CLOSINGVALUE2 <> 0
        ) THEN (
            (POWER((X.CLOSINGVALUE2 / X.STARTVALUE2), @pow2) - 1) * 100
        )
        WHEN X.STARTVALUE2 = 0 THEN 0
    END,
    "THREEYEAR" = CASE
        WHEN (
            X.STARTVALUE3 <> 0
            AND X.CLOSINGVALUE3 <> 0
        ) THEN (
            POWER((X.CLOSINGVALUE3 / X.STARTVALUE3), @pow3) - 1
        ) * 100 --((POWER((X.CLOSINGVALUE3/X.STARTVALUE3),0.333) - 1) * 100)
        --(POWER((X.CLOSINGVALUE1 / X.STARTVALUE1), .33) - 1) * 100;  
        WHEN X.STARTVALUE3 = 0 THEN 0
    END,
    "FIVEYEAR" = CASE
        WHEN (
            X.STARTVALUE5 <> 0
            AND X.CLOSINGVALUE5 <> 0
        ) THEN (
            (POWER((X.CLOSINGVALUE5 / X.STARTVALUE5), @pow5) - 1) * 100
        )
        WHEN X.STARTVALUE5 = 0 THEN 0
    END
FROM
    (
        SELECT
            Y.NAMEOFFUND,
            Y.FUNDCODE,
            Y.INDICESNAME,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(Day, -7, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(Day, -7, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE7,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE < DATEADD(Day, -7, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(Day, -7, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE7,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(Day, -14, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE > DATEADD(Day, -14, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE14,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE < DATEADD(Day, -14, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE > DATEADD(Day, -14, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE14,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(MONTH, -1, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(MONTH, -1, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE30,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE < DATEADD(MONTH, -1, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(MONTH, -1, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE30,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(Day, -60, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(Day, -60, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE60,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE < DATEADD(Day, -60, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(Day, -60, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE60,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(MONTH, -3, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(MONTH, -3, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE90,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE < DATEADD(MONTH, -3, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(MONTH, -3, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE90,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(MONTH, -6, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(MONTH, -6, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE6,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE < DATEADD(MONTH, -6, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(MONTH, -6, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE6,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(YEAR, -1, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -1, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE1,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE < DATEADD(YEAR, -1, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -1, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE1,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE <= DATEADD(YEAR, -2, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -2, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE2,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND Y.OPDATE <= DATEADD(YEAR, -2, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -2, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE2,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(YEAR, -3, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -3, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE3,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -3, CONVERT(DATETIME, @EntryDate, 103))
                    AND Y.OPDATE < DATEADD(YEAR, -3, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE3,
            ISNULL(
                (
                    SELECT
                        TOP 1 TBFUNDDETAIL.CLOSINGNAV
                    FROM
                        TBFUNDDETAIL
                    WHERE
                        TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                        AND Y.OPDATE < DATEADD(YEAR, -5, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -5, CONVERT(DATETIME, @EntryDate, 103))
                        AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                        AND TBFUNDDETAIL.HOLIDAY = 0
                    ORDER BY
                        TBFUNDDETAIL.ENTRYDATE
                ),
                0
            ) AS STARTVALUE5,
            (
                SELECT
                    TOP 1 TBFUNDDETAIL.CLOSINGNAV
                FROM
                    TBFUNDDETAIL
                WHERE
                    TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE
                    AND TBFUNDDETAIL.ENTRYDATE >= DATEADD(YEAR, -5, CONVERT(DATETIME, @EntryDate, 103))
                    AND Y.OPDATE < DATEADD(YEAR, -5, CONVERT(DATETIME, @EntryDate, 103))
                    AND TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)
                    AND TBFUNDDETAIL.HOLIDAY = 0
                ORDER BY
                    TBFUNDDETAIL.ENTRYDATE DESC
            ) AS CLOSINGVALUE5
        FROM
            (
                SELECT
                    NAMEOFFUND,
                    FUNDCODE,
                    INDICESNAME,
                    OPDATE
                FROM
                    TBFUNDMASTER
                WHERE
                    OPDATE < CONVERT(DATETIME, @EntryDate, 103)
                    AND FUNDCODE = @FundCode
            ) Y
    ) X
ORDER BY
    X.NAMEOFFUND
END