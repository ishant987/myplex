DELIMITER / / CREATE PROCEDURE sp_fund_search_cat_lagger (
    p_entry_date VARCHAR(10),
    p_fund_type_id INT,
    p_duration INT
) BEGIN
SELECT
    FINALDATA.fund_name,
    FINALDATA.name,
    FINALDATA.weekly_change
FROM
    (
        SELECT
            mpx_fund_master.fund_name,
            mpx_fund_type.name,
            CASE
                WHEN Z.prev_value <= 0 THEN 0
                ELSE ((Z.cur_value - Z.prev_value) / Z.prev_value) * 100
            END AS "weekly_change"
        FROM
            (
                SELECT
                    X.fund_code,
                    X.prev_value,
                    Y.cur_value
                FROM
                    (
                        SELECT
                            closing_nav AS prev_value,
                            fund_code
                        FROM
                            mpx_fund_detail
                        WHERE
                            mpx_fund_detail.entry_date = TIMESTAMPADD(
                                DAY,
                                0,
                                STR_TO_DATE(p_entry_date, 103)
                            )
                    ) X
                    INNER JOIN (
                        SELECT
                            closing_nav AS cur_value,
                            fund_code
                        FROM
                            mpx_fund_detail
                        WHERE
                            mpx_fund_detail.entry_date = TIMESTAMPADD(DAY, 0, STR_TO_DATE(p_entry_date, 103))
                    ) Y ON X.fund_code = Y.fund_code
            ) Z
            INNER JOIN mpx_fund_master ON Z.fund_code = mpx_fund_master.fund_code
            INNER JOIN mpx_fund_type ON mpx_fund_master.fund_type_id = mpx_fund_type.ft_id
            AND mpx_fund_type.ft_id = p_fund_type_id
    ) FINALDATA
ORDER BY
    FINALDATA.weekly_change ASC
LIMIT
    1;

END;

/ / DELIMITER;