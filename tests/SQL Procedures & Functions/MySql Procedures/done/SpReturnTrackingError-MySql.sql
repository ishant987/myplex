DELIMITER / / CREATE PROCEDURE sp_return_tracking_error() BEGIN
INSERT INTO
	final_ratio_data (fund_code, tracking_value)
SELECT
	RETURNDATA.fund_code,
	STDEV(RETURNDATA.DAILYEXCESS) AS TRACKINGERROR
FROM
	(
		SELECT
			fund_code,
			(FUNDPER - INDICESPER) AS DAILYEXCESS
		FROM
			tmp_ratio_data
	) RETURNDATA
GROUP BY
	RETURNDATA.fund_code;

END;

/ / DELIMITER;