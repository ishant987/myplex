DELIMITER / / CREATE PROCEDURE sp_quartile_compute_cagr() BEGIN DECLARE v_quartile DOUBLE;

DECLARE v_FQuartile DOUBLE;

DECLARE v_SQuartile DOUBLE;

DECLARE v_TQuartile DOUBLE;

DECLARE v_4Quartile DOUBLE;

DECLARE v_FundCode VARCHAR(25);

DECLARE v_FetchValue DOUBLE;

DECLARE QUARTILECURSOR CURSOR FOR
SELECT
    fund_code,
    cagr_value
FROM
    final_ratio_data;

SET
    v_quartile = (
        SELECT
            (MAX(cagr_value) - MIN(cagr_value)) AS QUARDIFF
        FROM
            final_ratio_data
    );

SET
    v_quartile = (v_quartile / 4);

SET
    v_quartile = CAST(v_quartile AS DECIMAL(10, 5));

SET
    v_FQuartile = (
        SELECT
            MAX(cagr_value) AS FQUARTILE
        FROM
            final_ratio_data
    );

SET
    v_FQuartile = CAST((v_FQuartile - v_quartile) AS DECIMAL(10, 5));

SET
    v_SQuartile = CAST((v_FQuartile - v_quartile) AS DECIMAL(10, 5));

SET
    v_TQuartile = CAST((v_SQuartile - v_quartile) AS DECIMAL(10, 5));

SET
    v_4Quartile = CAST((v_TQuartile - v_quartile) AS DECIMAL(10, 5));

OPEN QUARTILECURSOR;

FETCH QUARTILECURSOR INTO v_FundCode,
v_FetchValue;

WHILE FETCH_STATUS = 0 DO
SET
    v_FetchValue = CAST(v_FetchValue AS DECIMAL(10, 5));

IF v_FetchValue >= v_4Quartile
AND v_FetchValue < v_TQuartile THEN
UPDATE
    final_ratio_data
SET
    QUARTILE = 4
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_TQuartile
AND v_FetchValue < v_SQuartile THEN
UPDATE
    final_ratio_data
SET
    QUARTILE = 3
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_SQuartile
AND v_FetchValue < v_FQuartile THEN
UPDATE
    final_ratio_data
SET
    QUARTILE = 2
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_FQuartile THEN
UPDATE
    final_ratio_data
SET
    QUARTILE = 1
WHERE
    final_ratio_data.fund_code = v_FundCode;

END IF;

FETCH QUARTILECURSOR INTO v_FundCode,
v_FetchValue;

END WHILE;

CLOSE QUARTILECURSOR;

UPDATE
    final_ratio_data
SET
    QUARTILE = 4
WHERE
    QUARTILE IS NULL;

END;

/ / DELIMITER;