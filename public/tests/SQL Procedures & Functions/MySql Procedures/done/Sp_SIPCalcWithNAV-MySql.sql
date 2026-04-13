DELIMITER / / CREATE PROCEDURE sp_sip_calc_with_nav (
    p_duration INT,
    p_fund_code VARCHAR(50),
    p_monthly_sip double,
    p_sip_day_of_month INT
) BEGIN DECLARE v_entry_date DATE;

DECLARE v_closing_nav DECIMAL(10, 2);

DECLARE v_n_unit DECIMAL(10, 2);

DECLARE v_latest_nav DECIMAL(10, 2);

DECLARE v_tot_units DECIMAL(10, 2);

DECLARE v_current_value DECIMAL(10, 2);

DECLARE v_latest_date DATE;

DECLARE v_all_values VARCHAR(2000);

DECLARE v_all_dates VARCHAR(2000);

DECLARE v_all_navs VARCHAR(2000);

DECLARE v_all_units VARCHAR(2000);

DECLARE v_cur_date VARCHAR(10);

DECLARE v_yr varchar(4);

DECLARE v_mn varchar(2);

DECLARE v_counter INT;

SET
    v_counter = 1;

SET
    v_all_values = '[';

SET
    v_all_dates = '[';

SET
    v_tot_units = 0.00;

SET
    v_current_value = 0.00;

SET
    v_n_unit = 0.00;

SET
    v_all_navs = '[';

SET
    v_all_units = '[';

SET
    v_yr = YEAR(NOW(3));

SET
    v_mn = MONTH(NOW(3));

IF p_sip_day_of_month = 31 THEN IF v_mn = 4
or v_mn = 6
or v_mn = 9
or v_mn = 11 THEN
SET
    p_sip_day_of_month = 30;

ELSEIF v_mn = 2 THEN
SET
    p_sip_day_of_month = 28;

END IF;

END IF;

SET
    v_cur_date = Concat(
        v_yr,
        '/',
        v_mn,
        '/',
        CAST(p_sip_day_of_month AS CHAR(2))
    );

WHILE (v_counter <= p_duration) DO
SELECT
    entry_date AS v_entry_date,
    closing_nav AS v_closing_nav
FROM
    mpx_fund_detail
WHERE
    fund_code = p_fund_code
    AND entry_date =(
        SELECT
            TIMESTAMPADD(MONTH, - v_counter, v_cur_date)
    );

SET
    v_n_unit =(p_monthly_sip / v_closing_nav);

SET
    v_all_values = CONCAT(
        v_all_values,
        ',',
        CONVERT(p_monthly_sip * -1, char)
    );

SET
    v_all_dates = CONCAT(
        v_all_dates,
        ',',
        '"',
        CONVERT(FORMAT(v_entry_date, 'MM-dd-yyyy'), char(10)),
        '"'
    );

SET
    v_all_navs = CONCAT(v_all_navs, ',', CONVERT(v_closing_nav, char));

SET
    v_all_units = CONCAT(v_all_units, ',', CONVERT(v_n_unit, char));

SET
    v_tot_units = v_tot_units + v_n_unit;

SET
    v_n_unit = 0.00;

SET
    v_counter = v_counter + 1;

END WHILE;

SELECT
    closing_nav AS v_latest_nav,
    entry_date AS v_latest_date
FROM
    mpx_fund_detail
WHERE
    fund_code = p_fund_code
    AND entry_date =(
        SELECT
            max(entry_date)
        FROM
            mpx_fund_detail
        WHERE
            fund_code = p_fund_code
    );

SET
    v_current_value = v_tot_units * v_latest_nav;

SET
    v_all_values = CONCAT(
        v_all_values,
        ',',
        CONVERT(v_current_value, char)
    );

SET
    v_all_dates = CONCAT(
        v_all_dates,
        ',"',
        CONVERT(FORMAT(v_latest_date, 'MM-dd-yyyy'), char(10))
    );

SET
    v_all_units = CONCAT(v_all_units, ',', CONVERT(v_tot_units, char));

SET
    v_all_navs = CONCAT(v_all_navs, ',', CONVERT(v_latest_nav, char));

SET
    v_all_values = CONCAT(v_all_values, ']');

SET
    v_all_dates = CONCAT(v_all_dates, '"]');

SET
    v_all_navs = CONCAT(v_all_navs, ']');

SET
    v_all_units = CONCAT(v_all_units, ']');

SELECT
INSERT
    (v_all_units, 2, 1, '') as 'ALLUNITS',
INSERT
    (v_all_navs, 2, 1, '') as 'ALLNAVS',
INSERT
    (v_all_values, 2, 1, '') as 'ALLVALUES',
INSERT
    (v_all_dates, 2, 1, '') as 'ALLDATES',
    v_current_value as 'CURRENTVALUE',
    p_monthly_sip * p_duration as 'INVESTEDAMT';

END;

/ / DELIMITER;