DELIMITER / / CREATE PROCEDURE sp_fund_search_cat_decile (
    p_start_date VARCHAR(10),
    p_end_date VARCHAR(10),
    p_fund_code_input varchar(50)
) BEGIN DECLARE v_FunctionName VARCHAR(10);

DECLARE v_FundCode varchar(50);

SET
    v_FunctionName = 'RETURNS';

CREATE TEMPORARY TABLE quartile_data (
    fund_code VARCHAR(25) null,
    comp_value DOUBLE null,
    quartile INT null
);

CREATE TEMPORARY TABLE final_ratio_data (
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

CALL sp_get_quartile_decile(
    p_start_date,
    p_end_date,
    p_fund_code_input,
    6.5
);

IF v_FunctionName = 'RETURNS' THEN
INSERT INTO
    quartile_data (fund_code, comp_value)
SELECT
    final_ratio_data.fund_code,
    final_ratio_data.cagr_value
FROM
    final_ratio_data
where
    cagr_value is not null;

END IF;

CALL sp_decile_compute;

SELECT
    mpx_fund_master.fund_name,
    quartile_data.comp_value,
    quartile_data.quartile
FROM
    quartile_data
    INNER JOIN mpx_fund_master ON quartile_data.fund_code = mpx_fund_master.fund_code
    and quartile_data.fund_code = p_fund_code_input;

END;

/ / DELIMITER;