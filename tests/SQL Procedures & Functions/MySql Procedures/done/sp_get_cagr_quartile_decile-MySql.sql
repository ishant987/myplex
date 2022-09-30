DELIMITER $$
CREATE PROCEDURE `sp_get_cagr_quartile_decile`(IN `p_start_date` DATE, IN `p_end_date` DATE, IN `p_fund_code_in` VARCHAR(100), IN `p_fund_type_id` INT)
BEGIN
DECLARE v_CL_ST DOUBLE;

DECLARE v_CL_EN DOUBLE;

DECLARE v_Day INT;

DECLARE v_CAGR DOUBLE;

DECLARE v_pow DOUBLE;

DECLARE v_fund_code VARCHAR(50);

DECLARE FETCH_STATUS INT DEFAULT 0;

DECLARE CURSOR1 CURSOR FOR
SELECT
    m1.fund_code
FROM
    mpx_fund_master m1
where
    fund_opened <= p_start_date
    and m1.fund_type_id = p_fund_type_id;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET FETCH_STATUS = 1;

DROP TABLE IF EXISTS final_ratio_data;
CREATE TEMPORARY TABLE final_ratio_data (
    fund_code VARCHAR(25),
    cagr_value DOUBLE NULL,
    quartile INT NULL,
    decile INT NULL
);

DROP TABLE IF EXISTS tmp_fund_master;
CREATE TEMPORARY TABLE tmp_fund_master (
    fund_code VARCHAR(50),
    entry_date DATE,
    closing_nav DOUBLE NULL
);

INSERT INTO
    tmp_fund_master (fund_code, entry_date, closing_nav)
select
    m.fund_code,
    f.entry_date,
    ifnull(f.closing_nav, 0.00)
from
    mpx_fund_detail f
    inner join mpx_fund_master m on m.fund_code = f.fund_code
where
    m.fund_type_id = p_fund_type_id
    and f.closing_nav > 0
    and f.holiday = 0
    and f.entry_date between p_start_date
    and p_end_date;

OPEN CURSOR1;

FETCH CURSOR1 INTO v_fund_code;

WHILE FETCH_STATUS = 0 DO
SET v_CL_ST = (SELECT
    closing_nav AS "v_CL_ST"
FROM
    tmp_fund_master
where
    entry_date = (
        SELECT
            entry_date
        FROM
            tmp_fund_master
        where
            fund_code = v_fund_code
        order by
            entry_date
 ASC
        LIMIT
            1
    )
    and fund_code = v_fund_code);

SET v_CL_EN = (SELECT
    closing_nav AS "v_CL_EN"
FROM
    tmp_fund_master
where
    entry_date = (
        SELECT
            entry_date
        FROM
            tmp_fund_master
        where
            fund_code = v_fund_code
        order by
            entry_date desc
        LIMIT
            1
    )
    and fund_code = v_fund_code);

SET
 v_Day = TIMESTAMPDIFF(
        DAY,
        p_start_date,
        p_end_date
    );

IF v_Day > 365 THEN
SET
 v_pow = v_Day / 365.0;

ELSE
SET
 v_pow = 1;

END IF;

SET
 v_pow = 1.0 / v_pow;

SET
 v_CAGR = (POWER((v_CL_EN / v_CL_ST), v_pow) - 1) * 100;

INSERT INTO
    final_ratio_data (fund_code, cagr_value,quartile,decile)
VALUES
    (v_fund_code, v_CAGR,null,null);

FETCH CURSOR1 INTO v_fund_code;

END WHILE;

CLOSE CURSOR1;

SELECT t1.fund_code,t1.cagr_value,t2.quartile,t2.decile FROM final_ratio_data t1
INNER JOIN    
(SELECT final_ratio_data.fund_code,final_ratio_data.cagr_value, NTILE(4) OVER(ORDER BY cagr_value) AS quartile, NTILE(10) OVER(ORDER BY cagr_value) AS decile FROM final_ratio_data) t2
ON t1.fund_code = t2.fund_code
WHERE t1.fund_code = p_fund_code_in;

END$$
DELIMITER ;