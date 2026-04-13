DELIMITER / / CREATE PROCEDURE sp_get_quartile_decile (
    p_start_date VARCHAR(10),
    p_end_date VARCHAR(10),
    p_fund_code VARCHAR(50),
    p_risk_free_return DOUBLE
) BEGIN DECLARE v_entry_date DATE;

DECLARE v_entry_date1 DATE;

DECLARE v_closing_nav DOUBLE;

DECLARE v_closing_nav1 DOUBLE;

DECLARE v_closing_value DOUBLE;

DECLARE v_closing_value1 DOUBLE;

DECLARE v_STDate DATE;

DECLARE v_LastDate DATE;

DECLARE v_NAV_CHANGE_AVG DOUBLE;

DECLARE v_INDEX_CHANGE_AVG DOUBLE;

DECLARE v_SUM_multiple_nclv_iclv DOUBLE;

DECLARE v_COVARIENCE DOUBLE;

DECLARE v_VARIENCE DOUBLE;

DECLARE v_CL_ST DOUBLE;

DECLARE v_CL_EN DOUBLE;

DECLARE v_IV_ST DOUBLE;

DECLARE v_IV_EN DOUBLE;

DECLARE v_volatility DOUBLE;

DECLARE v_TrackingErr DOUBLE;

DECLARE v_Day INT;

DECLARE v_CAGR DOUBLE;

DECLARE v_pow DOUBLE;

DECLARE v_Portfolio_Return DOUBLE;

DECLARE v_Market_Return DOUBLE;

DECLARE v_Beta DOUBLE;

DECLARE v_cnt BIGINT;

DECLARE v_H247 DOUBLE;

DECLARE v_H247CNT DOUBLE;

DECLARE v_L13 DOUBLE;

DECLARE v_P35 DOUBLE;

DECLARE v_X DOUBLE;

DECLARE v_Y DOUBLE;

DECLARE v_XY DOUBLE;

DECLARE v_X2 DOUBLE;

DECLARE v_Y2 DOUBLE;

DECLARE v_O11 DOUBLE;

DECLARE v_O13X DOUBLE;

DECLARE v_O13Y DOUBLE;

DECLARE v_O13 DOUBLE;

DECLARE v_B4 DOUBLE;

DECLARE v_B6 DOUBLE;

DECLARE MYCURSOR CURSOR FOR
SELECT
    entry_date,
    closing_nav,
    closing_value
FROM
    tmp_fund_master;

DECLARE MYCURSOR1 CURSOR FOR
SELECT
    entry_date,
    closing_nav,
    closing_value
FROM
    tmp_fund_master
WHERE
    entry_date < v_LastDate;

CREATE TEMPORARY TABLE tmp_fund_master (
    entry_date DATE,
    closing_value DOUBLE NULL,
    closing_nav DOUBLE NULL,
    nav_change DOUBLE NULL,
    index_change DOUBLE NULL,
    nav_change_less_avg DOUBLE NULL,
    index_change_less_Avg DOUBLE NULL,
    multiple_nclv_iclv DOUBLE NULL
);

INSERT INTO
    tmp_fund_master (entry_date, closing_value, closing_nav)
select
    i.entry_date,
    ifnull(i.closing_value, 0.00),
    ifnull(f.closing_nav, 0.00)
from
    mpx_fund_detail f
    inner join mpx_fund_master m on m.fund_code = f.fund_code
    inner join mpx_indices_detail i on i.entry_date = f.entry_date
    and i.name = m.indices_name
where
    m.fund_code = p_fund_code
    and f.closing_nav > 0
    and i.holiday = 0
    and i.entry_date between STR_TO_DATE(p_start_date, 103)
    and STR_TO_DATE(p_end_date, 103)
order by
    1 desc;

SET
    v_STDate = (
        SELECT
            entry_date
        FROM
            tmp_fund_master
        order by
            entry_date
        LIMIT
            1
    );

SET
    v_LastDate = (
        SELECT
            entry_date
        FROM
            tmp_fund_master
        order by
            entry_date desc
        LIMIT
            1
    );

OPEN MYCURSOR;

OPEN MYCURSOR1;

FETCH MYCURSOR INTO v_entry_date,
v_closing_nav,
v_closing_value;

FETCH MYCURSOR1 INTO v_entry_date1,
v_closing_nav1,
v_closing_value1;

WHILE FETCH_STATUS = 0 DO
UPDATE
    tmp_fund_master
SET
    index_change = (
        (v_closing_value - v_closing_value1) / v_closing_value1
    ) * 100,
    nav_change = (
        (v_closing_nav - v_closing_nav1) / v_closing_nav1
    ) * 100
WHERE
    entry_date = v_entry_date;

FETCH MYCURSOR INTO v_entry_date,
v_closing_nav,
v_closing_value;

FETCH MYCURSOR1 INTO v_entry_date1,
v_closing_nav1,
v_closing_value1;

END WHILE;

CLOSE MYCURSOR;

CLOSE MYCURSOR1;

SELECT
    closing_nav,
    closing_value INTO v_CL_ST,
    v_IV_ST
FROM
    tmp_fund_master
where
    entry_date = v_STDate;

SELECT
    closing_nav,
    closing_value INTO v_CL_EN,
    v_IV_EN
FROM
    tmp_fund_master
where
    entry_date = v_LastDate;

SELECT
    STDEV(closing_nav) INTO v_volatility
FROM
    tmp_fund_master;

SET
    v_Day = TIMESTAMPDIFF(
        DAY,
        STR_TO_DATE(p_start_date, 103),
        STR_TO_DATE(p_end_date, 103)
    );

SET
    p_risk_free_return = p_risk_free_return / 365;

IF v_Day > 365 THEN
SET
    v_pow = v_Day / 365.0;

ELSE
SET
    v_pow = 1;

END IF;

SET
    v_pow = 1.0 / v_pow;

SET
    v_CAGR = (POWER((v_CL_EN / v_CL_ST), v_pow) - 1) * 100;

DELETE FROM
    tmp_fund_master
WHERE
    entry_date = v_STDate;

SET
    v_cnt = (
        SELECT
            COUNT(index_change)
        FROM
            tmp_fund_master
    );

SELECT
    AVG(IFNULL(nav_change, 0)),
    AVG(IFNULL(index_change, 0)) INTO v_NAV_CHANGE_AVG,
    v_INDEX_CHANGE_AVG
FROM
    tmp_fund_master;

UPDATE
    tmp_fund_master
SET
    nav_change_less_avg = IFNULL(nav_change, 0) - v_NAV_CHANGE_AVG,
    index_change_less_Avg = IFNULL(index_change, 0) - v_INDEX_CHANGE_AVG;

UPDATE
    tmp_fund_master
SET
    multiple_nclv_iclv = IFNULL(nav_change_less_avg, 0) * IFNULL(index_change_less_Avg, 0);

SELECT
    SUM(multiple_nclv_iclv) INTO v_SUM_multiple_nclv_iclv
FROM
    tmp_fund_master;

SET
    v_COVARIENCE = v_SUM_multiple_nclv_iclv / v_cnt;

SELECT
    VAR(index_change) INTO v_VARIENCE
FROM
    tmp_fund_master;

SET
    v_Beta = v_COVARIENCE / v_VARIENCE;

SET
    v_Portfolio_Return = ((v_CL_EN - v_CL_ST) / v_CL_ST) * 100;

SET
    v_Market_Return = ((v_IV_EN - v_IV_ST) / v_IV_ST) * 100;

SELECT
    SUM(POWER(nav_change - index_change, 2)) INTO v_H247
FROM
    tmp_fund_master;

SET
    v_H247CNT = (v_H247 / v_cnt);

SET
    v_TrackingErr = CASE
        WHEN v_H247CNT > 0 THEN SQRT(v_H247CNT)
        ELSE 0
    END;

SET
    v_L13 = v_Market_Return - p_risk_free_return;

SET
    v_L13 = v_L13 * v_Beta;

SET
    v_P35 = (v_Portfolio_Return - p_risk_free_return);

SET
    v_X = (
        SELECT
            SUM(closing_nav)
        FROM
            tmp_fund_master
    );

SET
    v_Y = (
        SELECT
            SUM(closing_value)
        FROM
            tmp_fund_master
    );

SET
    v_XY = (
        SELECT
            SUM(closing_nav * closing_value)
        FROM
            tmp_fund_master
    );

SET
    v_X2 = (
        SELECT
            SUM(POWER(closing_nav, 2))
        FROM
            tmp_fund_master
    );

SET
    v_Y2 = (
        SELECT
            SUM(POWER(closing_value, 2))
        FROM
            tmp_fund_master
    );

SET
    v_O11 = ((v_cnt * v_XY) - (v_X * v_Y));

SET
    v_O13X = (v_cnt * v_X2) - POWER(v_X, 2);

SET
    v_O13Y = (v_cnt * v_Y2) - POWER(v_Y, 2);

SET
    v_O13 = CASE
        WHEN (
            v_O13X > 0
            AND v_O13Y > 0
        ) THEN SQRT(v_O13X) * SQRT(v_O13Y)
        ELSE 0
    END;

SELECT
    AVG(nav_change - p_risk_free_return),
    STDEV(nav_change) INTO v_B4,
    v_B6
FROM
    tmp_fund_master;

INSERT INTO
    final_ratio_data (
        fund_code,
        variance,
        beta_value,
        stdev_value,
        tracking_value,
        sharpe_value,
        treynor_value,
        rsquare_value,
        jensen_value,
        inf_value,
        cagr_value
    )
SELECT
    p_fund_code,
    VAR(index_change) AS "Variance",
    v_Beta AS "Beta",
    v_volatility AS "Volatility",
    v_TrackingErr AS "Tracking error",
    CASE
        WHEN (
            v_B6 = 0
            OR v_B6 = null
        ) THEN null
        ELSE (v_B4 / v_B6)
    END AS "Sharpe ratio",
    CASE
        WHEN (
            v_Beta = 0
            or v_Beta = null
        ) THEN null
        ELSE (v_B4 / v_Beta)
    END AS "Treynor Ratio",
    CASE
        WHEN (
            v_O13 = 0
            or v_O13 = null
        ) THEN null
        ELSE POWER(v_O11 / v_O13, 2)
    END AS 'R-SQR',
    (v_P35 - v_L13) AS "Alpha",
    CASE
        WHEN (
            v_TrackingErr = 0
            or v_TrackingErr = null
        ) THEN null
        ELSE (
            (v_Portfolio_Return - v_Market_Return) / v_TrackingErr
        )
    END AS "Information Ratio",
    v_CAGR AS "CAGR"
FROM
    tmp_fund_master;

DROP TABLE tmp_fund_master;

END;

/ / DELIMITER;