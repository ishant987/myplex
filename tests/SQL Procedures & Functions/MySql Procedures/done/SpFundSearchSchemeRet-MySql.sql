DELIMITER / / CREATE PROCEDURE sp_fund_search_scheme_ret (
    p_entry_date VARCHAR(10),
    p_fund_code varchar(50)
) BEGIN DECLARE v_Day int;

DECLARE v_POW double;

DECLARE v_Day2 int;

DECLARE v_POW2 double;

DECLARE v_Day3 int;

DECLARE v_POW3 double;

DECLARE v_Day5 int;

DECLARE v_POW5 double;

SET
    v_Day = TIMESTAMPDIFF(
        DAY,
        TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)),
        STR_TO_DATE(p_entry_date, 103)
    );

IF v_Day > 365 THEN
SET
    v_POW = v_Day / 365.0;

ELSE
SET
    v_POW = 1;

END IF;

SET
    v_POW = 1.0 / v_POW;

SET
    v_Day2 = TIMESTAMPDIFF(
        DAY,
        TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103)),
        STR_TO_DATE(p_entry_date, 103)
    );

IF v_Day2 > 365 THEN
SET
    v_POW2 = v_Day2 / 365.0;

ELSE
SET
    v_POW2 = 1;

END IF;

SET
    v_POW2 = 1.0 / v_POW2;

SET
    v_Day3 = TIMESTAMPDIFF(
        DAY,
        TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103)),
        STR_TO_DATE(p_entry_date, 103)
    );

IF v_Day3 > 365 THEN
SET
    v_POW3 = v_Day3 / 365.0;

ELSE
SET
    v_POW3 = 1;

END IF;

SET
    v_POW3 = 1.0 / v_POW3;

SET
    v_Day5 = TIMESTAMPDIFF(
        DAY,
        TIMESTAMPADD(YEAR, -5, STR_TO_DATE(p_entry_date, 103)),
        STR_TO_DATE(p_entry_date, 103)
    );

IF v_Day5 > 365 THEN
SET
    v_POW5 = v_Day5 / 365.0;

ELSE
SET
    v_POW5 = 1;

END IF;

SET
    v_POW5 = 1.0 / v_POW5;

SELECT
    X.fund_name,
    X.indices_name,
    CASE
        WHEN (
            X.STARTVALUE7 <> 0
            AND X.CLOSINGVALUE7 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE7 - X.STARTVALUE7) / X.STARTVALUE7
            ) * 100
        )
        WHEN X.STARTVALUE7 = 0 THEN 0
        WHEN X.CLOSINGVALUE7 = 0 THEN 0
    END AS "SEVENDAYS",
    CASE
        WHEN (
            X.STARTVALUE14 <> 0
            AND X.CLOSINGVALUE14 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE14 - X.STARTVALUE14) / X.STARTVALUE14
            ) * 100
        )
        WHEN X.STARTVALUE14 = 0 THEN 0
    END AS "FORTEENDAYS",
    CASE
        WHEN (
            X.STARTVALUE30 <> 0
            AND X.CLOSINGVALUE30 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE30 - X.STARTVALUE30) / X.STARTVALUE30
            ) * 100
        )
        WHEN X.STARTVALUE30 = 0 THEN 0
    END AS "THIRTYDAYS",
    CASE
        WHEN (
            X.STARTVALUE60 <> 0
            AND X.CLOSINGVALUE60 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE60 - X.STARTVALUE60) / X.STARTVALUE60
            ) * 100
        )
        WHEN X.STARTVALUE60 = 0 THEN 0
    END AS "SIXTYDAYS",
    CASE
        WHEN (
            X.STARTVALUE90 <> 0
            AND X.CLOSINGVALUE90 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE90 - X.STARTVALUE90) / X.STARTVALUE90
            ) * 100
        )
        WHEN X.STARTVALUE90 = 0 THEN 0
    END AS "NINTYDAYS",
    CASE
        WHEN (
            X.STARTVALUE6 <> 0
            AND CLOSINGVALUE6 <> 0
        ) THEN (
            (
                (X.CLOSINGVALUE6 - X.STARTVALUE6) / X.STARTVALUE6
            ) * 100
        )
        WHEN X.STARTVALUE6 = 0 THEN 0
    END AS "SIXMONTHS",
    CASE
        WHEN (
            X.STARTVALUE1 <> 0
            AND X.CLOSINGVALUE1 <> 0
        ) THEN (
            (
                POWER((X.CLOSINGVALUE1 / X.STARTVALUE1), v_POW) - 1
            ) * 100
        )
        WHEN X.STARTVALUE1 = 0 THEN 0
    END AS "ONEYEAR",
    CASE
        WHEN (
            X.STARTVALUE2 <> 0
            AND X.CLOSINGVALUE2 <> 0
        ) THEN (
            (
                POWER((X.CLOSINGVALUE2 / X.STARTVALUE2), v_POW2) - 1
            ) * 100
        )
        WHEN X.STARTVALUE2 = 0 THEN 0
    END AS "TWOYEAR",
    CASE
        WHEN (
            X.STARTVALUE3 <> 0
            AND X.CLOSINGVALUE3 <> 0
        ) THEN (
            POWER((X.CLOSINGVALUE3 / X.STARTVALUE3), v_POW3) - 1
        ) * 100
        WHEN X.STARTVALUE3 = 0 THEN 0
    END AS "THREEYEAR",
    CASE
        WHEN (
            X.STARTVALUE5 <> 0
            AND X.CLOSINGVALUE5 <> 0
        ) THEN (
            (
                POWER((X.CLOSINGVALUE5 / X.STARTVALUE5), v_POW5) - 1
            ) * 100
        )
        WHEN X.STARTVALUE5 = 0 THEN 0
    END AS "FIVEYEAR"
FROM
    (
        SELECT
            Y.fund_name,
            Y.fund_code,
            Y.indices_name,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE7,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened < TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE7,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE14,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened < TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE14,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(MONTH, -1, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(MONTH, -1, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE30,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened < TIMESTAMPADD(MONTH, -1, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(MONTH, -1, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE30,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE60,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened < TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE60,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(MONTH, -3, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(MONTH, -3, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE90,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened < TIMESTAMPADD(MONTH, -3, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(MONTH, -3, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE90,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE6,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened < TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE6,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE1,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE1,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened <= TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE2,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND Y.fund_opened <= TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE2,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE3,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103))
                    AND Y.fund_opened < TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE3,
            IFNULL(
                (
                    SELECT
                        mpx_fund_detail.closing_nav
                    FROM
                        mpx_fund_detail
                    WHERE
                        mpx_fund_detail.fund_code = Y.fund_code
                        AND Y.fund_opened < TIMESTAMPADD(YEAR, -5, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -5, STR_TO_DATE(p_entry_date, 103))
                        AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                        AND mpx_fund_detail.holiday = 0
                    ORDER BY
                        mpx_fund_detail.entry_date
                    LIMIT
                        1
                ), 0
            ) AS STARTVALUE5,
            (
                SELECT
                    mpx_fund_detail.closing_nav
                FROM
                    mpx_fund_detail
                WHERE
                    mpx_fund_detail.fund_code = Y.fund_code
                    AND mpx_fund_detail.entry_date >= TIMESTAMPADD(YEAR, -5, STR_TO_DATE(p_entry_date, 103))
                    AND Y.fund_opened < TIMESTAMPADD(YEAR, -5, STR_TO_DATE(p_entry_date, 103))
                    AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                    AND mpx_fund_detail.holiday = 0
                ORDER BY
                    mpx_fund_detail.entry_date DESC
                LIMIT
                    1
            ) AS CLOSINGVALUE5
        FROM
            (
                SELECT
                    fund_name,
                    fund_code,
                    indices_name,
                    fund_opened
                FROM
                    mpx_fund_master
                WHERE
                    fund_opened < STR_TO_DATE(p_entry_date, 103)
                    AND fund_code = p_fund_code
            ) Y
    ) X
ORDER BY
    X.fund_name;

END;

/ / DELIMITER;