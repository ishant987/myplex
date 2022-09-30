DELIMITER / / CREATE PROCEDURE sp_weekly_return_less_index (p_entry_date VARCHAR(10), p_type_id INT) BEGIN CREATE TEMPORARY TABLE return_less_fund (
	fund_name VARCHAR(255) null,
	fund_code VARCHAR(255) null,
	indices_name VARCHAR(100) null,
	days7 DOUBLE null,
	days14 DOUBLE null,
	days30 DOUBLE null,
	days60 DOUBLE null
);

CREATE TEMPORARY TABLE return_less_index (
	indices_name VARCHAR(100),
	days7 DOUBLE,
	days14 DOUBLE,
	days30 DOUBLE,
	days60 DOUBLE
);

INSERT INTO
	return_less_fund (
		fund_name,
		fund_code,
		indices_name,
		days7,
		days14,
		days30,
		days60
	)
SELECT
	X.fund_name,
	X.fund_code,
	X.indices_name,
	CASE
		WHEN X.start_value7 <> 0 THEN (
			(
				(X.closing_value7 - X.start_value7) / X.start_value7
			) * 100
		)
		WHEN X.start_value7 = 0 THEN 0
	END AS "7days",
	CASE
		WHEN X.start_value14 <> 0 THEN (
			(
				(X.closing_value14 - X.start_value14) / X.start_value14
			) * 100
		)
		WHEN X.start_value14 = 0 THEN 0
	END AS "14days",
	CASE
		WHEN X.start_value30 <> 0 THEN (
			(
				(X.closing_value30 - X.start_value30) / X.start_value30
			) * 100
		)
		WHEN X.start_value30 = 0 THEN 0
	END AS "30days",
	CASE
		WHEN X.start_value60 <> 0 THEN (
			(
				(X.closing_value60 - X.start_value60) / X.start_value60
			) * 100
		)
		WHEN X.start_value60 = 0 THEN 0
	END AS "60days"
FROM
	(
		SELECT
			Y.fund_name,
			Y.fund_code,
			Y.indices_name,
			IFNULL(
				(
					SELECT
						mpx_fund_detail.closing_nav
					FROM
						mpx_fund_detail
					WHERE
						mpx_fund_detail.fund_code = Y.fund_code
						AND Y.fund_opened < TIMESTAMPADD(DAY, -7, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS start_value7,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND Y.fund_opened < TIMESTAMPADD(DAY, -7, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closing_value7,
			IFNULL(
				(
					SELECT
						mpx_fund_detail.closing_nav
					FROM
						mpx_fund_detail
					WHERE
						mpx_fund_detail.fund_code = Y.fund_code
						AND Y.fund_opened < TIMESTAMPADD(DAY, -14, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS start_value14,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND Y.fund_opened < TIMESTAMPADD(DAY, -14, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closing_value14,
			IFNULL(
				(
					SELECT
						mpx_fund_detail.closing_nav
					FROM
						mpx_fund_detail
					WHERE
						mpx_fund_detail.fund_code = Y.fund_code
						AND Y.fund_opened < TIMESTAMPADD(DAY, -30, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -30, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS start_value30,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND Y.fund_opened < TIMESTAMPADD(DAY, -30, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -30, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closing_value30,
			IFNULL(
				(
					SELECT
						mpx_fund_detail.closing_nav
					FROM
						mpx_fund_detail
					WHERE
						mpx_fund_detail.fund_code = Y.fund_code
						AND Y.fund_opened < TIMESTAMPADD(DAY, -60, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS start_value60,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND Y.fund_opened < TIMESTAMPADD(DAY, -60, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closing_value60
		FROM
			(
				SELECT
					fund_name,
					fund_code,
					indices_name,
					fund_opened
				FROM
					mpx_fund_master
				WHERE
					fund_opened < STR_TO_DATE(p_entry_date, 103)
					AND fund_type_id = p_type_id
			) Y
	) X;

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
	return_less_fund.fund_name,
	return_less_fund.fund_code,
	(return_less_fund.days7 - return_less_index.days7) AS VALUES7,
	(
		return_less_fund.days14 - return_less_index.days14
	) AS VALUES14,
	(
		return_less_fund.days30 - return_less_index.days30
	) AS VALUES30,
	(
		return_less_fund.days60 - return_less_index.days60
	) AS VALUES60
FROM
	return_less_fund
	INNER JOIN return_less_index ON return_less_fund.indices_name = return_less_index.indices_name
ORDER BY
	return_less_fund.fund_name;

END;

/ / DELIMITER;