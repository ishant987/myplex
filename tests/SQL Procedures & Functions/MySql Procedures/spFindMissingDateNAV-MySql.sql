DELIMITER / / CREATE PROCEDURE sp_find_missing_date_nav (
    p_fund_code VARCHAR(50),
    p_start_date date,
    p_end_date date
) BEGIN
SELECT
    FORMAT(DayInBetween, 'dd-MM-yyyy') AS missingDate,
    (
        SELECT
            fund_name
        FROM
            mpx_fund_master
        WHERE
            fund_code = p_fund_code
    ) as fundname,
    p_fund_code AS fundcode
FROM
    get_all_days_in_between( STR_TO_DATE(p_start_date, 103), STR_TO_DATE(p_end_date, 103) ) AS AllDaysInBetween
WHERE
    NOT EXISTS (
        SELECT
            fund_code
        FROM
            mpx_fund_detail
        WHERE
            entry_date = AllDaysInBetween.DayInBetween
            AND fund_code = p_fund_code;

);

END;

/ / DELIMITER;