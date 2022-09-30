DELIMITER / / CREATE PROCEDURE sp_get_beta1 (
    p_start_date VARCHAR(10),
    p_end_date VARCHAR(10),
    p_fund_code VARCHAR(50),
    p_risk_free_return DOUBLE
) BEGIN DECLARE NOT_FOUND INT DEFAULT 0;

DECLARE v_entry_date DATE;

DECLARE v_entry_date1 DATE;

DECLARE v_closing_nav DOUBLE;

DECLARE v_closing_nav1 DOUBLE;

DECLARE v_closing_value DOUBLE;

DECLARE v_closing_value1 DOUBLE;

DECLARE v_std_date DATE;

DECLARE v_last_date DATE;

DECLARE v_NAV_CHANGE_AVG DOUBLE;

DECLARE v_index_change_avg DOUBLE;

DECLARE v_sum_multiple_nclv_iclv DOUBLE;

DECLARE v_covarience DOUBLE;

DECLARE v_varience DOUBLE;

DECLARE v_cl_st DOUBLE;

DECLARE v_cl_en DOUBLE;

DECLARE v_iv_st DOUBLE;

DECLARE v_iv_en DOUBLE;

DECLARE v_volatility DOUBLE;

DECLARE v_tracking_err DOUBLE;

DECLARE v_day INT;

DECLARE v_cagr DOUBLE;

DECLARE v_pow DOUBLE;

DECLARE v_portfolio_return DOUBLE;

DECLARE v_market_return DOUBLE;

DECLARE v_beta DOUBLE;

DECLARE v_cnt BIGINT;

DECLARE v_h247 DOUBLE;

DECLARE v_h247cnt DOUBLE;

DECLARE v_l13 DOUBLE;

DECLARE v_p35 DOUBLE;

DECLARE v_X DOUBLE;

DECLARE v_Y DOUBLE;

DECLARE v_xy DOUBLE;

DECLARE v_x2 DOUBLE;

DECLARE v_y2 DOUBLE;

DECLARE v_o11 DOUBLE;

DECLARE v_o13x DOUBLE;

DECLARE v_o13y DOUBLE;

DECLARE v_o13 DOUBLE;

DECLARE v_b4 DOUBLE;

DECLARE v_b6 DOUBLE;

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
    entry_date < v_last_date;

DECLARE CONTINUE HANDLER FOR NOT FOUND
SET
    NOT_FOUND = 1;

CREATE TEMPORARY TABLE tmp_fund_master (
    entry_date DATE,
    closing_value DOUBLE NULL,
    closing_nav DOUBLE NULL,
    nav_change DOUBLE NULL,
    index_change DOUBLE NULL,
    nav_change_less_avg DOUBLE NULL,
    index_change_less_avg DOUBLE NULL,
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
    and i.indices_name = m.indices_name
where
    m.fund_code = p_fund_code
    and f.closing_nav > 0
    and i.holiday = 0
    and i.entry_date between STR_TO_DATE(p_start_date, 103)
    and STR_TO_DATE(p_end_date, 103)
order by
    1 desc;

SET
    v_std_date = (
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
    v_last_date = (
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

SET
    NOT_FOUND = 0;

OPEN MYCURSOR1;

FETCH MYCURSOR INTO v_entry_date,
v_closing_nav,
v_closing_value;

FETCH MYCURSOR1 INTO v_entry_date1,
v_closing_nav1,
v_closing_value1;

WHILE NOT_FOUND = 0 DO
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
    closing_value AS v_cl_st,
    v_iv_st
FROM
    tmp_fund_master
where
    entry_date = v_std_date;

SELECT
    closing_nav AS v_cl_en,
    closing_value AS v_iv_en
FROM
    tmp_fund_master
where
    entry_date = v_last_date;

SELECT
    STDEV(closing_nav) AS v_volatility
FROM
    tmp_fund_master;

SET
    v_day = TIMESTAMPDIFF(
        DAY,
        STR_TO_DATE(p_start_date, 103),
        STR_TO_DATE(p_end_date, 103)
    );

SET
    p_risk_free_return = ((p_risk_free_return / 365) * v_day);

IF v_day > 365 THEN
SET
    v_pow = v_day / 365.0;

ELSE
SET
    v_pow = 1;

END IF;

SET
    v_pow = 1.0 / v_pow;

SET
    v_cagr = (POWER((v_cl_en / v_cl_st), v_pow) - 1) * 100;

DELETE FROM
    tmp_fund_master
WHERE
    entry_date = v_std_date;

SET
    v_cnt = (
        SELECT
            COUNT(index_change)
        FROM
            tmp_fund_master
    );

SELECT
    AVG(IFNULL(nav_change, 0)) AS v_NAV_CHANGE_AVG,
    AVG(IFNULL(index_change, 0)) AS v_index_change_avg
FROM
    tmp_fund_master;

UPDATE
    tmp_fund_master
SET
    nav_change_less_avg = IFNULL(nav_change, 0) - v_NAV_CHANGE_AVG,
    index_change_less_avg = IFNULL(index_change, 0) - v_index_change_avg;

UPDATE
    tmp_fund_master
SET
    multiple_nclv_iclv = IFNULL(nav_change_less_avg, 0) * IFNULL(index_change_less_avg, 0);

SELECT
    SUM(multiple_nclv_iclv) AS v_sum_multiple_nclv_iclv
FROM
    tmp_fund_master;

SET
    v_covarience = v_sum_multiple_nclv_iclv / v_cnt;

SELECT
    VAR(index_change) AS v_varience
FROM
    tmp_fund_master;

SET
    v_beta = v_covarience / v_varience;

SET
    v_portfolio_return = ((v_cl_en - v_cl_st) / v_cl_st) * 100;

SET
    v_market_return = ((v_iv_en - v_iv_st) / v_iv_st) * 100;

SELECT
    SUM(POWER(nav_change - index_change, 2)) AS v_h247
FROM
    tmp_fund_master;

SET
    v_h247cnt = (v_h247 / v_cnt);

SET
    v_tracking_err = CASE
        WHEN v_h247cnt > 0 THEN SQRT(v_h247cnt)
        ELSE 0
    END;

SET
    v_l13 = v_market_return - p_risk_free_return;

SET
    v_l13 = v_l13 * v_beta;

SET
    v_p35 = (v_portfolio_return - p_risk_free_return);

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
    v_xy = (
        SELECT
            SUM(closing_nav * closing_value)
        FROM
            tmp_fund_master
    );

SET
    v_x2 = (
        SELECT
            SUM(POWER(closing_nav, 2))
        FROM
            tmp_fund_master
    );

SET
    v_y2 = (
        SELECT
            SUM(POWER(closing_value, 2))
        FROM
            tmp_fund_master
    );

SET
    v_o11 = ((v_cnt * v_xy) - (v_X * v_Y));

SET
    v_o13x = (v_cnt * v_x2) - POWER(v_X, 2);

SET
    v_o13y = (v_cnt * v_y2) - POWER(v_Y, 2);

SET
    v_o13 = CASE
        WHEN (
            v_o13x > 0
            AND v_o13y > 0
        ) THEN SQRT(v_o13x) * SQRT(v_o13y)
        ELSE 0
    END;

SELECT
    AVG(nav_change - p_risk_free_return) AS v_b4,
    STDEV(nav_change) AS v_b6
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
    v_beta AS "Beta",
    v_volatility AS "Volatility",
    v_tracking_err AS "Tracking error",
    CASE
        WHEN (
            v_b6 = 0
            OR v_b6 = null
        ) THEN null
        ELSE (v_b4 / v_b6)
    END AS "Sharpe ratio",
    CASE
        WHEN (
            v_beta = 0
            or v_beta = null
        ) THEN null
        ELSE (v_b4 / v_beta)
    END AS "Treynor Ratio",
    CASE
        WHEN (
            v_o13 = 0
            or v_o13 = null
        ) THEN null
        ELSE POWER(v_o11 / v_o13, 2)
    END AS 'R-SQR',
    (v_p35 - v_l13) AS "Alpha",
    CASE
        WHEN (
            v_tracking_err = 0
            or v_tracking_err = null
        ) THEN null
        ELSE (
            (v_portfolio_return - v_market_return) / v_tracking_err
        )
    END AS "Information Ratio",
    v_cagr AS "CAGR"
FROM
    tmp_fund_master;

DROP TABLE tmp_fund_master;

END;

/ / DELIMITER;