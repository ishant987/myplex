DELIMITER / / CREATE PROCEDURE sp_weekly_average (p_entry_date VARCHAR(10), p_type_id INT) BEGIN
SELECT
       X.fund_name,
       X.fund_code,
       X.indices_name,
       CASE
              WHEN X.tot_count <> 0 THEN X.pct_sum / X.tot_count
              WHEN X.tot_count = 0 THEN 0
       END AS "5days",
       CASE
              WHEN (
                     X.startvalue7 <> 0
                     AND X.closingvalue7 <> 0
              ) THEN (
                     (
                            (X.closingvalue7 - X.startvalue7) / X.startvalue7
                     ) * 100
              )
              WHEN X.startvalue7 = 0 THEN 0
              WHEN X.closingvalue7 = 0 THEN 0
       END AS "7days",
       CASE
              WHEN (
                     X.startvalue14 <> 0
                     AND X.closingvalue14 <> 0
              ) THEN (
                     (
                            (X.closingvalue14 - X.startvalue14) / X.startvalue14
                     ) * 100
              )
              WHEN X.startvalue14 = 0 THEN 0
       END AS "14days",
       CASE
              WHEN (
                     X.startvalue30 <> 0
                     AND X.closingvalue30 <> 0
              ) THEN (
                     (
                            (X.closingvalue30 - X.startvalue30) / X.startvalue30
                     ) * 100
              )
              WHEN X.startvalue30 = 0 THEN 0
       END AS "30days",
       CASE
              WHEN (
                     X.startvalue60 <> 0
                     AND X.closingvalue60 <> 0
              ) THEN (
                     (
                            (X.closingvalue60 - X.startvalue60) / X.startvalue60
                     ) * 100
              )
              WHEN X.startvalue60 = 0 THEN 0
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
                                          Count(*)
                                   From
                                          mpx_fund_detail
                                   WHERE
                                          mpx_fund_detail.fund_code = Y.fund_code
                                          AND Y.fund_opened < TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                          AND mpx_fund_detail.holiday = 0
                            ),
                            0
                     ) AS tot_count,
                     IFNULL(
                            (
                                   SELECT
                                          SUM(mpx_fund_detail.percentage_change)
                                   FROM
                                          mpx_fund_detail
                                   WHERE
                                          mpx_fund_detail.fund_code = Y.fund_code
                                          AND Y.fund_opened < TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date >= TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                          AND mpx_fund_detail.holiday = 0
                            ),
                            0
                     ) AS pct_sum,
                     IFNULL(
                            (
                                   SELECT
                                          mpx_fund_detail.closing_nav
                                   FROM
                                          mpx_fund_detail
                                   WHERE
                                          mpx_fund_detail.fund_code = Y.fund_code
                                          AND Y.fund_opened < TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                          AND mpx_fund_detail.holiday = 0
                                   ORDER BY
                                          mpx_fund_detail.entry_date
                                   LIMIT
                                          1
                            ), 0
                     ) AS startvalue7,
                     (
                            SELECT
                                   mpx_fund_detail.closing_nav
                            FROM
                                   mpx_fund_detail
                            WHERE
                                   mpx_fund_detail.fund_code = Y.fund_code
                                   AND Y.fund_opened < TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -7, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                   AND mpx_fund_detail.holiday = 0
                            ORDER BY
                                   mpx_fund_detail.entry_date DESC
                            LIMIT
                                   1
                     ) AS closingvalue7,
                     IFNULL(
                            (
                                   SELECT
                                          mpx_fund_detail.closing_nav
                                   FROM
                                          mpx_fund_detail
                                   WHERE
                                          mpx_fund_detail.fund_code = Y.fund_code
                                          AND Y.fund_opened < TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                          AND mpx_fund_detail.holiday = 0
                                   ORDER BY
                                          mpx_fund_detail.entry_date
                                   LIMIT
                                          1
                            ), 0
                     ) AS startvalue14,
                     (
                            SELECT
                                   mpx_fund_detail.closing_nav
                            FROM
                                   mpx_fund_detail
                            WHERE
                                   mpx_fund_detail.fund_code = Y.fund_code
                                   AND Y.fund_opened < TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -14, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                   AND mpx_fund_detail.holiday = 0
                            ORDER BY
                                   mpx_fund_detail.entry_date DESC
                            LIMIT
                                   1
                     ) AS closingvalue14,
                     IFNULL(
                            (
                                   SELECT
                                          mpx_fund_detail.closing_nav
                                   FROM
                                          mpx_fund_detail
                                   WHERE
                                          mpx_fund_detail.fund_code = Y.fund_code
                                          AND Y.fund_opened < TIMESTAMPADD(Day, -30, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -30, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                          AND mpx_fund_detail.holiday = 0
                                   ORDER BY
                                          mpx_fund_detail.entry_date
                                   LIMIT
                                          1
                            ), 0
                     ) AS startvalue30,
                     (
                            SELECT
                                   mpx_fund_detail.closing_nav
                            FROM
                                   mpx_fund_detail
                            WHERE
                                   mpx_fund_detail.fund_code = Y.fund_code
                                   AND Y.fund_opened < TIMESTAMPADD(Day, -30, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -30, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                   AND mpx_fund_detail.holiday = 0
                            ORDER BY
                                   mpx_fund_detail.entry_date DESC
                            LIMIT
                                   1
                     ) AS closingvalue30,
                     IFNULL(
                            (
                                   SELECT
                                          mpx_fund_detail.closing_nav
                                   FROM
                                          mpx_fund_detail
                                   WHERE
                                          mpx_fund_detail.fund_code = Y.fund_code
                                          AND Y.fund_opened < TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                                          AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                          AND mpx_fund_detail.holiday = 0
                                   ORDER BY
                                          mpx_fund_detail.entry_date
                                   LIMIT
                                          1
                            ), 0
                     ) AS startvalue60,
                     (
                            SELECT
                                   mpx_fund_detail.closing_nav
                            FROM
                                   mpx_fund_detail
                            WHERE
                                   mpx_fund_detail.fund_code = Y.fund_code
                                   AND Y.fund_opened < TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date > TIMESTAMPADD(Day, -60, STR_TO_DATE(p_entry_date, 103))
                                   AND mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)
                                   AND mpx_fund_detail.holiday = 0
                            ORDER BY
                                   mpx_fund_detail.entry_date DESC
                            LIMIT
                                   1
                     ) AS closingvalue60
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
       ) X
ORDER BY
       X.fund_name;

END;

/ / DELIMITER;