DELIMITER / / CREATE PROCEDURE sp_fund_index_currency_check (
    p_StartDate VARCHAR(10),
    p_EndDate VARCHAR(10),
    p_varName VARCHAR(100),
    p_varID INT,
    p_radio_val INT,
    p_scheme_1 VARCHAR(100),
    p_scheme_2 VARCHAR(100),
    p_index_1 VARCHAR(100),
    p_index_2 VARCHAR(100),
    p_currrency_1 VARCHAR(100),
    p_currrency_2 VARCHAR(100),
    p_tab_for VARCHAR(10)
) BEGIN DECLARE v_cntFromFund_1 INT;

DECLARE v_cntFromFund_2 INT;

DECLARE v_cntFromCur_1 INT;

DECLARE v_cntFromCur_2 INT;

DECLARE v_cntFromIndex_1 INT;

DECLARE v_cntFromIndex_2 INT;

DECLARE v_newFromDateFund_1 DATE;

DECLARE v_newFromDateFund_2 DATE;

DECLARE v_newFromDateCur_1 DATE;

DECLARE v_newFromDateCur_2 DATE;

DECLARE v_newFromDateIndex_1 DATE;

DECLARE v_newFromDateIndex_2 DATE;

DECLARE v_date_from_1 INT;

DECLARE v_date_from_2 INT;

DECLARE v_final_from_date DATE;

DECLARE v_cntToFund_1 INT;

DECLARE v_cntToFund_2 INT;

DECLARE v_cntToCur_1 INT;

DECLARE v_cntToCur_2 INT;

DECLARE v_cntToIndex_1 INT;

DECLARE v_cntToIndex_2 INT;

DECLARE v_newToDateFund_1 DATE;

DECLARE v_newToDateFund_2 DATE;

DECLARE v_newToDateCur_1 DATE;

DECLARE v_newToDateCur_2 DATE;

DECLARE v_newToDateIndex_1 DATE;

DECLARE v_newToDateIndex_2 DATE;

DECLARE v_date_to_1 INT;

DECLARE v_date_to_2 INT;

DECLARE v_final_to_date DATE;

DECLARE v_cntFromFund_1_scheme varchar(100);

DECLARE v_cnttoFund_1_scheme varchar(100);

DECLARE v_cntFromFund_2_scheme varchar(100);

DECLARE v_cnttoFund_2_scheme varchar(100);

DECLARE v_cntFromFund_1_index varchar(100);

DECLARE v_cnttoFund_1_index varchar(100);

DECLARE v_cntFromFund_2_index varchar(100);

DECLARE v_cnttoFund_2_index varchar(100);

DECLARE v_cntFromFund_1_currency varchar(100);

DECLARE v_cnttoFund_1_currency varchar(100);

DECLARE v_cntFromFund_2_currency varchar(100);

DECLARE v_cnttoFund_2_currency varchar(100);

DECLARE v_final_from_scheme varchar(100);

DECLARE v_final_to_scheme varchar(100);

DECLARE v_final_schemeindexcurrency_name varchar(100);

DECLARE v_show_msg varchar(1) DEFAULT 0;

DECLARE v_final_message varchar(255);

IF p_radio_val = 1 THEN
SET
    v_cntFromFund_1 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D1
        WHERE
            D1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND D1.fund_code = p_scheme_1
    );

SET
    v_cntFromFund_2 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D2
        WHERE
            D2.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND D2.fund_code = p_scheme_2
    );

IF v_cntFromFund_1 = 0 THEN
SET
    v_newFromDateFund_1 = (
        SELECT
            D1.entry_date
        from
            mpx_fund_detail D1
        WHERE
            D1.fund_code = p_scheme_1
        order by
            D1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_scheme =(
        SELECT
            fund_name
        FROM
            mpx_fund_master
        WHERE
            fund_code = p_scheme_1
    );

IF p_tab_for = 'DP' THEN
SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_1_scheme,
        ' NAV available from ',
        DATE_FORMAT (v_newFromDateFund_1, '%d/%m/%Y')
    );

ELSEIF p_tab_for = 'RA' THEN
SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_1_scheme,
        ' data available from ',
        DATE_FORMAT (v_newFromDateFund_1, '%d/%m/%Y')
    );

ELSE
SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_1_scheme,
        ' composition available from ',
        FORMAT(v_newFromDateFund_1, 'y')
    );

END IF;

END IF;

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateFund_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

IF v_cntFromFund_2 = 0 THEN
SET
    v_newFromDateFund_2 = (
        SELECT
            D2.entry_date
        from
            mpx_fund_detail D2
        WHERE
            D2.fund_code = p_scheme_2
        order by
            D2.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_2_scheme =(
        SELECT
            fund_name
        FROM
            mpx_fund_master
        WHERE
            fund_code = p_scheme_2
    );

IF p_tab_for = 'DP' THEN
SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_2_scheme,
        ' NAV available from ',
        DATE_FORMAT (v_newFromDateFund_2, '%d/%m/%Y')
    );

END IF;

ELSEIF p_tab_for = 'RA' THEN
SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_2_scheme,
        ' data available from ',
        DATE_FORMAT (v_newFromDateFund_2, '%d/%m/%Y')
    );

ELSE
SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_2_scheme,
        ' composition available from ',
        FORMAT(v_newFromDateFund_2, 'y')
    );

END IF;

SET
    v_show_msg = 1;

SET
    v_newFromDateFund_2 = STR_TO_DATE(p_StartDate, 103);

SET
    v_date_from_1 = TIMESTAMPDIFF(day, now(3), v_newFromDateFund_1);

SET
    v_date_from_2 = TIMESTAMPDIFF(day, now(3), v_newFromDateFund_2);

IF v_date_from_1 < v_date_from_2 THEN
SET
    v_final_from_date = v_newFromDateFund_2;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_2_scheme;

ELSE
SET
    v_final_from_date = v_newFromDateFund_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_scheme;

END IF;

SET
    v_cntToFund_1 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D1
        WHERE
            D1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND D1.fund_code = p_scheme_1
    );

SET
    v_cntToFund_2 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D2
        WHERE
            D2.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND D2.fund_code = p_scheme_2
    );

IF v_cntToFund_1 = 0 THEN
SET
    v_newToDateFund_1 = (
        SELECT
            D1.entry_date
        from
            mpx_fund_detail D1
        WHERE
            D1.fund_code = p_scheme_1
        order by
            D1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateFund_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

IF v_cntToFund_2 = 0 THEN
SET
    v_newToDateFund_2 = (
        SELECT
            D2.entry_date
        from
            mpx_fund_detail D2
        WHERE
            D2.fund_code = p_scheme_2
        order by
            D2.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateFund_2 = STR_TO_DATE(p_EndDate, 103);

END IF;

SET
    v_date_to_1 = TIMESTAMPDIFF(day, now(3), v_newToDateFund_1);

SET
    v_date_to_2 = TIMESTAMPDIFF(day, now(3), v_newToDateFund_2);

IF v_date_to_1 > v_date_to_2 THEN
SET
    v_final_to_date = v_newToDateFund_2;

ELSE
SET
    v_final_to_date = v_newToDateFund_1;

END IF;

IF p_radio_val = 2 THEN
SET
    v_cntFromFund_1 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D1
        WHERE
            D1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND D1.fund_code = p_scheme_1
    );

SET
    v_cntFromIndex_1 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E1
        WHERE
            E1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND E1.name = p_index_1
    );

IF v_cntFromFund_1 = 0 THEN
SET
    v_newFromDateFund_1 = (
        SELECT
            D1.entry_date
        from
            mpx_fund_detail D1
        WHERE
            D1.fund_code = p_scheme_1
        order by
            D1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_scheme =(
        SELECT
            fund_name
        FROM
            mpx_fund_master
        WHERE
            fund_code = p_scheme_1
    );

SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_1_scheme,
        ' NAV available from ',
        DATE_FORMAT (v_newFromDateFund_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateFund_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

IF v_cntFromIndex_1 = 0 THEN
SET
    v_newFromDateIndex_1 = (
        SELECT
            E1.entry_date
        from
            mpx_indices_detail E1
        WHERE
            E1.name = p_index_1
        order by
            E1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_index = p_index_1;

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_1_index,
        ' from ',
        DATE_FORMAT (v_newFromDateIndex_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateIndex_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

SET
    v_date_from_1 = TIMESTAMPDIFF(day, now(3), v_newFromDateFund_1);

SET
    v_date_from_2 = TIMESTAMPDIFF(day, now(3), v_newFromDateIndex_1);

IF v_date_from_1 < v_date_from_2 THEN
SET
    v_final_from_date = v_newFromDateIndex_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_index;

ELSE
SET
    v_final_from_date = v_newFromDateFund_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_scheme;

END IF;

SET
    v_cntToFund_1 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D1
        WHERE
            D1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND D1.fund_code = p_scheme_1
    );

SET
    v_cntToIndex_1 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E1
        WHERE
            E1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND E1.name = p_index_1
    );

IF v_cntToFund_1 = 0 THEN
SET
    v_newToDateFund_1 = (
        SELECT
            D1.entry_date
        from
            mpx_fund_detail D1
        WHERE
            D1.fund_code = p_scheme_1
        order by
            D1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateFund_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

IF v_cntToIndex_1 = 0 THEN
SET
    v_newToDateIndex_1 = (
        SELECT
            E1.entry_date
        from
            mpx_indices_detail E1
        WHERE
            E1.name = p_index_1
        order by
            E1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateIndex_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

SET
    v_date_to_1 = TIMESTAMPDIFF(day, now(3), v_newToDateFund_1);

SET
    v_date_to_2 = TIMESTAMPDIFF(day, now(3), v_newToDateIndex_1);

IF v_date_to_1 > v_date_to_2 THEN
SET
    v_final_to_date = v_newToDateIndex_1;

ELSE
SET
    v_final_to_date = v_newToDateFund_1;

END IF;

END IF;

IF p_radio_val = 3 THEN
SET
    v_cntFromFund_1 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D1
        WHERE
            D1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND D1.fund_code = p_scheme_1
    );

SET
    v_cntFromCur_1 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F1
        WHERE
            F1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND F1.cm_id = p_currrency_1
    );

IF v_cntFromFund_1 = 0 THEN
SET
    v_newFromDateFund_1 = (
        SELECT
            D1.entry_date
        from
            mpx_fund_detail D1
        WHERE
            D1.fund_code = p_scheme_1
        order by
            D1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_scheme =(
        SELECT
            fund_name
        FROM
            mpx_fund_master
        WHERE
            fund_code = p_scheme_1
    );

SET
    v_final_message = CONCAT(
        'For ',
        v_cntFromFund_1_scheme,
        ' NAV available from ',
        DATE_FORMAT (v_newFromDateFund_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateFund_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

IF v_cntFromCur_1 = 0 THEN
SET
    v_newFromDateCur_1 = (
        SELECT
            F1.entry_date
        from
            mpx_currency_detail F1
        WHERE
            F1.cm_id = p_currrency_1
        order by
            F1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_currency = (
        SELECT
            name
        from
            mpx_currency_master F1
        WHERE
            F1.cm_id = p_currrency_1
    );

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_1_currency,
        ' from ',
        DATE_FORMAT (v_newFromDateCur_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateCur_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

SET
    v_date_from_1 = TIMESTAMPDIFF(day, now(3), v_newFromDateFund_1);

SET
    v_date_from_2 = TIMESTAMPDIFF(day, now(3), v_newFromDateCur_1);

IF v_date_from_1 < v_date_from_2 THEN
SET
    v_final_from_date = v_newFromDateCur_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_currency;

ELSE
SET
    v_final_from_date = v_newFromDateFund_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_scheme;

END IF;

SET
    v_cntToFund_1 = (
        SELECT
            count(*)
        from
            mpx_fund_detail D1
        WHERE
            D1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND D1.fund_code = p_scheme_1
    );

SET
    v_cntToCur_1 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F1
        WHERE
            F1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND F1.cm_id = p_currrency_1
    );

IF v_cntToFund_1 = 0 THEN
SET
    v_newToDateFund_1 = (
        SELECT
            D1.entry_date
        from
            mpx_fund_detail D1
        WHERE
            D1.fund_code = p_scheme_1
        order by
            D1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateFund_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

IF v_cntToCur_1 = 0 THEN
SET
    v_newToDateCur_1 = (
        SELECT
            F1.entry_date
        from
            mpx_currency_detail F1
        WHERE
            F1.cm_id = p_currrency_1
        order by
            F1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateCur_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

SET
    v_date_to_1 = TIMESTAMPDIFF(day, now(3), v_newToDateFund_1);

SET
    v_date_to_2 = TIMESTAMPDIFF(day, now(3), v_newToDateCur_1);

IF v_date_to_1 > v_date_to_2 THEN
SET
    v_final_to_date = v_newToDateCur_1;

ELSE
SET
    v_final_to_date = v_newToDateFund_1;

END IF;

END IF;

IF p_radio_val = 4 THEN
SET
    v_cntFromIndex_1 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E1
        WHERE
            E1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND E1.name = p_index_1
    );

SET
    v_cntFromIndex_2 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E2
        WHERE
            E2.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND E2.name = p_index_2
    );

IF v_cntFromIndex_1 = 0 THEN
SET
    v_newFromDateIndex_1 = (
        SELECT
            E1.entry_date
        from
            mpx_indices_detail E1
        WHERE
            E1.name = p_index_1
        order by
            E1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_index = p_index_1;

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_1_index,
        ' from ',
        DATE_FORMAT (v_newFromDateIndex_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateIndex_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

IF v_cntFromIndex_2 = 0 THEN
SET
    v_newFromDateIndex_2 = (
        SELECT
            E2.entry_date
        from
            mpx_indices_detail E2
        WHERE
            E2.name = p_index_2
        order by
            E2.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_2_index = p_index_2;

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_2_index,
        ' from ',
        DATE_FORMAT (v_newFromDateIndex_2, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateIndex_2 = STR_TO_DATE(p_StartDate, 103);

END IF;

SET
    v_date_from_1 = TIMESTAMPDIFF(day, now(3), v_newFromDateIndex_1);

SET
    v_date_from_2 = TIMESTAMPDIFF(day, now(3), v_newFromDateIndex_2);

IF v_date_from_1 < v_date_from_2 THEN
SET
    v_final_from_date = v_newFromDateIndex_2;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_2_index;

ELSE
SET
    v_final_from_date = v_newFromDateIndex_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_index;

END IF;

SET
    v_cntToIndex_1 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E1
        WHERE
            E1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND E1.name = p_index_1
    );

SET
    v_cntToIndex_2 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E2
        WHERE
            E2.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND E2.name = p_index_2
    );

IF v_cntToIndex_1 = 0 THEN
SET
    v_newToDateIndex_1 = (
        SELECT
            E1.entry_date
        from
            mpx_indices_detail E1
        WHERE
            E1.name = p_index_1
        order by
            E1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateIndex_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

IF v_cntToIndex_2 = 0 THEN
SET
    v_newToDateIndex_2 = (
        SELECT
            E2.entry_date
        from
            mpx_indices_detail E2
        WHERE
            E2.name = p_index_2
        order by
            E2.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateIndex_2 = STR_TO_DATE(p_EndDate, 103);

END IF;

SET
    v_date_to_1 = TIMESTAMPDIFF(day, now(3), v_newToDateIndex_1);

SET
    v_date_to_2 = TIMESTAMPDIFF(day, now(3), v_newToDateIndex_2);

IF v_date_to_1 > v_date_to_2 THEN
SET
    v_final_to_date = v_newToDateIndex_2;

ELSE
SET
    v_final_to_date = v_newToDateIndex_1;

END IF;

END IF;

IF p_radio_val = 5 THEN
SET
    v_cntFromIndex_1 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E1
        WHERE
            E1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND E1.name = p_index_1
    );

SET
    v_cntFromCur_1 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F1
        WHERE
            F1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND F1.cm_id = p_varID
    );

IF v_cntFromIndex_1 = 0 THEN
SET
    v_newFromDateIndex_1 = (
        SELECT
            E1.entry_date
        from
            mpx_indices_detail E1
        WHERE
            E1.name = p_index_1
        order by
            E1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_index = p_index_1;

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_1_index,
        ' from ',
        DATE_FORMAT (v_newFromDateIndex_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateIndex_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

IF v_cntFromCur_1 = 0 THEN
SET
    v_newFromDateCur_1 = (
        SELECT
            F1.entry_date
        from
            mpx_currency_detail F1
        WHERE
            F1.cm_id = p_currrency_1
        order by
            F1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_currency = (
        SELECT
            name
        from
            mpx_currency_master F1
        WHERE
            F1.cm_id = p_currrency_1
    );

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_1_currency,
        ' from ',
        DATE_FORMAT (v_newFromDateCur_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateCur_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

SET
    v_date_from_1 = TIMESTAMPDIFF(day, now(3), v_newFromDateIndex_1);

SET
    v_date_from_2 = TIMESTAMPDIFF(day, now(3), v_newFromDateCur_1);

IF v_date_from_1 < v_date_from_2 THEN
SET
    v_final_from_date = v_newFromDateCur_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_currency;

ELSE
SET
    v_final_from_date = v_newFromDateIndex_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_index;

END IF;

SET
    v_cntToIndex_1 = (
        SELECT
            count(*)
        from
            mpx_indices_detail E1
        WHERE
            E1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND E1.name = p_index_1
    );

SET
    v_cntToCur_1 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F1
        WHERE
            F1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND F1.cm_id = p_varID
    );

IF v_cntToIndex_1 = 0 THEN
SET
    v_newToDateIndex_1 = (
        SELECT
            E1.entry_date
        from
            mpx_indices_detail E1
        WHERE
            E1.name = p_index_1
        order by
            E1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateIndex_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

IF v_cntToCur_1 = 0 THEN
SET
    v_newToDateCur_1 = (
        SELECT
            F1.entry_date
        from
            mpx_currency_detail F1
        WHERE
            F1.cm_id = p_currrency_1
        order by
            F1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateCur_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

SET
    v_date_to_1 = TIMESTAMPDIFF(day, now(3), v_newToDateIndex_1);

SET
    v_date_to_2 = TIMESTAMPDIFF(day, now(3), v_newToDateCur_1);

IF v_date_to_1 > v_date_to_2 THEN
SET
    v_final_to_date = v_newToDateCur_1;

ELSE
SET
    v_final_to_date = v_newToDateIndex_1;

END IF;

END IF;

IF p_radio_val = 6 THEN
SET
    v_cntFromCur_1 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F1
        WHERE
            F1.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND F1.cm_id = p_currrency_1
    );

SET
    v_cntFromCur_2 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F2
        WHERE
            F2.entry_date = STR_TO_DATE(p_StartDate, 103)
            AND F2.cm_id = p_currrency_2
    );

IF v_cntFromCur_1 = 0 THEN
SET
    v_newFromDateCur_1 = (
        SELECT
            F1.entry_date
        from
            mpx_currency_detail F1
        WHERE
            F1.cm_id = p_currrency_1
        order by
            F1.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_1_currency = (
        SELECT
            name
        from
            mpx_currency_master F1
        WHERE
            F1.cm_id = p_currrency_1
    );

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_1_currency,
        ' from ',
        DATE_FORMAT (v_newFromDateCur_1, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateCur_1 = STR_TO_DATE(p_StartDate, 103);

END IF;

IF v_cntFromCur_2 = 0 THEN
SET
    v_newFromDateCur_2 = (
        SELECT
            F2.entry_date
        from
            mpx_currency_detail F2
        WHERE
            F2.cm_id = p_currrency_2
        order by
            F2.entry_date ASC
        LIMIT
            1
    );

SET
    v_cntFromFund_2_currency = (
        SELECT
            name
        from
            mpx_currency_master F1
        WHERE
            F1.cm_id = p_currrency_2
    );

SET
    v_final_message = CONCAT(
        'We are taking closing value of ',
        v_cntFromFund_2_currency,
        ' from ',
        DATE_FORMAT (v_newFromDateCur_2, '%d/%m/%Y')
    );

SET
    v_show_msg = 1;

ELSE
SET
    v_newFromDateCur_2 = STR_TO_DATE(p_StartDate, 103);

END IF;

SET
    v_date_from_1 = TIMESTAMPDIFF(day, now(3), v_newFromDateCur_1);

SET
    v_date_from_2 = TIMESTAMPDIFF(day, now(3), v_newFromDateCur_2);

IF v_date_from_1 < v_date_from_2 THEN
SET
    v_final_from_date = v_newFromDateCur_2;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_2_currency;

ELSE
SET
    v_final_from_date = v_newFromDateCur_1;

SET
    v_final_schemeindexcurrency_name = v_cntFromFund_1_currency;

END IF;

SET
    v_cntToCur_1 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F1
        WHERE
            F1.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND F1.cm_id = p_currrency_1
    );

SET
    v_cntToCur_2 = (
        SELECT
            count(*)
        FROM
            mpx_currency_detail F2
        WHERE
            F2.entry_date = STR_TO_DATE(p_EndDate, 103)
            AND F2.cm_id = p_currrency_2
    );

IF v_cntToCur_1 = 0 THEN
SET
    v_newToDateCur_1 = (
        SELECT
            F1.entry_date
        from
            mpx_currency_detail F1
        WHERE
            F1.cm_id = p_currrency_1
        order by
            F1.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateCur_1 = STR_TO_DATE(p_EndDate, 103);

END IF;

IF v_cntToCur_2 = 0 THEN
SET
    v_newToDateCur_2 = (
        SELECT
            F2.entry_date
        from
            mpx_currency_detail F2
        WHERE
            F2.cm_id = p_currrency_2
        order by
            F2.entry_date DESC
        LIMIT
            1
    );

ELSE
SET
    v_newToDateCur_2 = STR_TO_DATE(p_EndDate, 103);

END IF;

SET
    v_date_to_1 = TIMESTAMPDIFF(day, now(3), v_newToDateCur_1);

SET
    v_date_to_2 = TIMESTAMPDIFF(day, now(3), v_newToDateCur_2);

IF v_date_to_1 > v_date_to_2 THEN
SET
    v_final_to_date = v_newToDateCur_2;

ELSE
SET
    v_final_to_date = v_newToDateCur_1;

END IF;

END IF;

SELECT
    DATE_FORMAT (v_final_from_date, '%d/%m/%Y') AS 'frm_dt',
    v_final_schemeindexcurrency_name AS name,
    v_final_message AS final_msg,
    DATE_FORMAT (v_final_to_date, '%d/%m/%Y') AS 'to_dt',
    v_show_msg AS show_msg;

END;

/ / DELIMITER;