DELIMITER / / CREATE PROCEDURE sp_return_standard_deviation (p_input_type INT) BEGIN IF p_input_type = 1 THEN
INSERT INTO
	final_ratio_data (fund_code, stdev_value)
SELECT
	RETURNDATA.fund_code,
	STDEV(RETURNDATA.DAILYEXCESS) AS stdev_value
FROM
	(
		SELECT
			fund_code,
			fund_closing AS DAILYEXCESS
		FROM
			tmp_ratio_data
	) RETURNDATA
GROUP BY
	RETURNDATA.fund_code;

END IF;

IF p_input_type = 2 THEN
UPDATE
	(
		SELECT
			RETURNDATA.fund_code,
			STDEV(RETURNDATA.DAILYEXCESS) AS stdev_value
		FROM
			(
				SELECT
					fund_code,
					fund_closing AS DAILYEXCESS
				FROM
					tmp_ratio_data
			) RETURNDATA
		GROUP BY
			RETURNDATA.fund_code
	) X
	INNER JOIN final_ratio_data ON X.fund_code = final_ratio_data.fund_code
SET
	stdev_value = X.stdev_value;

END IF;

END;

/ / DELIMITER;