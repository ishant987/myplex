DELIMITER / / CREATE PROCEDURE sp_return_rsquare() BEGIN
INSERT INTO
	final_ratio_data (fund_code, rsquare_value)
SELECT
	RSQUAREDATA.fund_code,
	CASE
		WHEN (RSQUAREDATA.STDFUND * STDINDEX) <> 0 THEN (
			(RSQUAREDATA.COVAR / RSQUAREDATA.DATACOUNT) / (RSQUAREDATA.STDFUND * STDINDEX)
		)
		WHEN (RSQUAREDATA.STDFUND * STDINDEX) = 0 THEN 0
	END AS "RSQUARE"
FROM
	(
		SELECT
			FINALDATA.fund_code,
			SUM(FINALDATA.CALCVALUES) AS COVAR,
			COUNT(FINALDATA.fund_code) AS DATACOUNT,
			STDEV(FINALDATA.fund_closing) AS STDFUND,
			STDEV(FINALDATA.indices_closing) AS STDINDEX
		FROM
			(
				SELECT
					DATASOURCE.fund_code,
					DATASOURCE.fund_closing,
					DATASOURCE.indices_closing,
					(
						(DATASOURCE.fund_closing - DATASOURCE.AVGFUND) * (DATASOURCE.indices_closing - DATASOURCE.AVGINDEX)
					) AS CALCVALUES
				FROM
					(
						SELECT
							tmp_ratio_data.fund_code,
							tmp_ratio_data.fund_closing,
							X.AVGFUND,
							tmp_ratio_data.indices_closing,
							X.AVGINDEX
						FROM
							tmp_ratio_data
							INNER JOIN (
								SELECT
									fund_code,
									AVG(fund_closing) AS AVGFUND,
									AVG(indices_closing) AS AVGINDEX
								FROM
									tmp_ratio_data
								GROUP BY
									fund_code
							) X ON tmp_ratio_data.fund_code = X.fund_code
					) DATASOURCE
			) FINALDATA
		GROUP BY
			FINALDATA.fund_code
	) RSQUAREDATA
WHERE
	RSQUAREDATA.DATACOUNT <> 0;

END;

/ / DELIMITER;