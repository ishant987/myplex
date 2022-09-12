DELIMITER / / CREATE PROCEDURE sp_monthly_ranking_aaum (p_end_date VARCHAR(10), p_fund_type_id INT) BEGIN DECLARE NOT_FOUND INT DEFAULT 0;

DECLARE v_StartDate DATETIME(3);

DECLARE v_EntryDate DATE;

DECLARE v_EntryDate1 DATE;

DECLARE v_ClosingNav DOUBLE;

DECLARE v_ClosingNav1 DOUBLE;

DECLARE v_ClosingValue DOUBLE;

DECLARE v_ClosingValue1 DOUBLE;

DECLARE v_STDate DATE;

DECLARE v_LastDate DATE;

declare v_FundCode VARCHAR(50);

DECLARE v_CL_ST DOUBLE;

DECLARE v_CL_EN DOUBLE;

DECLARE v_IV_ST DOUBLE;

DECLARE v_IV_EN DOUBLE;

DECLARE v_Day INT;

DECLARE v_Day_R INT;

DECLARE v_CAGR DOUBLE;

DECLARE v_pow DOUBLE;

DECLARE v_V_AAUM DOUBLE;

DECLARE C CURSOR FOR
SELECT
	DISTINCT FundCode
FROM
	TmpFundMaster
ORDER BY
	FundCode;

DECLARE MYCURSOR CURSOR FOR
SELECT
	EntryDate,
	ClosingNav
FROM
	TmpFundMaster
WHERE
	FundCode = v_FundCode;

DECLARE MYCURSOR1 CURSOR FOR
SELECT
	EntryDate,
	ClosingNav
FROM
	TmpFundMaster
WHERE
	EntryDate < v_LastDate
	AND FundCode = v_FundCode;

DECLARE CONTINUE HANDLER FOR NOT FOUND
SET
	NOT_FOUND = 1;

CREATE TEMPORARY TABLE TmpFund (
	FundCode VARCHAR(50),
	NameOfFund VARCHAR(510),
	OpDate DATETIME(3),
	AAUM DOUBLE,
	return_percent DOUBLE NOT NULL DEFAULT 0,
	FundTypeID INT
);

CREATE TEMPORARY TABLE TmpFundMaster (
	FundCode VARCHAR(50),
	EntryDate DATE,
	ClosingValue DOUBLE NULL DEFAULT 0,
	ClosingNav DOUBLE NULL,
	Nav_Change DOUBLE NOT NULL DEFAULT 0,
	index_Change DOUBLE NOT NULL DEFAULT 0
);

SET
	v_StartDate = TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_end_date, 103));

INSERT INTO
	TmpFund (
		FundCode,
		NameOfFund,
		OpDate,
		FundTypeID
	)
SELECT
	fund_code,
	fund_name,
	fund_opened,
	fund_type_id
FROM
	mpx_fund_master
WHERE
	FundTypeID = p_fund_type_id;

INSERT INTO
	TmpFundMaster (FundCode, EntryDate, ClosingNav)
SELECT
	m.fund_code,
	f.entry_date,
	f.closing_nav
FROM
	mpx_fund_detail_mr as f
	INNER JOIN mpx_fund_master m ON m.fund_code = f.fund_code
WHERE
	m.fund_code IN (
		SELECT
			FundCode
		FROM
			TmpFund
	)
	AND f.closing_nav > 0
	AND f.holiday = 0
	AND f.entry_date BETWEEN STR_TO_DATE(v_StartDate, 103)
	AND STR_TO_DATE(p_end_date, 103)
ORDER BY
	1 DESC;

OPEN C;

FETCH C INTO v_FundCode;

WHILE NOT_FOUND = 0 DO
SET
	v_STDate = (
		SELECT
			EntryDate
		FROM
			TmpFundMaster
		WHERE
			FundCode = v_FundCode
		ORDER BY
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
		WHERE
			FundCode = v_FundCode
		ORDER BY
			EntryDate DESC
		LIMIT
			1
	);

SET
	v_CL_ST = 0,
	v_CL_EN = 0,
	v_IV_ST = 0,
	v_IV_EN = 0,
	v_CAGR = 0;

SET
	NOT_FOUND = 0;

OPEN MYCURSOR;

SET
	NOT_FOUND = 0;

OPEN MYCURSOR1;

FETCH MYCURSOR INTO v_EntryDate,
v_ClosingNav;

FETCH MYCURSOR1 INTO v_EntryDate1,
v_ClosingNav1;

WHILE NOT_FOUND = 0 DO
UPDATE
	TmpFundMaster
SET
	Nav_Change = ((v_ClosingNav - v_ClosingNav1) / v_ClosingNav1) * 100
WHERE
	EntryDate = v_EntryDate
	AND FundCode = v_FundCode;

FETCH MYCURSOR INTO v_EntryDate,
v_ClosingNav;

FETCH MYCURSOR1 INTO v_EntryDate1,
v_ClosingNav1;

END WHILE;

CLOSE MYCURSOR;

CLOSE MYCURSOR1;

SELECT
	IFNULL(ClosingNav, 0) INTO v_CL_ST
FROM
	TmpFundMaster
WHERE
	EntryDate = v_STDate
	AND FundCode = v_FundCode;

SELECT
	IFNULL(ClosingNav, 0) INTO v_CL_EN
FROM
	TmpFundMaster
WHERE
	EntryDate = v_LastDate
	AND FundCode = v_FundCode;

SET
	v_CAGR = 0;

SET
	v_Day = TIMESTAMPDIFF(
		DAY,
		STR_TO_DATE(v_StartDate, 103),
		STR_TO_DATE(p_end_date, 103)
	);

SET
	v_Day_R = TIMESTAMPDIFF(
		DAY,
		STR_TO_DATE(v_STDate, 103),
		STR_TO_DATE(v_LastDate, 103)
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

UPDATE
	TmpFund
SET
	return_percent = IFNULL(v_CAGR, 0)
WHERE
	FundCode = v_FundCode;

UPDATE
	TmpFund
SET
	AAUM = (
		SELECT
			DISTINCT CorpusEntry
		FROM
			mpx_corpus_entry
		WHERE
			EntryDate = STR_TO_DATE(p_end_date, 103)
			and FundCode = v_FundCode
	)
WHERE
	FundCode = v_FundCode;

FETCH C INTO v_FundCode;

END WHILE;

CLOSE C;

INSERT INTO
	monthly_ranking_aaum (
		fund_code,
		fund_name,
		fund_opened,
		aaum,
		pre_aaum,
		aaum_return,
		fund_type_id,
		run_date
	)
SELECT
	T.FundCode,
	T.NameOfFund,
	T.OpDate OpDate,
	T.AAUM,
	PRE.CorpusEntry PRE_AAUM,
	T.return_percent 'RETURN',
	T.FundTypeID,
	STR_TO_DATE(p_end_date, 103)
FROM
	TmpFund T
	LEFT JOIN (
		SELECT
			DISTINCT fund_code,
			corpus_entry
		FROM
			mpx_corpus_entry
		WHERE
			entry_date = STR_TO_DATE(p_end_date, 103)
	) C ON C.fund_code = T.FundCode
	LEFT JOIN (
		SELECT
			DISTINCT fund_code,
			corpus_entry
		FROM
			mpx_corpus_entry
		WHERE
			entry_date = STR_TO_DATE(v_StartDate, 103)
	) PRE ON PRE.fund_code = T.FundCode
ORDER BY
	NameOfFund;

UPDATE
	monthly_ranking_aaum
SET
	aaum_return = NULL
WHERE
	TIMESTAMPDIFF(
		DAY,
		STR_TO_DATE(OpDate, 103),
		STR_TO_DATE(RUNDATE, 103)
	) < 365;

END;

/ / DELIMITER;