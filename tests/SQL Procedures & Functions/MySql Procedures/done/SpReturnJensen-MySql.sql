DELIMITER / / CREATE PROCEDURE sp_return_jensen() BEGIN
UPDATE
	(
		SELECT
			DISTINCT fund_code,
			risk_free_return,
			fund_term
		FROM
			tmp_ratio_data
	) JENSENDATA
	INNER JOIN final_ratio_data ON JENSENDATA.fund_code = final_ratio_data.fund_code
SET
	final_ratio_data.jensen_value = (final_ratio_data.return_value_nav / 100) - (
		(
			JENSENDATA.risk_free_return * JENSENDATA.fund_term * 0.01
		) + final_ratio_data.beta_value * (
			(final_ratio_data.return_value_index / 100) - (
				JENSENDATA.risk_free_return * JENSENDATA.fund_term * 0.01
			)
		)
	);

END;

/ / DELIMITER;