DELIMITER / / CREATE PROCEDURE sp_fund_search_cat_lead_lag_with_name (p_entry_date VARCHAR(10), p_fund_type_id INT) BEGIN DECLARE v_FundCode varchar(50);

DECLARE QUARTILECURSOR CURSOR FOR
SELECT
    fund_code
FROM
    mpx_fund_master
WHERE
    fund_type_id = p_fund_type_id;

CREATE TEMPORARY TABLE tmp_cat_lag (
    NAMEOFFUND VARCHAR(100),
    INDICESNAME VARCHAR(100),
    SEVENDAYS DOUBLE,
    FORTEENDAYS DOUBLE,
    THIRTYDAYS DOUBLE,
    SIXTYDAYS DOUBLE,
    NINTYDAYS DOUBLE,
    SIXMONTHS DOUBLE,
    ONEYEAR DOUBLE,
    TWOYEAR DOUBLE,
    THREEYEAR DOUBLE,
    FIVEYEAR DOUBLE
);

CREATE TEMPORARY TABLE tmp_cat_lag_out (
    SEVENDAYS DOUBLE,
    THIRTYDAYS DOUBLE,
    NINTYDAYS DOUBLE,
    SIXMONTHS DOUBLE,
    ONEYEAR DOUBLE,
    TWOYEAR DOUBLE,
    THREEYEAR DOUBLE,
    FIVEYEAR DOUBLE,
    SEVENDAYS_G DOUBLE,
    THIRTYDAYS_G DOUBLE,
    NINTYDAYS_G DOUBLE,
    SIXMONTHS_G DOUBLE,
    ONEYEAR_G DOUBLE,
    TWOYEAR_G DOUBLE,
    THREEYEAR_G DOUBLE,
    FIVEYEAR_G DOUBLE,
    SEVENDAYS_NAME VARCHAR(100),
    THIRTYDAYS_NAME VARCHAR(100),
    NINTYDAYS_NAME VARCHAR(100),
    SIXMONTHS_NAME VARCHAR(100),
    ONEYEAR_NAME VARCHAR(100),
    TWOYEAR_NAME VARCHAR(100),
    THREEYEAR_NAME VARCHAR(100),
    FIVEYEAR_NAME VARCHAR(100),
    SEVENDAYS_G_NAME VARCHAR(100),
    THIRTYDAYS_G_NAME VARCHAR(100),
    NINTYDAYS_G_NAME VARCHAR(100),
    SIXMONTHS_G_NAME VARCHAR(100),
    ONEYEAR_G_NAME VARCHAR(100),
    TWOYEAR_G_NAME VARCHAR(100),
    THREEYEAR_G_NAME VARCHAR(100),
    FIVEYEAR_G_NAME VARCHAR(100)
);

OPEN QUARTILECURSOR;

FETCH QUARTILECURSOR INTO v_FundCode;

WHILE FETCH_STATUS = 0 DO
INSERT INTO
    tmp_cat_lag CALL sp_fund_search_scheme_ret(p_entry_date, v_FundCode);

FETCH QUARTILECURSOR INTO v_FundCode;

END WHILE;

CLOSE QUARTILECURSOR;

INSERT INTO
    tmp_cat_lag_out(
        SEVENDAYS,
        THIRTYDAYS,
        NINTYDAYS,
        SIXMONTHS,
        ONEYEAR,
        TWOYEAR,
        THREEYEAR,
        FIVEYEAR,
        SEVENDAYS_G,
        THIRTYDAYS_G,
        NINTYDAYS_G,
        SIXMONTHS_G,
        ONEYEAR_G,
        TWOYEAR_G,
        THREEYEAR_G,
        FIVEYEAR_G,
        SEVENDAYS_NAME,
        THIRTYDAYS_NAME,
        NINTYDAYS_NAME,
        SIXMONTHS_NAME,
        ONEYEAR_NAME,
        TWOYEAR_NAME,
        THREEYEAR_NAME,
        FIVEYEAR_NAME,
        SEVENDAYS_G_NAME,
        THIRTYDAYS_G_NAME,
        NINTYDAYS_G_NAME,
        SIXMONTHS_G_NAME,
        ONEYEAR_G_NAME,
        TWOYEAR_G_NAME,
        THREEYEAR_G_NAME,
        FIVEYEAR_G_NAME
    )
VALUES
    (
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' ',
        ' '
    );

UPDATE
    tmp_cat_lag_out
SET
    SEVENDAYS = (
        SELECT
            SEVENDAYS
        FROM
            tmp_cat_lag
        where
            SEVENDAYS <> 0
        ORDER BY
            SEVENDAYS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THIRTYDAYS = (
        SELECT
            THIRTYDAYS
        FROM
            tmp_cat_lag
        where
            THIRTYDAYS <> 0
        ORDER BY
            THIRTYDAYS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    NINTYDAYS = (
        SELECT
            NINTYDAYS
        FROM
            tmp_cat_lag
        where
            NINTYDAYS <> 0
        ORDER BY
            NINTYDAYS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    SIXMONTHS = (
        SELECT
            SIXMONTHS
        FROM
            tmp_cat_lag
        where
            SIXMONTHS <> 0
        ORDER BY
            SIXMONTHS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    ONEYEAR = (
        SELECT
            ONEYEAR
        FROM
            tmp_cat_lag
        where
            ONEYEAR <> 0
        ORDER BY
            ONEYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    TWOYEAR = (
        SELECT
            TWOYEAR
        FROM
            tmp_cat_lag
        where
            TWOYEAR <> 0
        ORDER BY
            TWOYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THREEYEAR = (
        SELECT
            THREEYEAR
        FROM
            tmp_cat_lag
        where
            THREEYEAR <> 0
        ORDER BY
            THREEYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    FIVEYEAR = (
        SELECT
            FIVEYEAR
        FROM
            tmp_cat_lag
        where
            FIVEYEAR <> 0
        ORDER BY
            FIVEYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    SEVENDAYS_G = (
        SELECT
            SEVENDAYS
        FROM
            tmp_cat_lag
        where
            SEVENDAYS <> 0
        ORDER BY
            SEVENDAYS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THIRTYDAYS_G = (
        SELECT
            THIRTYDAYS
        FROM
            tmp_cat_lag
        where
            THIRTYDAYS <> 0
        ORDER BY
            THIRTYDAYS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    NINTYDAYS_G = (
        SELECT
            NINTYDAYS
        FROM
            tmp_cat_lag
        where
            NINTYDAYS <> 0
        ORDER BY
            NINTYDAYS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    SIXMONTHS_G = (
        SELECT
            SIXMONTHS
        FROM
            tmp_cat_lag
        where
            SIXMONTHS <> 0
        ORDER BY
            SIXMONTHS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    ONEYEAR_G = (
        SELECT
            ONEYEAR
        FROM
            tmp_cat_lag
        where
            ONEYEAR <> 0
        ORDER BY
            ONEYEAR ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    TWOYEAR_G = (
        SELECT
            TWOYEAR
        FROM
            tmp_cat_lag
        where
            TWOYEAR <> 0
        ORDER BY
            TWOYEAR ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THREEYEAR_G = (
        SELECT
            THREEYEAR
        FROM
            tmp_cat_lag
        where
            THREEYEAR <> 0
        ORDER BY
            THREEYEAR ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    FIVEYEAR_G = (
        SELECT
            FIVEYEAR
        FROM
            tmp_cat_lag
        where
            FIVEYEAR <> 0
        ORDER BY
            FIVEYEAR ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    SEVENDAYS_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            SEVENDAYS <> 0
        ORDER BY
            SEVENDAYS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THIRTYDAYS_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            THIRTYDAYS <> 0
        ORDER BY
            THIRTYDAYS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    NINTYDAYS_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            NINTYDAYS <> 0
        ORDER BY
            NINTYDAYS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    SIXMONTHS_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            SIXMONTHS <> 0
        ORDER BY
            SIXMONTHS DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    ONEYEAR_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            ONEYEAR <> 0
        ORDER BY
            ONEYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    TWOYEAR_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            TWOYEAR <> 0
        ORDER BY
            TWOYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THREEYEAR_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            THREEYEAR <> 0
        ORDER BY
            THREEYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    FIVEYEAR_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            FIVEYEAR <> 0
        ORDER BY
            FIVEYEAR DESC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    SEVENDAYS_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            SEVENDAYS <> 0
        ORDER BY
            SEVENDAYS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THIRTYDAYS_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            THIRTYDAYS <> 0
        ORDER BY
            THIRTYDAYS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    NINTYDAYS_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            NINTYDAYS <> 0
        ORDER BY
            NINTYDAYS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    SIXMONTHS_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            SIXMONTHS <> 0
        ORDER BY
            SIXMONTHS ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    ONEYEAR_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            ONEYEAR <> 0
        ORDER BY
            ONEYEAR ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    TWOYEAR_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            TWOYEAR <> 0
        ORDER BY
            TWOYEAR ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    THREEYEAR_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            THREEYEAR <> 0
        ORDER BY
            THREEYEAR ASC
        LIMIT
            1
    );

UPDATE
    tmp_cat_lag_out
SET
    FIVEYEAR_G_NAME = (
        SELECT
            NAMEOFFUND
        FROM
            tmp_cat_lag
        where
            FIVEYEAR <> 0
        ORDER BY
            FIVEYEAR ASC
        LIMIT
            1
    );

SELECT
    *
FROM
    tmp_cat_lag_out;

END;

/ / DELIMITER;