DELIMITER / / CREATE PROCEDURE sp_rolling_return (
    p_start_date VARCHAR(10),
    p_end_date VARCHAR(10),
    p_fund_code VARCHAR(50)
) BEGIN DECLARE v_entry_date DATETIME(3);

DECLARE v_closing_nav DOUBLE;

DECLARE v_pre_val DOUBLE;

DECLARE v_percentage_change DOUBLE;

DECLARE MYCURSOR CURSOR FOR
SELECT
    entry_date,
    closing_nav
FROM
    tmp_fund_master OPEN;

CREATE TEMPORARY TABLE tmp_fund_master (
    entry_date DATETIME(3),
    closing_nav DOUBLE NULL,
    percentage_change DOUBLE NULL
);

INSERT INTO
    tmp_fund_master (entry_date, closing_nav)
SELECT
    entry_date,
    closing_nav
FROM
    mpx_fund_detail
WHERE
    fund_code = p_fund_code
    AND entry_date BETWEEN timestampadd(day, -30, STR_TO_DATE(p_start_date, 103))
    and STR_TO_DATE(p_end_date, 103)
ORDER BY
    entry_date DESC;

OPEN MYCURSOR;

FETCH MYCURSOR INTO v_entry_date,
v_closing_nav;

WHILE FETCH_STATUS = 0 DO
SET
    v_pre_val = (
        SELECT
            closing_nav
        FROM
            tmp_fund_master
        where
            entry_date = timestampadd(day, -30, v_entry_date)
    );

SET
    v_percentage_change =(
        (v_closing_nav - v_pre_val) / v_pre_val * 100 * 12
    );

update
    tmp_fund_master
set
    percentage_change = v_percentage_change
where
    entry_date = v_entry_date;

FETCH MYCURSOR INTO v_entry_date,
v_closing_nav;

END WHILE;

CLOSE MYCURSOR;

SET
    v_percentage_change = (
        SELECT
            AVG(percentage_change)
        from
            tmp_fund_master
        WHERE
            entry_date >= STR_TO_DATE(p_start_date, 103)
    );

select
    fund_name,
    v_percentage_change AS ratio
from
    mpx_fund_master
where
    fund_code = p_fund_code;

drop TABLE tmp_fund_master;

END;

/ / DELIMITER;