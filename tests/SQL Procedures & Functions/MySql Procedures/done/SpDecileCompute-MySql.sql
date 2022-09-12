DELIMITER / / CREATE PROCEDURE sp_decile_compute() BEGIN DECLARE v_Quartile DOUBLE;

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
    comp_value
FROM
    quartile_data OPEN;

SET
    v_Quartile = (
        SELECT
            (MAX(comp_value) - MIN(comp_value)) AS QUARDIFF
        FROM
            quartile_data
    );

SET
    v_Quartile = (v_Quartile / 10);

SET
    v_Quartile = CAST(v_Quartile AS DECIMAL(10, 5));

SET
    v_FQuartile = (
        SELECT
            MAX(comp_value) AS FQUARTILE
        FROM
            quartile_data
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
            MIN(comp_value) AS FQUARTILE
        FROM
            quartile_data
    );

OPEN QUARTILECURSOR;

FETCH QUARTILECURSOR INTO v_FundCode,
v_FetchValue;

WHILE FETCH_STATUS = 0 DO
SET
    v_FetchValue = CAST(v_FetchValue AS DECIMAL(10, 5));

IF v_FetchValue >= v_10Quartile
AND v_FetchValue < v_9Quartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 10
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_9Quartile
AND v_FetchValue < v_8Quartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 9
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_8Quartile
AND v_FetchValue < v_7Quartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 8
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_7Quartile
AND v_FetchValue < v_6Quartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 7
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_6Quartile
AND v_FetchValue < v_5Quartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 6
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_5Quartile
AND v_FetchValue < v_4Quartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 5
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_4Quartile
AND v_FetchValue < v_TQuartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 4
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_TQuartile
AND v_FetchValue < v_SQuartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 3
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_SQuartile
AND v_FetchValue < v_FQuartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 2
WHERE
    quartile_data.fund_code = v_FundCode;

ELSEIF v_FetchValue >= v_FQuartile THEN
UPDATE
    quartile_data
SET
    QUARTILE = 1
WHERE
    quartile_data.fund_code = v_FundCode;

END IF;

FETCH QUARTILECURSOR INTO v_FundCode,
v_FetchValue;

END WHILE;

CLOSE QUARTILECURSOR;

UPDATE
    quartile_data
SET
    QUARTILE = 10
WHERE
    QUARTILE IS NULL;

END;

/ / DELIMITER;