DELIMITER / / CREATE PROCEDURE sp_find_missing_date_currency (
    p_currency_id INT,
    p_start_date date,
    p_end_date date
) BEGIN
SELECT
    FORMAT(DayInBetween, 'dd-MM-yyyy') AS missingDate,
    (
        SELECT
            name
        FROM
            mpx_currency_master
        WHERE
            cm_id = p_currency_id
    ) as currencyname,
    p_currency_id AS CurrencyId
FROM
    get_all_days_in_between(
        STR_TO_DATE(p_start_date, 103),
        STR_TO_DATE(p_end_date, 103)
    ) AS AllDaysInBetween
WHERE
    NOT EXISTS (
        SELECT
            cm_id
        FROM
            mpx_currency_detail
        WHERE
            entry_date = AllDaysInBetween.DayInBetween
            AND cm_id = p_currency_id;

);

END;

/ / DELIMITER;