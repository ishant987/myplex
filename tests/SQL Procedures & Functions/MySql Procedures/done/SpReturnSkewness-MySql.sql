DELIMITER / / CREATE PROCEDURE sp_return_skewness() BEGIN
INSERT INTO
	final_ratio_data (fund_code, skew_value)
SELECT
	Y.fund_code,
	`SKEWNESS` = (
		SELECT
			(
				Y.SUMXXX - 3 * Y.SUMXX * Y.AVX + 3 * Y.SUMX * Y.AVX * Y.AVX - Y.CNX * Y.AVX * Y.AVX * Y.AVX
			) / (Y.SDX * Y.SDX * Y.SDX) * Y.CNX / (Y.CNX - 1) / (Y.CNX - 2)
	)
FROM
	(
		SELECT
			X.fund_code,
			SUM(X.RFREEINDEX) AS SUMX,
			SUM(X.RFREEINDEX * RFREEINDEX) AS SUMXX,
			SUM(X.RFREEINDEX * RFREEINDEX * RFREEINDEX) AS SUMXXX,
			COUNT(X.RFREEINDEX) AS CNX,
			STDEV(X.RFREEINDEX) AS SDX,
			AVG(X.RFREEINDEX) AS AVX
		FROM
			(
				SELECT
					tmp_ratio_data.fund_code,
					(
						(
							tmp_ratio_data.fund_per - tmp_ratio_data.indices_per
						) - (tmp_ratio_data.risk_free_return / 365)
					) AS RFREEINDEX
				FROM
					tmp_ratio_data
			) X
		GROUP BY
			X.fund_code
	) Y;

END;

/ / DELIMITER;