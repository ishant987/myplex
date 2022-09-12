DELIMITER / / CREATE PROCEDURE sp_performance_ranking_classification (
	p_start_date VARCHAR(10),
	p_end_date VARCHAR(10),
	p_type_id INT,
	p_function_name VARCHAR(25)
) BEGIN DECLARE v_CalcFactor DOUBLE;

CREATE TEMPORARY TABLE tmp_ratio_data (
	entry_date DATETIME(3),
	fund_code VARCHAR(25),
	indices VARCHAR(100),
	indices_closing DOUBLE,
	indices_per DOUBLE,
	fund_closing DOUBLE,
	fund_per DOUBLE,
	inception_date DATETIME(3),
	risk_free_return DOUBLE,
	fund_term DOUBLE
);

CREATE TEMPORARY TABLE final_ratio_data (
	fund_code VARCHAR(25),
	mean_average DOUBLE NULL,
	return_value_nav DOUBLE NULL,
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

INSERT INTO
	tmp_ratio_data (
		entry_date,
		fund_code,
		indices,
		indices_closing,
		indices_per,
		fund_closing,
		fund_per,
		inception_date,
		risk_free_return,
		fund_term
	)
SELECT
	FUNDTABLE.entry_date,
	FUNDTABLE.fund_code,
	mpx_indices_detail.name,
	mpx_indices_detail.closing_value AS indices_closing,
	mpx_indices_detail.percentage_change AS indices_per,
	FUNDTABLE.fund_closing,
	FUNDTABLE.fund_per,
	FUNDTABLE.inception_date,
	FUNDTABLE.risk_free_return,
	CAST(
		TIMESTAMPDIFF(
			DAY,
			FUNDTABLE.inception_date,
			STR_TO_DATE(p_end_date, 103)
		) AS DECIMAL(10, 5)
	) / 365 AS fund_term
FROM
	mpx_indices_detail
	INNER JOIN (
		SELECT
			mpx_fund_detail.entry_date,
			mpx_fund_detail.fund_code,
			X.indices_name,
			mpx_fund_detail.closing_nav AS fund_closing,
			mpx_fund_detail.percentage_change AS fund_per,
			X.inception_date,
			X.risk_free_return
		FROM
			mpx_fund_detail
			INNER JOIN (
				SELECT
					FISOURCE.fund_code,
					FISOURCE.indices_name,
					FISOURCE.risk_free_return,
					CASE
						WHEN FISOURCE.fund_opening <= FISOURCE.indices_opening THEN FISOURCE.indices_opening
						WHEN FISOURCE.fund_opening > FISOURCE.indices_opening THEN FISOURCE.fund_opening
					END AS "inception_date",
					CASE
						WHEN FISOURCE.fund_opening <= FISOURCE.indices_opening THEN TIMESTAMPDIFF(
							DAY,
							FISOURCE.fund_opening,
							STR_TO_DATE(p_end_date, 103)
						)
						WHEN FISOURCE.fund_opening > FISOURCE.indices_opening THEN TIMESTAMPDIFF(
							DAY,
							FISOURCE.indices_opening,
							STR_TO_DATE(p_end_date, 103)
						)
					END AS "TERM"
				FROM
					(
						SELECT
							FMASTER.fund_code,
							IMASTER.name AS indices_name,
							FMASTER.risk_free_return,
							CASE
								WHEN FMASTER.fund_op_date < STR_TO_DATE(p_start_date, 103) THEN STR_TO_DATE(p_start_date, 103)
								WHEN FMASTER.fund_op_date >= STR_TO_DATE(p_start_date, 103) THEN FMASTER.fund_op_date
							END AS "fund_opening",
							CASE
								WHEN IMASTER.indices_op_date < STR_TO_DATE(p_start_date, 103) THEN STR_TO_DATE(p_start_date, 103)
								WHEN IMASTER.indices_op_date >= STR_TO_DATE(p_start_date, 103) THEN IMASTER.indices_op_date
							END AS "indices_opening"
						FROM
							(
								SELECT
									fund_code,
									indices_name,
									risk_free_return,
									fund_opened AS fund_op_date
								FROM
									mpx_fund_master
								WHERE
									fund_type_id = p_type_id
									AND fund_opened <= STR_TO_DATE(p_start_date, 103)
							) FMASTER
							INNER JOIN (
								SELECT
									name,
									MIN(entry_date) AS indices_op_date
								FROM
									mpx_indices_detail
								GROUP BY
									name
							) IMASTER ON FMASTER.indices_name = IMASTER.name
					) FISOURCE
			) X ON mpx_fund_detail.fund_code = X.fund_code
		WHERE
			mpx_fund_detail.entry_date >= X.inception_date
			AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_end_date, 103)
			AND mpx_fund_detail.holiday = 0
	) FUNDTABLE ON mpx_indices_detail.name = FUNDTABLE.indices_name
	AND mpx_indices_detail.entry_date = FUNDTABLE.entry_date
WHERE
	mpx_indices_detail.entry_date >= FUNDTABLE.inception_date
	AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_end_date, 103)
	AND mpx_indices_detail.holiday = 0;

SET
	v_CalcFactor = TIMESTAMPDIFF(
		DAY,
		STR_TO_DATE(p_start_date, 103),
		STR_TO_DATE(p_end_date, 103)
	);

IF v_CalcFactor > 365 THEN
SET
	v_CalcFactor = v_CalcFactor / 365;

ELSE
SET
	v_CalcFactor = 1;

END IF;

IF p_function_name = 'BETA' THEN CALL sp_return_beta;

SELECT
	mpx_fund_master.fund_id,
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.beta_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.beta_value ASC;

END IF;

IF p_function_name = 'RETURNS' THEN CALL sp_return_nav(1, v_CalcFactor);

CALL sp_return_cagr(v_CalcFactor);

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.return_value_nav,
	final_ratio_data.cagr_value
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.return_value_nav DESC;

END IF;

IF p_function_name = 'JENSEN' THEN CALL sp_return_beta;

CALL sp_return_nav(2, v_CalcFactor);

CALL sp_return_index(2, v_CalcFactor);

CALL sp_return_jensen;

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.jensen_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.jensen_value DESC;

END IF;

IF p_function_name = 'SHARPE' THEN CALL sp_return_sharpe;

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.sharpe_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.sharpe_value DESC;

END IF;

IF p_function_name = 'TRACKINGERROR' THEN CALL sp_return_tracking_error;

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.tracking_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.tracking_value ASC;

END IF;

IF p_function_name = 'INFRATIO' THEN CALL sp_return_information_ratio;

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.inf_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.inf_value DESC;

END IF;

IF p_function_name = 'STDDEV' THEN CALL sp_return_standard_deviation(1);

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.stdev_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.stdev_value ASC;

END IF;

IF p_function_name = 'RSQUARE' THEN CALL sp_return_rsquare;

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.rsquare_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.rsquare_value DESC;

END IF;

IF p_function_name = 'TREYNOR' THEN CALL sp_return_beta;

CALL sp_return_treynor;

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.treynor_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.treynor_value DESC;

END IF;

IF p_function_name = 'SKEWNESS' THEN CALL sp_return_skewness;

SELECT
	mpx_fund_master.fund_name,
	final_ratio_data.skew_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.skew_value;

END IF;

IF p_function_name = 'KURTOSIS' THEN CALL sp_return_kurtosis;

SELECT
	mpx_fund_master.fund_name,
	final_ratio_data.kurtosis_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.kurtosis_value;

END IF;

IF p_function_name = 'COEFFVAR' THEN CALL sp_return_mean_average;

CALL sp_return_standard_deviation(2);

CALL sp_return_co_eff_var;

SELECT
	mpx_fund_master.fund_code,
	mpx_fund_master.fund_name,
	final_ratio_data.coeffvar_value AS ratio
FROM
	final_ratio_data
	INNER JOIN mpx_fund_master ON final_ratio_data.fund_code = mpx_fund_master.fund_code
ORDER BY
	final_ratio_data.coeffvar_value;

END IF;

END;

/ / DELIMITER;