DELIMITER / / CREATE PROCEDURE sp_decile_compute_cagr() BEGIN DECLARE v_Quartile DOUBLE;

DECLARE v_FQuartile DOUBLE;

DECLARE v_SQuartile DOUBLE;

DECLARE v_TQuartile DOUBLE;

DECLARE v_4Quartile DOUBLE;

DECLARE v_5Quartile DOUBLE;

DECLARE v_6Quartile DOUBLE;

DECLARE v_7Quartile DOUBLE;

DECLARE v_8Quartile DOUBLE;

DECLARE v_9Quartile DOUBLE;

DECLARE v_10Quartile DOUBLE;

DECLARE v_LQuartile DOUBLE;

DECLARE v_FundCode VARCHAR(25);

DECLARE v_FetchValue DOUBLE;

DECLARE QUARTILECURSOR CURSOR FOR
SELECT
    fund_code,
    cagr_value
FROM
    final_ratio_data;

SET
    v_Quartile = (
        SELECT
            (MAX(cagr_value) - MIN(cagr_value)) AS QUARDIFF
        FROM
            final_ratio_data
    );

SET
    v_Quartile = (v_Quartile / 10);

SET
    v_Quartile = CAST(v_Quartile AS DECIMAL(10, 5));

SET
    v_FQuartile = (
        SELECT
            MAX(cagr_value) AS FQUARTILE
        FROM
            final_ratio_data
    );

SET
    v_FQuartile = CAST(v_FQuartile AS DECIMAL(10, 5));

SET
    v_SQuartile = CAST((v_FQuartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_TQuartile = CAST((v_SQuartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_4Quartile = CAST((v_TQuartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_5Quartile = CAST((v_4Quartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_6Quartile = CAST((v_5Quartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_7Quartile = CAST((v_6Quartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_8Quartile = CAST((v_7Quartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_9Quartile = CAST((v_8Quartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_10Quartile = CAST((v_9Quartile - v_Quartile) AS DECIMAL(10, 5));

SET
    v_LQuartile = (
        SELECT
            MIN(cagr_value) AS FQUARTILE
        FROM
            final_ratio_data
    );

OPEN QUARTILECURSOR;

FETCH QUARTILECURSOR INTO v_FundCode,
v_FetchValue;

WHILE FETCH_STATUS = 0 DO
SET
    v_FetchValue = CAST(v_FetchValue AS DECIMAL(10, 5));

IF v_FetchValue >= v_LQuartile
AND v_FetchValue < v_10Quartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 10
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_10Quartile
AND v_FetchValue < v_9Quartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 9
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_9Quartile
AND v_FetchValue < v_8Quartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 8
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_8Quartile
AND v_FetchValue < v_7Quartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 7
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_7Quartile
AND v_FetchValue < v_6Quartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 6
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_6Quartile
AND v_FetchValue < v_5Quartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 5
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_5Quartile
AND v_FetchValue < v_4Quartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 4
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_4Quartile
AND v_FetchValue < v_TQuartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 3
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_TQuartile
AND v_FetchValue < v_SQuartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 2
WHERE
    final_ratio_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_SQuartile
AND v_FetchValue <= v_FQuartile THEN
UPDATE
    final_ratio_data
SET
    DECILE = 1
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
    DECILE = 10
WHERE
    DECILE IS NULL;

END;

/ / DELIMITER;