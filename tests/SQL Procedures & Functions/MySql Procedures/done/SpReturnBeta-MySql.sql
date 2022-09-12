DELIMITER / / CREATE PROCEDURE sp_return_beta() BEGIN CREATE TEMPORARY TABLE sorted_data (
	fund_code VARCHAR(25),
	entry_date DATETIME(3),
	fund_closing DOUBLE,
	indices_closing DOUBLE
);

INSERT INTO
	sorted_data (
		fund_code,
		entry_date,
		fund_closing,
		indices_closing
	)
SELECT
	DATASOURCEONE.fund_code,
	DATASOURCEONE.entry_date,
	DATASOURCEONE.fund_closing,
	DATASOURCEONE.indices_closing
FROM
	(
		SELECT
			tmp_ratio_data.fund_code,
			tmp_ratio_data.entry_date,
			tmp_ratio_data.fund_closing,
			tmp_ratio_data.indices_closing
		FROM
			tmp_ratio_data,
			(
				SELECT
					fund_code,
					MONTH(entry_date) AS MONTHNAME,
					YEAR(entry_date) AS YEARNAME
				FROM
					tmp_ratio_data
				GROUP BY
					fund_code,
					MONTH(entry_date),
					YEAR(entry_date)
			) FUNDFILTER
		WHERE
			tmp_ratio_data.fund_code = FUNDFILTER.fund_code
			AND tmp_ratio_data.entry_date IN (
				SELECT
					MIN(tmp_ratio_data.entry_date)
				FROM
					tmp_ratio_data
				WHERE
					MONTH(tmp_ratio_data.entry_date) = FUNDFILTER.MONTHNAME
					AND YEAR(tmp_ratio_data.entry_date) = FUNDFILTER.YEARNAME
					AND tmp_ratio_data.fund_code = FUNDFILTER.fund_code
			)
	) DATASOURCEONE;

INSERT INTO
	final_ratio_data (fund_code, beta_value)
SELECT
	BETADATA.fund_code,
	CASE
		WHEN BETADATA.BETABOTTOM <> 0 THEN BETADATA.BETATOP / BETADATA.BETABOTTOM
		WHEN BETADATA.BETABOTTOM = 0 THEN 0
	END AS "beta_value"
FROM
	(
		SELECT
			FINALBETA.fund_code,
			`BETATOP` = (FINALBETA.DATACOUNT * FINALBETA.INDEXNAV) - (FINALBETA.NAVSUM * FINALBETA.INDEXSUM),
			"BETABOTTOM" = (FINALBETA.DATACOUNT * FINALBETA.NAVSQUARE) - (FINALBETA.NAVSUM * FINALBETA.NAVSUM)
		FROM
			(
				SELECT
					SEMIBETA.fund_code,
					`NAVSUM` = SUM(SEMIBETA.BETANAV),
					`INDEXSUM` = SUM(SEMIBETA.BETAINDEX),
					`NAVSQUARE` = SUM(POWER(SEMIBETA.BETANAV, 2)),
					`INDEXNAV` = SUM(SEMIBETA.BETANAV * SEMIBETA.BETAINDEX),
					`DATACOUNT` = COUNT(SEMIBETA.BETANAV)
				FROM
					(
						SELECT
							DATASOURCETWO.fund_code,
							DATASOURCETWO.entry_date,
							CASE
								WHEN DATASOURCETWO.PREVfund_closing <> 0
								AND DATASOURCETWO.fund_closing <> 0 THEN (
									(
										DATASOURCETWO.fund_closing - DATASOURCETWO.PREVfund_closing
									) / DATASOURCETWO.PREVfund_closing
								) * 100
								WHEN DATASOURCETWO.PREVfund_closing = 0
								OR DATASOURCETWO.fund_closing = 0 THEN 0
							END AS "BETANAV",
							CASE
								WHEN DATASOURCETWO.PREVINDEXCLOSING <> 0
								AND DATASOURCETWO.indices_closing <> 0 THEN (
									(
										DATASOURCETWO.indices_closing - DATASOURCETWO.PREVINDEXCLOSING
									) / DATASOURCETWO.PREVINDEXCLOSING
								) * 100
								WHEN DATASOURCETWO.PREVINDEXCLOSING = 0
								OR DATASOURCETWO.indices_closing = 0 THEN 0
							END AS "BETAINDEX"
						FROM
							(
								SELECT
									DATASOURCEONE.fund_code,
									DATASOURCEONE.entry_date,
									DATASOURCEONE.fund_closing,
									DATASOURCEONE.indices_closing,
									IFNULL(
										(
											SELECT
												sorted_data.fund_closing
											FROM
												sorted_data
											WHERE
												sorted_data.entry_date < DATASOURCEONE.entry_date
												AND sorted_data.fund_code = DATASOURCEONE.fund_code
											ORDER BY
												sorted_data.entry_date DESC
											LIMIT
												1
										), 0
									) AS PREVfund_closing,
									IFNULL(
										(
											SELECT
												sorted_data.indices_closing
											FROM
												sorted_data
											WHERE
												sorted_data.entry_date < DATASOURCEONE.entry_date
												AND sorted_data.fund_code = DATASOURCEONE.fund_code
											ORDER BY
												sorted_data.entry_date DESC
											LIMIT
												1
										), 0
									) AS PREVINDEXCLOSING
								FROM
									(
										SELECT
											tmp_ratio_data.fund_code,
											tmp_ratio_data.entry_date,
											tmp_ratio_data.fund_closing,
											tmp_ratio_data.indices_closing
										FROM
											tmp_ratio_data,
											(
												SELECT
													fund_code,
													MONTH(entry_date) AS MONTHNAME,
													YEAR(entry_date) AS YEARNAME
												FROM
													tmp_ratio_data
												GROUP BY
													fund_code,
													MONTH(entry_date),
													YEAR(entry_date)
											) FUNDFILTER
										WHERE
											tmp_ratio_data.fund_code = FUNDFILTER.fund_code
											AND tmp_ratio_data.entry_date IN (
												SELECT
													MIN(tmp_ratio_data.entry_date)
												FROM
													tmp_ratio_data
												WHERE
													MONTH(tmp_ratio_data.entry_date) = FUNDFILTER.MONTHNAME
													AND YEAR(tmp_ratio_data.entry_date) = FUNDFILTER.YEARNAME
													AND tmp_ratio_data.fund_code = FUNDFILTER.fund_code
											)
									) DATASOURCEONE
							) DATASOURCETWO
					) SEMIBETA
				GROUP BY
					SEMIBETA.fund_code
			) FINALBETA
	) BETADATA;

END;

/ / DELIMITER;