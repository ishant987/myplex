DELIMITER / / CREATE PROCEDURE sp_fund_search_cat_avg_med (p_entry_date VARCHAR(10), p_fund_type_id INT) BEGIN DECLARE v_FundCode varchar(50);

DECLARE QUARTILECURSOR CURSOR FOR
SELECT
    fund_code
FROM
    mpx_fund_master
WHERE
    fund_type_id = p_fund_type_id;

CREATE TEMPORARY TABLE tmp_cat_avg_med (
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

CREATE TEMPORARY TABLE tmp_cat_avg_med_out (
    SEVENDAYS DOUBLE,
    FORTEENDAYS DOUBLE,
    THIRTYDAYS DOUBLE,
    SIXTYDAYS DOUBLE,
    NINTYDAYS DOUBLE,
    SIXMONTHS DOUBLE,
    ONEYEAR DOUBLE,
    TWOYEAR DOUBLE,
    THREEYEAR DOUBLE,
    FIVEYEAR DOUBLE,
    SEVENDAYS_G DOUBLE,
    FORTEENDAYS_G DOUBLE,
    THIRTYDAYS_G DOUBLE,
    SIXTYDAYS_G DOUBLE,
    NINTYDAYS_G DOUBLE,
    SIXMONTHS_G DOUBLE,
    ONEYEAR_G DOUBLE,
    TWOYEAR_G DOUBLE,
    THREEYEAR_G DOUBLE,
    FIVEYEAR_G DOUBLE
);

OPEN QUARTILECURSOR;

FETCH QUARTILECURSOR INTO v_FundCode;

WHILE FETCH_STATUS = 0 DO
INSERT INTO
    tmp_cat_avg_med CALL sp_fund_search_scheme_ret(p_entry_date, v_FundCode);

FETCH QUARTILECURSOR INTO v_FundCode;

END WHILE;

CLOSE QUARTILECURSOR;

INSERT INTO
    tmp_cat_avg_med_out(
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
        FIVEYEAR_G
    )
VALUES
    (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

UPDATE
    tmp_cat_avg_med_out
SET
    SEVENDAYS = (
        SELECT
            AVG(SEVENDAYS)
        FROM
            tmp_cat_avg_med
    );

UPDATE
    tmp_cat_avg_med_out
SET
    THIRTYDAYS = (
        SELECT
            AVG(THIRTYDAYS)
        FROM
            tmp_cat_avg_med
    );

UPDATE
    tmp_cat_avg_med_out
SET
    NINTYDAYS = (
        SELECT
            AVG(NINTYDAYS)
        FROM
            tmp_cat_avg_med
    );

UPDATE
    tmp_cat_avg_med_out
SET
    SIXMONTHS = (
        SELECT
            AVG(SIXMONTHS)
        FROM
            tmp_cat_avg_med
    );

UPDATE
    tmp_cat_avg_med_out
SET
    ONEYEAR = (
        SELECT
            AVG(ONEYEAR)
        FROM
            tmp_cat_avg_med
        where
            ONEYEAR <> 0
    );

UPDATE
    tmp_cat_avg_med_out
SET
    TWOYEAR = (
        SELECT
            AVG(TWOYEAR)
        FROM
            tmp_cat_avg_med
        where
            TWOYEAR <> 0
    );

UPDATE
    tmp_cat_avg_med_out
SET
    THREEYEAR = (
        SELECT
            AVG(THREEYEAR)
        FROM
            tmp_cat_avg_med
        where
            THREEYEAR <> 0
    );

UPDATE
    tmp_cat_avg_med_out
SET
    FIVEYEAR = (
        SELECT
            AVG(FIVEYEAR)
        FROM
            tmp_cat_avg_med
        where
            FIVEYEAR <> 0
    );

UPDATE
    tmp_cat_avg_med_out
SET
    SEVENDAYS_G = (
        SELECT
            MAX(X.SEVENDAYS)
        FROM
            (
                SELECT
                    SEVENDAYS
                FROM
                    tmp_cat_avg_med
                order by
                    SEVENDAYS
                LIMIT
                    50
            ) X
    );

UPDATE
    tmp_cat_avg_med_out
SET
    THIRTYDAYS_G = (
        SELECT
            MAX(X.THIRTYDAYS)
        FROM
            (
                SELECT
                    THIRTYDAYS
                FROM
                    tmp_cat_avg_med
                order by
                    THIRTYDAYS
                LIMIT
                    50
            ) X
    );

UPDATE
    tmp_cat_avg_med_out
SET
    NINTYDAYS_G = (
        SELECT
            MAX(X.NINTYDAYS)
        FROM
            (
                SELECT
                    NINTYDAYS
                FROM
                    tmp_cat_avg_med
                order by
                    NINTYDAYS
                LIMIT
                    50
            ) X
    );

UPDATE
    tmp_cat_avg_med_out
SET
    SIXMONTHS_G = (
        SELECT
            MAX(X.SIXMONTHS)
        FROM
            (
                SELECT
                    SIXMONTHS
                FROM
                    tmp_cat_avg_med
                order by
                    SIXMONTHS
                LIMIT
                    50
            ) X
    );

UPDATE
    tmp_cat_avg_med_out
SET
    ONEYEAR_G = (
        SELECT
            MAX(X.ONEYEAR)
        FROM
            (
                SELECT
                    ONEYEAR
                FROM
                    tmp_cat_avg_med
                where
                    ONEYEAR <> 0
                order by
                    ONEYEAR
                LIMIT
                    50
            ) X
    );

UPDATE
    tmp_cat_avg_med_out
SET
    TWOYEAR_G = (
        SELECT
            MAX(X.TWOYEAR)
        FROM
            (
                SELECT
                    TWOYEAR
                FROM
                    tmp_cat_avg_med
                where
                    TWOYEAR <> 0
                order by
                    ONEYEAR
                LIMIT
                    50
            ) X
    );

UPDATE
    tmp_cat_avg_med_out
SET
    THREEYEAR_G =(
        SELECT
            MAX(X.THREEYEAR)
        FROM
            (
                SELECT
                    THREEYEAR
                FROM
                    tmp_cat_avg_med
                where
                    THREEYEAR <> 0
                order by
                    ONEYEAR
                LIMIT
                    50
            ) X
    );

UPDATE
    tmp_cat_avg_med_out
SET
    FIVEYEAR_G = (
        SELECT
            MAX(X.FIVEYEAR)
        FROM
            (
                SELECT
                    FIVEYEAR
                FROM
                    tmp_cat_avg_med
                where
                    FIVEYEAR <> 0
                order by
                    ONEYEAR
                LIMIT
                    50
            ) X
    );

SELECT
    *
FROM
    tmp_cat_avg_med_out;

END;

/ / DELIMITER;