DELIMITER / / CREATE PROCEDURE sp_return_co_eff_var() BEGIN
UPDATE
	(
		SELECT
			fund_code,
			((stdev_value / mean_average) * 100) AS coeffvar
		FROM
			final_ratio_data
		WHERE
			stdev_value <> 0
	) X
	INNER JOIN final_ratio_data ON final_ratio_data.fund_code = X.fund_code
SET
	final_ratio_data.coeffvar_value = X.coeffvar;

END;

/ / DELIMITER;