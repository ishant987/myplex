DELIMITER / / CREATE PROCEDURE sp_fund_composition_top_scrip_individual (p_start_month INT, p_start_year INT) BEGIN DECLARE v_check_date_cnt INT;

DECLARE v_newmonth INT;

DECLARE v_newyear INT;

SET
    v_check_date_cnt = (
        SELECT
            count(*)
        FROM
            mpx_fund_composition
        WHERE
            Month(entry_date) = p_start_month
            AND YEAR(entry_date) = p_start_year
    );

if(v_check_date_cnt = 0) THEN
SET
    v_newmonth = (
        SELECT
            Month(D1.entry_date)
        from
            mpx_fund_composition D1
        order by
            D1.entry_date DESC
        LIMIT
            1
    );

SET
    v_newyear = (
        SELECT
            year(D1.entry_date)
        from
            mpx_fund_composition D1
        order by
            D1.entry_date DESC
        LIMIT
            1
    );

SELECT
    final_data.scrip_name,
    final_data.industry,
    final_data.fund_name,
    final_data.content_per,
    final_data.amount,
    v_newmonth as month_cnt,
    v_newyear as yr_cnt
FROM
    (
        SELECT
            Z.scrip_name,
            Z.industry,
            Z.fund_name,
            Z.content_per,
            (mpx_corpus_entry.corpus_entry * Z.content_per) / 100 AS "amount"
        FROM
            (
                SELECT
                    Y.entry_date,
                    Y.fund_code,
                    Y.fund_name,
                    Y.scrip_name,
                    Y.industry,
                    Y.content_per
                FROM
                    (
                        SELECT
                            mpx_fund_composition.entry_date,
                            mpx_fund_composition.fund_code,
                            mpx_fund_master.fund_name,
                            mpx_fund_composition.scrip_name,
                            mpx_fund_composition.industry,
                            mpx_fund_composition.content_per
                        FROM
                            mpx_fund_composition
                            INNER JOIN mpx_fund_master ON mpx_fund_composition.fund_code = mpx_fund_master.fund_code
                        WHERE
                            MONTH(entry_date) = v_newmonth
                            AND YEAR(entry_date) = v_newyear
                            AND mpx_fund_master.fund_code IN (
                                SELECT
                                    fund_code
                                FROM
                                    tmp_fund_codes
                            )
                    ) Y
            ) Z
            INNER JOIN mpx_corpus_entry ON mpx_corpus_entry.fund_code = Z.fund_code
            AND mpx_corpus_entry.entry_date = Z.entry_date
    ) final_data
ORDER BY
    final_data.fund_name,
    final_data.amount DESC;

ELSE
SELECT
    final_data.scrip_name,
    final_data.industry,
    final_data.fund_name,
    final_data.content_per,
    final_data.amount
FROM
    (
        SELECT
            Z.scrip_name,
            Z.industry,
            Z.fund_name,
            Z.content_per,
            (mpx_corpus_entry.corpus_entry * Z.content_per) / 100 AS "amount"
        FROM
            (
                SELECT
                    Y.entry_date,
                    Y.fund_code,
                    Y.fund_name,
                    Y.scrip_name,
                    Y.industry,
                    Y.content_per
                FROM
                    (
                        SELECT
                            mpx_fund_composition.entry_date,
                            mpx_fund_composition.fund_code,
                            mpx_fund_master.fund_name,
                            mpx_fund_composition.scrip_name,
                            mpx_fund_composition.industry,
                            mpx_fund_composition.content_per
                        FROM
                            mpx_fund_composition
                            INNER JOIN mpx_fund_master ON mpx_fund_composition.fund_code = mpx_fund_master.fund_code
                        WHERE
                            MONTH(entry_date) = p_start_month
                            AND YEAR(entry_date) = p_start_year
                            AND mpx_fund_master.fund_code IN (
                                SELECT
                                    fund_code
                                FROM
                                    tmp_fund_codes
                            )
                    ) Y
            ) Z
            INNER JOIN mpx_corpus_entry ON mpx_corpus_entry.fund_code = Z.fund_code
            AND mpx_corpus_entry.entry_date = Z.entry_date
    ) final_data
ORDER BY
    final_data.fund_name,
    final_data.amount DESC;

END IF;

END;

/ / DELIMITER;