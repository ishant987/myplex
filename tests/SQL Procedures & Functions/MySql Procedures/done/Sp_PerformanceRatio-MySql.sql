DELIMITER / / CREATE PROCEDURE sp_performance_ratio (
    p_start_date VARCHAR(10),
    p_end_date VARCHAR(10),
    p_function_name VARCHAR(25),
    p_risk_free_return double
) BEGIN DECLARE v_fund_code VARCHAR(50);

DECLARE CURSOR1 CURSOR FOR
SELECT
    c.fund_code
FROM
    tmp_fund_codes AS c
    INNER JOIN mpx_fund_master m ON c.fund_code = m.fund_code
where
    fund_opened <= STR_TO_DATE(p_start_date, 103);

IF p_function_name = 'SKEWNESS' THEN CALL sp_performance_ranking_individual(v_start_date, v_end_date, v_function_name);

ELSEIF p_function_name = 'KURTOSIS' THEN CALL sp_performance_ranking_individual(v_start_date, v_end_date, v_function_name);

ELSEIF p_function_name = 'COEFFVAR' THEN CALL sp_performance_ranking_individual(v_start_date, v_end_date, v_function_name);

ELSE CREATE TEMPORARY TABLE final_ratio_data (
    fund_code VARCHAR(25),
    covar DOUBLE NULL,
    variance DOUBLE NULL,
    return_value_index DOUBLE NULL,
    cagr_value DOUBLE NULL,
    beta_value DOUBLE NULL,
    jensen_value DOUBLE NULL,
    sharpe_value DOUBLE NULL,
    tracking_value DOUBLE NULL,
    inf_value DOUBLE NULL,
    stdev_value DOUBLE NULL,
    rsquare_value DOUBLE NULL,
    treynor_value DOUBLE NULL,
    skew_value DOUBLE NULL,
    kurtosis_value DOUBLE NULL,
    coeffvar_value DOUBLE NULL,
    riskadj_value DOUBLE NULL
);

OPEN CURSOR1;

FETCH CURSOR1 INTO v_fund_code;

WHILE FETCH_STATUS = 0 DO CALL sp_get_beta1(
    p_start_date,
    p_end_date,
    v_fund_code,
    p_risk_free_return
);

FETCH CURSOR1 INTO v_fund_code;

END WHILE;

CLOSE CURSOR1;

END IF;

IF p_function_name = 'BETA' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.beta_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    beta_value is not null
ORDER BY
    final_ratio_data.beta_value ASC;

END IF;

IF p_function_name = 'RETURNS' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.cagr_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    cagr_value is not null
ORDER BY
    final_ratio_data.cagr_value DESC;

END IF;

IF p_function_name = 'JENSEN' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.jensen_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    jensen_value is not null
ORDER BY
    final_ratio_data.jensen_value DESC;

END IF;

IF p_function_name = 'SHARPE' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.sharpe_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    sharpe_value is not null
ORDER BY
    final_ratio_data.sharpe_value DESC;

END IF;

IF p_function_name = 'TRACKINGERROR' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.tracking_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    tracking_value is not null
ORDER BY
    final_ratio_data.tracking_value ASC;

END IF;

IF p_function_name = 'INFRATIO' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.inf_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    inf_value is not null
ORDER BY
    final_ratio_data.inf_value DESC;

END IF;

IF p_function_name = 'STDDEV' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.stdev_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    stdev_value is not null
ORDER BY
    final_ratio_data.stdev_value ASC;

END IF;

IF p_function_name = 'RSQUARE' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.rsquare_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    rsquare_value is not null
ORDER BY
    final_ratio_data.rsquare_value DESC;

END IF;

IF p_function_name = 'TREYNOR' THEN
SELECT
    mpx_fund_master.fund_code,
    mpx_fund_master.fund_name,
    final_ratio_data.treynor_value AS ratio
FROM
    final_ratio_data
    INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
where
    treynor_value is not null
ORDER BY
    final_ratio_data.treynor_value DESC;

END IF;

END;

/ / DELIMITER;