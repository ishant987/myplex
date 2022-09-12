DELIMITER / / CREATE PROCEDURE sp_monthly_top10 (
	p_entry_date VARCHAR(10),
	p_type_id INT,
	p_term_id INT
) BEGIN CREATE TEMPORARY TABLE top_ten_return (
	days6 VARCHAR(255) null,
	days1 VARCHAR(255) null,
	days2 VARCHAR(255) null,
	days3 VARCHAR(255) null,
	rec_id INT null
);

CREATE TEMPORARY TABLE return_percent (
	fund_name VARCHAR(255) null,
	fund_id VARCHAR(50) null,
	weekly_avg DOUBLE null,
	fort_night_avg DOUBLE null,
	monthly_avg DOUBLE null,
	bi_monthly_avg DOUBLE null
);

INSERT INTO
	return_percent (
		fund_name,
		fund_id,
		weekly_avg,
		fort_night_avg,
		monthly_avg,
		bi_monthly_avg
	)
SELECT
	X.fund_name,
	X.fund_code,
	CASE
		WHEN X.startvalue6 <> 0 THEN (
			(
				(X.closingvalue6 - X.startvalue6) / X.startvalue6
			) * 100
		)
		WHEN X.startvalue6 = 0 THEN 0
	END AS "sixmonths",
	CASE
		WHEN X.startvalue1 <> 0 THEN (
			(
				(X.closingvalue1 - X.startvalue1) / X.startvalue1
			) * 100
		)
		WHEN X.startvalue1 = 0 THEN 0
	END AS "oneyear",
	CASE
		WHEN X.startvalue2 <> 0 THEN (
			(
				POWER((X.closingvalue2 / X.startvalue2), 0.5) - 1
			) * 100
		)
		WHEN X.startvalue2 = 0 THEN 0
	END AS "twoyear",
	CASE
		WHEN X.startvalue3 <> 0 THEN (
			(
				POWER((X.closingvalue3 / X.startvalue3), 0.33) - 1
			) * 100
		)
		WHEN X.startvalue3 = 0 THEN 0
	END AS "threeyear"
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
						AND Y.fund_opened < TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS startvalue6,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND Y.fund_opened < TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closingvalue6,
			IFNULL(
				(
					SELECT
						mpx_fund_detail.closing_nav
					FROM
						mpx_fund_detail
					WHERE
						mpx_fund_detail.fund_code = Y.fund_code
						AND Y.fund_opened < TIMESTAMPADD(DAY, -365, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -365, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS startvalue1,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND Y.fund_opened < TIMESTAMPADD(DAY, -365, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -365, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closingvalue1,
			IFNULL(
				(
					SELECT
						mpx_fund_detail.closing_nav
					FROM
						mpx_fund_detail
					WHERE
						mpx_fund_detail.fund_code = Y.fund_code
						AND Y.fund_opened < TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS startvalue2,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND Y.fund_opened < TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closingvalue2,
			IFNULL(
				(
					SELECT
						mpx_fund_detail.closing_nav
					FROM
						mpx_fund_detail
					WHERE
						mpx_fund_detail.fund_code = Y.fund_code
						AND Y.fund_opened < TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103))
						AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
						AND mpx_fund_detail.holiday = 0
					ORDER BY
						mpx_fund_detail.entry_date
					LIMIT
						1
				), 0
			) AS startvalue3,
			(
				SELECT
					mpx_fund_detail.closing_nav
				FROM
					mpx_fund_detail
				WHERE
					mpx_fund_detail.fund_code = Y.fund_code
					AND mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103))
					AND Y.fund_opened < TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103))
					AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
					AND mpx_fund_detail.holiday = 0
				ORDER BY
					mpx_fund_detail.entry_date DESC
				LIMIT
					1
			) AS closingvalue3
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
					AND fund_term_id = p_term_id
			) Y
	) X;

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionOne6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								0
						) temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionOne1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								0
						) temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionOne2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								0
						) temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionOne3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								0
						) temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 1
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionTwo6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								1
						) temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionTwo1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								1
						) temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionTwo2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								1
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionTwo3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								1
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 2
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionThree6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								2
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionThree1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								2
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionThree2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								2
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionThree3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								2
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 3
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionFour6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								3
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionFour1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								3
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionFour2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								3
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionFour3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								3
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 4
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionFive6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								4
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionFive1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								4
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionFive2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								4
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionFive3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								4
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 5
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionSix6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								5
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionSix1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								5
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionSix2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								5
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionSix3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								5
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 6
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionSeven6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								6
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionSeven1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								6
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionSeven2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								6
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionSeven3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								6
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 7
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionEight6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								7
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionEight1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								7
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionEight2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								7
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionEight3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								7
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 8
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionNine6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								8
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionNine1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								8
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionNine2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								8
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionNine3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								8
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 9
	);

INSERT INTO
	top_ten_return (days6, days1, days2, days3, rec_id)
VALUES
	(
		PositionTen6 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				weekly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								weekly_avg <> 0
							ORDER BY
								weekly_avg DESC
							LIMIT
								9
						) as temp_tabl
				)
			ORDER BY
				weekly_avg DESC
			LIMIT
				1
		), PositionTen1 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				fort_night_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								fort_night_avg <> 0
							ORDER BY
								fort_night_avg DESC
							LIMIT
								9
						) as temp_tabl
				)
			ORDER BY
				fort_night_avg DESC
			LIMIT
				1
		), PositionTen2 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								monthly_avg <> 0
							ORDER BY
								monthly_avg DESC
							LIMIT
								9
						) as temp_tabl
				)
			ORDER BY
				monthly_avg DESC
			LIMIT
				1
		), PositionTen3 = (
			SELECT
				fund_name
			FROM
				return_percent
			WHERE
				bi_monthly_avg <> 0
				AND fund_id NOT IN (
					SELECT
						*
					FROM
						(
							SELECT
								fund_id
							FROM
								return_percent
							WHERE
								bi_monthly_avg <> 0
							ORDER BY
								bi_monthly_avg DESC
							LIMIT
								9
						) as temp_tabl
				)
			ORDER BY
				bi_monthly_avg DESC
			LIMIT
				1
		), 10
	);

SELECT
	days6 AS six_months,
	days1 AS one_year,
	days2 AS two_years,
	days3 AS three_years,
	rec_id AS rec_id
FROM
	top_ten_return
WHERE
	(
		days6 IS NOT NULL
		AND days1 IS NOT NULL
		AND days2 IS NOT NULL
		AND days3 IS NOT NULL
	);

END;

/ / DELIMITER;