DELIMITER / / CREATE PROCEDURE sp_get_beta_mr (
    p_start_date VARCHAR(10),
    p_end_date VARCHAR(10),
    p_fund_code VARCHAR(50),
    p_risk_free_return DOUBLE
) BEGIN DECLARE FETCH_STATUS INT DEFAULT 0;

DECLARE v_EntryDate DATE;

DECLARE v_EntryDate1 DATE;

DECLARE v_ClosingNav DOUBLE;

DECLARE v_ClosingNav1 DOUBLE;

DECLARE v_ClosingValue DOUBLE;

DECLARE v_ClosingValue1 DOUBLE;

DECLARE v_STDate DATE;

DECLARE v_LastDate DATE;

DECLARE v_INDEX_CHANGE_AVG DOUBLE;

DECLARE v_SUM_multiple_nclv_iclv DOUBLE;

DECLARE v_COVARIENCE DOUBLE;

DECLARE v_VARIENCE DOUBLE;

DECLARE v_CL_ST DOUBLE;

DECLARE v_CL_EN DOUBLE;

DECLARE v_IV_ST DOUBLE;

DECLARE v_IV_EN DOUBLE;

DECLARE v_volatility DOUBLE;

DECLARE v_TrackingErr DOUBLE;

DECLARE v_Day INT;

DECLARE v_CAGR DOUBLE;

DECLARE v_pow DOUBLE;

DECLARE v_Portfolio_Return DOUBLE;

DECLARE v_Market_Return DOUBLE;

DECLARE v_Beta DOUBLE;

DECLARE v_cnt BIGINT;

DECLARE v_H247 DOUBLE;

DECLARE v_H247CNT DOUBLE;

DECLARE v_L13 DOUBLE;

DECLARE v_P35 DOUBLE;

DECLARE v_X DOUBLE;

DECLARE v_Y DOUBLE;

DECLARE v_XY DOUBLE;

DECLARE v_X2 DOUBLE;

DECLARE v_Y2 DOUBLE;

DECLARE v_O11 DOUBLE;

DECLARE v_O13X DOUBLE;

DECLARE v_O13Y DOUBLE;

DECLARE v_O13 DOUBLE;

DECLARE v_B4 DOUBLE;

DECLARE v_B6 DOUBLE;

DECLARE v_NAV_CHANGE_AVG DOUBLE;

DECLARE MYCURSOR CURSOR FOR
SELECT
    EntryDate,
    ClosingNav,
    ClosingValue
FROM
    TmpFundMaster;

DECLARE MYCURSOR1 CURSOR FOR
SELECT
    EntryDate,
    ClosingNav,
    ClosingValue
FROM
    TmpFundMaster
WHERE
    EntryDate < v_LastDate;

CREATE TEMPORARY TABLE TmpFundMaster (
    EntryDate DATE,
    ClosingValue DOUBLE NULL,
    ClosingNav DOUBLE NULL,
    Nav_Change DOUBLE NULL,
    index_Change DOUBLE NULL,
    Nav_Change_less_Avg DOUBLE NULL,
    index_Change_less_Avg DOUBLE NULL,
    multiple_nclv_iclv DOUBLE NULL
);

INSERT INTO
    TmpFundMaster (EntryDate, ClosingValue, ClosingNav)
select
    i.entry_date,
    ifnull(i.closing_nav, 0.00),
    ifnull(f.closing_nav, 0.00)
from
    mpx_fund_detail_mr f
    inner join mpx_fund_master m on m.fund_code = f.fund_code
    inner join mpx_indices_detail_mr i on i.entry_date = f.entry_date
    and i.name = m.indices_name
where
    m.fund_code = p_fund_code
    and f.closing_nav > 0
    and i.holiday = 0
    and i.entry_date between STR_TO_DATE(p_start_date, 103)
    and STR_TO_DATE(p_end_date, 103)
order by
    1 desc;

SET
    v_STDate = (
        SELECT
            EntryDate
        FROM
            TmpFundMaster
        order by
            EntryDate
        LIMIT
            1
    );

SET
    v_LastDate = (
        SELECT
            EntryDate
        FROM
            TmpFundMaster
        order by
            EntryDate desc
        LIMIT
            1
    );

OPEN MYCURSOR;

OPEN MYCURSOR1;

FETCH MYCURSOR INTO v_EntryDate,
v_ClosingNav,
v_ClosingValue;

FETCH MYCURSOR1 INTO v_EntryDate1,
v_ClosingNav1,
v_ClosingValue1;

SET
    FETCH_STATUS = 0;

WHILE FETCH_STATUS = 0 DO
UPDATE
    TmpFundMaster
SET
    index_Change = (
        (
            (v_ClosingValue - v_ClosingValue1) / v_ClosingValue1
        ) * 100
    ),
    Nav_Change = (
        ((v_ClosingNav - v_ClosingNav1) / v_ClosingNav1) * 100
    )
WHERE
    EntryDate = v_EntryDate;

FETCH MYCURSOR INTO v_EntryDate,
v_ClosingNav,
v_ClosingValue;

FETCH MYCURSOR1 INTO v_EntryDate1,
v_ClosingNav1,
v_ClosingValue1;

END WHILE;

CLOSE MYCURSOR;

CLOSE MYCURSOR1;

SELECT
    ClosingNav,
    ClosingValue INTO v_CL_ST,
    v_IV_ST
FROM
    TmpFundMaster
where
    EntryDate = v_STDate;

SELECT
    ClosingNav,
    ClosingValue INTO v_CL_EN,
    v_IV_EN
FROM
    TmpFundMaster
where
    EntryDate = v_LastDate;

SELECT
    STDEV(ClosingNav) INTO v_volatility
FROM
    TmpFundMaster;

SET
    v_Day = TIMESTAMPDIFF(
        DAY,
        STR_TO_DATE(p_start_date, 103),
        STR_TO_DATE(p_end_date, 103)
    );

SET
    p_risk_free_return = ((p_risk_free_return / 365) * v_Day);

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

DELETE FROM
    TmpFundMaster
WHERE
    EntryDate = v_STDate;

SET
    v_cnt = (
        SELECT
            COUNT(index_Change)
        FROM
            TmpFundMaster
    );

SELECT
    AVG(IFNULL(Nav_Change, 0)),
    AVG(IFNULL(index_Change, 0)) INTO v_NAV_CHANGE_AVG,
    v_INDEX_CHANGE_AVG
FROM
    TmpFundMaster;

UPDATE
    TmpFundMaster
SET
    Nav_Change_less_Avg = IFNULL(Nav_Change, 0) - v_NAV_CHANGE_AVG,
    index_Change_less_Avg = IFNULL(index_Change, 0) - v_INDEX_CHANGE_AVG;

UPDATE
    TmpFundMaster
SET
    multiple_nclv_iclv = IFNULL(Nav_Change_less_Avg, 0) * IFNULL(index_Change_less_Avg, 0);

SELECT
    SUM(multiple_nclv_iclv) INTO v_SUM_multiple_nclv_iclv
FROM
    TmpFundMaster;

SET
    v_COVARIENCE = v_SUM_multiple_nclv_iclv / v_cnt;

SELECT
    VAR(index_Change) INTO v_VARIENCE
FROM
    TmpFundMaster;

SET
    v_Beta = v_COVARIENCE / v_VARIENCE;

SET
    v_Portfolio_Return = (((v_CL_EN - v_CL_ST) / v_CL_ST) * 100);

SET
    v_Market_Return = (((v_IV_EN - v_IV_ST) / v_IV_ST) * 100);

SELECT
    SUM(POWER(Nav_Change - index_Change, 2)) INTO v_H247
FROM
    TmpFundMaster;

SET
    v_H247CNT = (v_H247 / v_cnt);

SET
    v_TrackingErr = CASE
        WHEN v_H247CNT > 0 THEN SQRT(v_H247CNT)
        ELSE 0
    END;

SET
    v_L13 = v_Market_Return - p_risk_free_return;

SET
    v_L13 = v_L13 * v_Beta;

SET
    v_P35 = (v_Portfolio_Return - p_risk_free_return);

SET
    v_X = (
        SELECT
            SUM(ClosingNav)
        FROM
            TmpFundMaster
    );

SET
    v_Y = (
        SELECT
            SUM(ClosingValue)
        FROM
            TmpFundMaster
    );

SET
    v_XY = (
        SELECT
            SUM(ClosingNav * ClosingValue)
        FROM
            TmpFundMaster
    );

SET
    v_X2 = (
        SELECT
            SUM(POWER(ClosingNav, 2))
        FROM
            TmpFundMaster
    );

SET
    v_Y2 = (
        SELECT
            SUM(POWER(ClosingValue, 2))
        FROM
            TmpFundMaster
    );

SET
    v_O11 = ((v_cnt * v_XY) - (v_X * v_Y));

SET
    v_O13X = (v_cnt * v_X2) - POWER(v_X, 2);

SET
    v_O13Y = (v_cnt * v_Y2) - POWER(v_Y, 2);

SET
    v_O13 = CASE
        WHEN (
            v_O13X > 0
            AND v_O13Y > 0
        ) THEN SQRT(v_O13X) * SQRT(v_O13Y)
        ELSE 0
    END;

SELECT
    AVG(Nav_Change - p_risk_free_return),
    STDEV(Nav_Change) INTO v_B4,
    v_B6
FROM
    TmpFundMaster;

INSERT INTO
    FINALRATIODATA (
        FUNDCODE,
        VARIANCE,
        BETAVALUE,
        STDEVVALUE,
        TRACKINGVALUE,
        SHARPEVALUE,
        TREYNORVALUE,
        RSQUAREVALUE,
        JENSENVALUE,
        INFVALUE,
        CAGRVALUE
    )
SELECT
    p_fund_code,
    VAR(index_Change) 'Variance',
    v_Beta 'Beta',
    v_volatility 'Volatility',
    v_TrackingErr 'Tracking error',
    CASE
        WHEN (
            v_B6 = 0
            OR v_B6 = null
        ) THEN null
        ELSE (v_B4 / v_B6)
    END AS 'Sharpe ratio',
    CASE
        WHEN (
            v_Beta = 0
            or v_Beta = null
        ) THEN null
        ELSE (v_B4 / v_Beta)
    END AS 'Treynor Ratio',
    CASE
        WHEN (
            v_O13 = 0
            or v_O13 = null
        ) THEN null
        ELSE POWER(v_O11 / v_O13, 2)
    END AS 'R-SQR',
    (v_P35 - v_L13) AS 'Alpha',
    CASE
        WHEN (
            v_TrackingErr = 0
            or v_TrackingErr = null
        ) THEN null
        ELSE (
            (v_Portfolio_Return - v_Market_Return) / v_TrackingErr
        )
    END AS 'Information Ratio',
    v_CAGR 'CAGR'
FROM
    TmpFundMaster;

DROP TABLE TmpFundMaster;

END;

/ / DELIMITER;