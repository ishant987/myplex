DELIMITER / / CREATE PROCEDURE sp_return_treynor() BEGIN
UPDATE
	(
		SELECT
			TREYNORONE.fund_code,
			AVG(TREYNORONE.CALCPER) AS AVGCALCPER
		FROM
			(
				SELECT
					tmp_ratio_data.fund_code,
					(tmp_ratio_data.fund_per - Y.FRISKFREE) AS CALCPER
				FROM
					tmp_ratio_data
					INNER JOIN (
						SELECT
							X.fund_code,
							((X.risk_free_return * 0.01) / 365) AS FRISKFREE
						FROM
							(
								SELECT
									DISTINCT fund_code,
									risk_free_return
								FROM
									tmp_ratio_data
							) X
					) Y ON tmp_ratio_data.fund_code = Y.fund_code
			) TREYNORONE
		GROUP BY
			TREYNORONE.fund_code
	) FINALDATA
	INNER JOIN final_ratio_data ON final_ratio_data.fund_code = FINALDATA.fund_code
SET
	TREYNORVALUE = FINALDATA.AVGCALCPER / final_ratio_data.beta_value
WHERE
	final_ratio_data.beta_value <> 0;

END;

/ / DELIMITER;