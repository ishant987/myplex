DELIMITER / / CREATE PROCEDURE sp_return_mean_average() BEGIN
INSERT INTO
	final_ratio_data (fund_code, mean_average)
SELECT
	tmp_ratio_data.fund_code,
	AVG(tmp_ratio_data.fund_closing) AS mean_avg_value
FROM
	tmp_ratio_data
GROUP BY
	tmp_ratio_data.fund_code;

END;

/ / DELIMITER;