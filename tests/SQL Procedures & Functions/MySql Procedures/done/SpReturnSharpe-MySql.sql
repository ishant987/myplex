DELIMITER / / CREATE PROCEDURE sp_return_sharpe() BEGIN
INSERT INTO
	final_ratio_data (fund_code, sharpe_value)
SELECT
	CALCSHARPE.fund_code,
	(CALCSHARPE.AVGEXCESSRISKFREE / CALCSHARPE.STDDEV) AS "SHARPEVALUE"
FROM
	(
		SELECT
			SEMISHARPE.fund_code,
			AVG(SEMISHARPE.EXCESSRISKFREE) AS AVGEXCESSRISKFREE,
			SQRT(SEMISHARPE.FSTDDEV) AS STDDEV
		FROM
			(
				SELECT
					XX.fund_code,
					(XX.fund_per - XX.COMPUTEDRISKFREE) AS EXCESSRISKFREE,
					CASE
						WHEN (XX.DATACOUNT * (XX.DATACOUNT - 1)) <> 0 THEN ((XX.DATACOUNT * XX.SUMSQUARE) - XX.SQUARESUM) / (XX.DATACOUNT * (XX.DATACOUNT - 1))
						WHEN (XX.DATACOUNT * (XX.DATACOUNT - 1)) = 0 THEN 0
					END AS "FSTDDEV"
				FROM
					(
						SELECT
							Z.fund_code,
							Z.SUMSQUARE,
							Z.SQUARESUM,
							Z.DATACOUNT,
							Z.COMPUTEDRISKFREE,
							tmp_ratio_data.fund_per
						FROM
							(
								SELECT
									Y.fund_code,
									Y.SUMSQUARE,
									Y.SQUARESUM,
									(
										SELECT
											(RISKFREERETURN * 0.01) / 365 AS COMPUTEDRISKFREE
										FROM
											tmp_ratio_data
										WHERE
											tmp_ratio_data.fund_code = Y.fund_code
										LIMIT
											1
									) AS "COMPUTEDRISKFREE",
									(
										SELECT
											COUNT(*)
										FROM
											tmp_ratio_data
										WHERE
											tmp_ratio_data.fund_code = Y.fund_code
									) AS "DATACOUNT"
								FROM
									(
										SELECT
											tmp_ratio_data.fund_code,
											SUM(POWER(tmp_ratio_data.fund_closing, 2)) AS SUMSQUARE,
											POWER(SUM(tmp_ratio_data.fund_closing), 2) AS SQUARESUM
										FROM
											tmp_ratio_data
										GROUP BY
											tmp_ratio_data.fund_code
									) Y
							) Z
							INNER JOIN tmp_ratio_data ON Z.fund_code = tmp_ratio_data.fund_code
					) XX
			) SEMISHARPE
		GROUP BY
			SEMISHARPE.fund_code,
			SEMISHARPE.FSTDDEV
	) CALCSHARPE
WHERE
	CALCSHARPE.STDDEV <> 0;

END;

/ / DELIMITER;