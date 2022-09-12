DELIMITER / / CREATE PROCEDURE sp_return_kurtosis() BEGIN
INSERT INTO
	final_ratio_data (fund_code, kurtosis_value)
SELECT
	Y.fund_code,
	`KURTOSIS` = (
		SELECT
			(
				SUMXXXX - 4 * SUMXXX * AVX + 6 * SUMXX * AVX * AVX - 4 * SUMX * AVX * AVX * AVX + CNX * AVX * AVX * AVX * AVX
			) / (SDX * SDX * SDX * SDX) * CNX * (CNX + 1) / (CNX - 1) / (CNX - 2) / (CNX - 3) - 3.0 * (CNX -1) * (CNX -1) / (CNX -2) / (CNX -3)
	)
FROM
	(
		SELECT
			X.fund_code,
			SUM(RFREEINDEX) AS SUMX,
			SUM(RFREEINDEX * RFREEINDEX) AS SUMXX,
			SUM(RFREEINDEX * RFREEINDEX * RFREEINDEX) AS SUMXXX,
			SUM(
				RFREEINDEX * RFREEINDEX * RFREEINDEX * RFREEINDEX
			) AS SUMXXXX,
			COUNT(RFREEINDEX) AS CNX,
			STDEV(RFREEINDEX) AS SDX,
			AVG(RFREEINDEX) AS AVX
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