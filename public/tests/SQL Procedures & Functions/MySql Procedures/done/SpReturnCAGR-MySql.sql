DELIMITER / / CREATE PROCEDURE sp_return_cagr (p_term DOUBLE) BEGIN
UPDATE
	(
		SELECT
			RETURNDATA.fund_code,
			CASE
				WHEN RETURNDATA.FUNDTOP <> 0 THEN (
					POWER(
						(RETURNDATA.FUNDBOTTOM / RETURNDATA.FUNDTOP),
						1 / p_term
					) - 1
				) * 100
				WHEN RETURNDATA.FUNDTOP = 0 THEN 0
			END AS "CAGRVALUE"
		FROM
			(
				SELECT
					X.fund_code,
					(
						SELECT
							fund_closing
						FROM
							tmp_ratio_data
						WHERE
							tmp_ratio_data.fund_code = X.fund_code
						ORDER BY
							entry_date ASC
						LIMIT
							1
					) AS FUNDTOP,
					(
						SELECT
							fund_closing
						FROM
							tmp_ratio_data
						WHERE
							tmp_ratio_data.fund_code = X.fund_code
						ORDER BY
							entry_date DESC
						LIMIT
							1
					) AS FUNDBOTTOM
				FROM
					(
						SELECT
							DISTINCT fund_code
						FROM
							tmp_ratio_data
					) X
			) RETURNDATA
	) CAGRDATA
	INNER JOIN final_ratio_data ON final_ratio_data.fund_code = CAGRDATA.fund_code
SET
	CAGRVALUE = CAGRDATA.CAGRVALUE;

END;

/ / DELIMITER;