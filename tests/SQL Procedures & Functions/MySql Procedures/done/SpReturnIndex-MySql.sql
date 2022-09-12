DELIMITER / / CREATE PROCEDURE sp_return_index (p_input_type INT, p_term DOUBLE) BEGIN IF p_input_type = 1 THEN
INSERT INTO
	final_ratio_data (fund_code, return_value_index)
SELECT
	RETURNDATA.fund_code,
	CASE
		WHEN RETURNDATA.FUNDTOP <> 0 THEN (
			(
				(RETURNDATA.FUNDBOTTOM - RETURNDATA.FUNDTOP) / RETURNDATA.FUNDTOP
			) / p_term
		) * 100
		WHEN RETURNDATA.FUNDTOP = 0 THEN 0
	END AS "RETURNVALUE"
FROM
	(
		SELECT
			X.fund_code,
			(
				SELECT
					indices_closing
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
					indices_closing
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
	) RETURNDATA;

END IF;

IF p_input_type = 2 THEN
UPDATE
	(
		SELECT
			RETURNDATA.fund_code,
			CASE
				WHEN RETURNDATA.FUNDTOP <> 0 THEN (
					(RETURNDATA.FUNDBOTTOM - RETURNDATA.FUNDTOP) / RETURNDATA.FUNDTOP
				) * 100
				WHEN RETURNDATA.FUNDTOP = 0 THEN 0
			END AS "RETURNVALUE"
		FROM
			(
				SELECT
					X.fund_code,
					(
						SELECT
							indices_closing
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
							indices_closing
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
	) RETURNUPDATE
	INNER JOIN final_ratio_data ON final_ratio_data.fund_code = RETURNUPDATE.fund_code
SET
	final_ratio_data.return_value_index = RETURNUPDATE.RETURNVALUE;

END IF;

END;

/ / DELIMITER;