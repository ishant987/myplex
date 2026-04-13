DELIMITER / / CREATE PROCEDURE sp_weekly_indices (p_entry_date VARCHAR(10), p_type_id INT) BEGIN CREATE TEMPORARY TABLE return_less_index (
	indices_name VARCHAR(100) null,
	days7 DOUBLE null,
	days14 DOUBLE null,
	days30 DOUBLE null,
	days60 DOUBLE null
);

INSERT INTO
	return_less_index (indices_name, days7, days14, days30, days60)
SELECT
	X.indices_name,
	CASE
		WHEN X.starting7 <> 0 THEN ((X.closing7 - X.starting7) / X.starting7) * 100
		WHEN X.starting7 = 0 THEN 0
	END AS "avg7",
	CASE
		WHEN X.starting14 <> 0 THEN ((X.closing14 - X.starting14) / X.starting14) * 100
		WHEN X.starting14 = 0 THEN 0
	END AS "avg14",
	CASE
		WHEN X.starting30 <> 0 THEN ((X.closing30 - X.starting30) / X.starting30) * 100
		WHEN X.starting30 = 0 THEN 0
	END AS "avg30",
	CASE
		WHEN X.starting60 <> 0 THEN ((X.closing60 - X.starting60) / X.starting60) * 100
		WHEN X.starting60 = 0 THEN 0
	END AS "avg60"
FROM
	(
		SELECT
			Y.indices_name,
			IFNULL(
				(
					SELECT
						mpx_indices_detail.closing_value
					FROM
						mpx_indices_detail
					WHERE
						mpx_indices_detail.indices_name = Y.indices_name
						AND Y.fund_opened < TIMESTAMPADD(DAY, -7, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -7, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_indices_detail.holiday = 0
					ORDER BY
						mpx_indices_detail.entry_date
					LIMIT
						1
				), 0
			) AS starting7,
			(
				SELECT
					mpx_indices_detail.closing_value
				FROM
					mpx_indices_detail
				WHERE
					mpx_indices_detail.indices_name = Y.indices_name
					AND Y.fund_opened < TIMESTAMPADD(DAY, -7, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -7, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_indices_detail.holiday = 0
				ORDER BY
					mpx_indices_detail.entry_date DESC
				LIMIT
					1
			) AS closing7,
			IFNULL(
				(
					SELECT
						mpx_indices_detail.closing_value
					FROM
						mpx_indices_detail
					WHERE
						mpx_indices_detail.indices_name = Y.indices_name
						AND Y.fund_opened < TIMESTAMPADD(DAY, -14, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -14, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_indices_detail.holiday = 0
					ORDER BY
						mpx_indices_detail.entry_date
					LIMIT
						1
				), 0
			) AS starting14,
			(
				SELECT
					mpx_indices_detail.closing_value
				FROM
					mpx_indices_detail
				WHERE
					mpx_indices_detail.indices_name = Y.indices_name
					AND Y.fund_opened < TIMESTAMPADD(DAY, -14, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -14, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_indices_detail.holiday = 0
				ORDER BY
					mpx_indices_detail.entry_date DESC
				LIMIT
					1
			) AS closing14,
			IFNULL(
				(
					SELECT
						mpx_indices_detail.closing_value
					FROM
						mpx_indices_detail
					WHERE
						mpx_indices_detail.indices_name = Y.indices_name
						AND Y.fund_opened < TIMESTAMPADD(DAY, -30, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -30, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_indices_detail.holiday = 0
					ORDER BY
						mpx_indices_detail.entry_date
					LIMIT
						1
				), 0
			) AS starting30,
			(
				SELECT
					mpx_indices_detail.closing_value
				FROM
					mpx_indices_detail
				WHERE
					mpx_indices_detail.indices_name = Y.indices_name
					AND Y.fund_opened < TIMESTAMPADD(DAY, -30, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -30, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_indices_detail.holiday = 0
				ORDER BY
					mpx_indices_detail.entry_date DESC
				LIMIT
					1
			) AS closing30,
			IFNULL(
				(
					SELECT
						mpx_indices_detail.closing_value
					FROM
						mpx_indices_detail
					WHERE
						mpx_indices_detail.indices_name = Y.indices_name
						AND Y.fund_opened < TIMESTAMPADD(DAY, -60, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -60, STR_TO_DATE(p_entry_date, 103))
						AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_indices_detail.holiday = 0
					ORDER BY
						mpx_indices_detail.entry_date
					LIMIT
						1
				), 0
			) AS starting60,
			(
				SELECT
					mpx_indices_detail.closing_value
				FROM
					mpx_indices_detail
				WHERE
					mpx_indices_detail.indices_name = Y.indices_name
					AND Y.fund_opened < TIMESTAMPADD(DAY, -60, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date > TIMESTAMPADD(DAY, -60, STR_TO_DATE(p_entry_date, 103))
					AND mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_indices_detail.holiday = 0
				ORDER BY
					mpx_indices_detail.entry_date DESC
				LIMIT
					1
			) AS closing60
		FROM
			(
				SELECT
					DISTINCT mpx_indices_detail.indices_name,
					MIN(mpx_indices_detail.entry_date) AS fund_opened
				FROM
					mpx_indices_detail
					INNER JOIN mpx_fund_master ON mpx_indices_detail.indices_name = mpx_fund_master.indices_name
				WHERE
					mpx_indices_detail.entry_date < STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_master.fund_type_id = p_type_id
				GROUP BY
					mpx_indices_detail.indices_name
			) Y
	) X;

SELECT
	indices_name,
	days7,
	days14,
	days30,
	days60
FROM
	return_less_index
ORDER BY
	indices_name;

END;

/ / DELIMITER;