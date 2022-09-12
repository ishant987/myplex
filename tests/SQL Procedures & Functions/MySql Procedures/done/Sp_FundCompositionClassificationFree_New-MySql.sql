DELIMITER / / CREATE PROCEDURE sp_fund_composition_classification (p_type_id INT) BEGIN DECLARE v_SmallCapHVal BIGINT;

DECLARE v_SmallCapLVal BIGINT;

DECLARE v_MidCapHVal BIGINT;

DECLARE v_MidCapLVal BIGINT;

DECLARE v_LargeCapHVal BIGINT;

DECLARE v_LargeCapLVal BIGINT;

DECLARE v_VLargeCapHVal BIGINT;

DECLARE v_VLargeCapLVal BIGINT;

DECLARE v_EntryMonth INT;

DECLARE v_EntryYear BIGINT;

DECLARE v_LastDate DATETIME(3);

CREATE TEMPORARY TABLE TmpComposition (
	fund_code VARCHAR(50) COLLATE utf8_unicode_ci,
	SUMCASH DOUBLE,
	SUMSOV DOUBLE,
	SUMDEBT DOUBLE,
	SUMEQSMALL DOUBLE,
	SUMEQMID DOUBLE,
	SUMEQLARGE DOUBLE,
	SUMEQVLARGE DOUBLE,
	SUMEPS DOUBLE
) DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TEMPORARY TABLE TMP_INDICES_COMPOSITION (
	scrip_name VARCHAR(800) COLLATE utf8_unicode_ci,
	type VARCHAR(800) COLLATE utf8_unicode_ci,
	industry VARCHAR(800) COLLATE utf8_unicode_ci,
	percentage DOUBLE
) DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TEMPORARY TABLE TMP_INDICES_OTHER (scrip_name VARCHAR(800) COLLATE utf8_unicode_ci) DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TEMPORARY TABLE TMP_INDICES_COMPOSITION_RANK (
	RANK INT AUTO_INCREMENT,
	scrip_name VARCHAR(800) COLLATE utf8_unicode_ci,
	status VARCHAR(3) NOT NULL DEFAULT 'SC' COLLATE utf8_unicode_ci,
	PRIMARY KEY (RANK)
) DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TEMPORARY TABLE TMP_FUND_PORTFOLIO (
	fund_code VARCHAR(100) COLLATE utf8_unicode_ci,
	scrip_name VARCHAR(800) COLLATE utf8_unicode_ci,
	market_cap DOUBLE,
	content_per DOUBLE,
	pe DOUBLE,
	status VARCHAR(3) NULL COLLATE utf8_unicode_ci
) DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

SET
	v_LastDate = (
		SELECT
			entry_date
		FROM
			mpx_fund_composition
		ORDER BY
			entry_date DESC
		LIMIT
			1
	);

SET
	v_EntryMonth = MONTH(v_LastDate);

SET
	v_EntryYear = YEAR(v_LastDate);

INSERT INTO
	TMP_INDICES_COMPOSITION (scrip_name, type, industry, percentage)
SELECT
	scrip_name,
	type,
	industry,
	percentage
FROM
	mpx_indices_composition
WHERE
	MONTH(entry_date) = v_EntryMonth
	AND YEAR(entry_date) = v_EntryYear
	AND indices_name = 'BSE 500'
ORDER BY
	percentage DESC;

INSERT INTO
	TMP_INDICES_COMPOSITION_RANK (scrip_name)
SELECT
	scrip_name
FROM
	TMP_INDICES_COMPOSITION
WHERE
	`type` = 'Equity'
ORDER BY
	percentage DESC;

UPDATE
	TMP_INDICES_COMPOSITION_RANK
SET
	status = 'VLC'
WHERE
	RANK BETWEEN 1
	AND 15;

UPDATE
	TMP_INDICES_COMPOSITION_RANK
SET
	status = 'LC'
WHERE
	RANK BETWEEN 16
	AND 100;

UPDATE
	TMP_INDICES_COMPOSITION_RANK
SET
	status = 'MC'
WHERE
	RANK BETWEEN 101
	AND 250;

UPDATE
	TMP_INDICES_COMPOSITION_RANK
SET
	status = 'SC'
WHERE
	RANK > 250;

INSERT INTO
	TMP_INDICES_OTHER (scrip_name)
SELECT
	DISTINCT scrip_name
FROM
	mpx_mcap_eps
WHERE
	MONTH(entry_date) = v_EntryMonth
	AND YEAR(entry_date) = v_EntryYear
ORDER BY
	scrip_name ASC;

DELETE FROM
	TMP_INDICES_OTHER
WHERE
	scrip_name IN (
		SELECT
			DISTINCT scrip_name
		FROM
			TMP_INDICES_COMPOSITION_RANK
	);

INSERT INTO
	TMP_INDICES_COMPOSITION_RANK (scrip_name, status)
SELECT
	scrip_name,
	'SC'
FROM
	TMP_INDICES_OTHER;

INSERT INTO
	TmpComposition (
		fund_code,
		SUMCASH,
		SUMSOV,
		SUMDEBT,
		SUMEQSMALL,
		SUMEQMID,
		SUMEQLARGE,
		SUMEQVLARGE,
		SUMEPS
	)
SELECT
	fund_code,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0
FROM
	mpx_fund_master
WHERE
	mpx_fund_master.fund_type_id = p_type_id;

UPDATE
	(
		SELECT
			fund_code,
			SUM(content_per) AS SUMOFCASH
		FROM
			mpx_fund_composition
		WHERE
			MONTH(entry_date) = v_EntryMonth
			AND YEAR(entry_date) = v_EntryYear
			AND category = 'CASH'
		GROUP BY
			fund_code
	) X
	INNER JOIN TmpComposition T ON T.fund_code = X.fund_code
SET
	SUMCASH = X.SUMOFCASH;

UPDATE
	(
		SELECT
			fund_code,
			SUM(content_per) AS SUMOFSOV
		FROM
			mpx_fund_composition
		WHERE
			MONTH(entry_date) = v_EntryMonth
			AND YEAR(entry_date) = v_EntryYear
			AND category = 'SOV'
		GROUP BY
			fund_code
	) X
	INNER JOIN TmpComposition T ON T.fund_code = X.fund_code
SET
	SUMSOV = X.SUMOFSOV;

UPDATE
	(
		SELECT
			fund_code,
			SUM(content_per) AS SUMOFDEBT
		FROM
			mpx_fund_composition
		WHERE
			MONTH(entry_date) = v_EntryMonth
			AND YEAR(entry_date) = v_EntryYear
			AND category = 'Corporate Debt'
		GROUP BY
			fund_code
	) X
	INNER JOIN TmpComposition T ON T.fund_code = X.fund_code
SET
	SUMDEBT = X.SUMOFDEBT;

INSERT INTO
	TMP_FUND_PORTFOLIO (
		fund_code,
		scrip_name,
		market_cap,
		content_per,
		pe
	)
SELECT
	X.fund_code,
	X.scrip_name,
	Y.market_cap,
	X.content_per,
	Y.pe
FROM
	(
		SELECT
			C.fund_code,
			C.entry_date,
			C.scrip_name,
			C.content_per
		FROM
			mpx_fund_composition C
			INNER JOIN mpx_fund_master F ON C.fund_code = F.fund_code
		WHERE
			category = 'EQUITY'
			AND MONTH(C.entry_date) = v_EntryMonth
			AND YEAR(C.entry_date) = v_EntryYear
			AND F.fund_type_id = p_type_id
	) X
	LEFT JOIN mpx_mcap_eps Y ON X.scrip_name = Y.scrip_name
	AND X.entry_date = Y.entry_date
ORDER BY
	X.fund_code,
	X.scrip_name;

UPDATE
	TMP_FUND_PORTFOLIO P,
	TMP_INDICES_COMPOSITION_RANK I
SET
	P.status = I.status
WHERE
	P.scrip_name = I.scrip_name;

UPDATE
	(
		SELECT
			Z.fund_code,
			SUM(IFNULL(SMALLCONTENTPER, 0)) AS SUMSCONT,
			SUM(IFNULL(MIDCONTENTPER, 0)) AS SUMMCONT,
			SUM(IFNULL(LARGECONTENTPER, 0)) AS SUMLCONT,
			SUM(IFNULL(VLARGECONTENTPER, 0)) AS SUMVCONT,
			SUM(IFNULL(EPSVALUE, 0)) AS EPSSUM
		FROM
			(
				SELECT
					FINALDATA.fund_code,
					SUM(
						CASE
							WHEN status = 'SC' THEN content_per
						END
					) AS SMALLCONTENTPER,
					SUM(
						CASE
							WHEN status = 'MC' THEN content_per
						END
					) AS MIDCONTENTPER,
					SUM(
						CASE
							WHEN status = 'LC' THEN content_per
						END
					) AS LARGECONTENTPER,
					SUM(
						CASE
							WHEN status = 'VLC' THEN content_per
						END
					) AS VLARGECONTENTPER,
					SUM((pe * content_per) / 100) AS EPSVALUE
				FROM
					TMP_FUND_PORTFOLIO FINALDATA
				GROUP BY
					FINALDATA.fund_code
			) Z
			INNER JOIN TmpComposition T ON T.fund_code = Z.fund_code
		GROUP BY
			Z.fund_code
	) FD
	INNER JOIN TmpComposition T ON T.fund_code = FD.fund_code
SET
	SUMEQSMALL = SUMEQSMALL + FD.SUMSCONT,
	SUMEQMID = SUMEQMID + FD.SUMMCONT,
	SUMEQLARGE = SUMEQLARGE + FD.SUMLCONT,
	SUMEQVLARGE = SUMEQVLARGE + FD.SUMVCONT,
	SUMEPS = SUMEPS + FD.EPSSUM;

SELECT
	F.fund_name,
	ROUND(T.SUMCASH, 2) AS cash,
	ROUND(T.SUMSOV, 2) AS sov,
	ROUND(T.SUMDEBT, 2) AS debt,
	ROUND(T.SUMEQSMALL, 2) AS eq_small,
	ROUND(T.SUMEQMID, 2) AS eq_mid,
	ROUND(T.SUMEQLARGE, 2) AS eq_large,
	ROUND(T.SUMEQVLARGE, 2) AS eq_very_large,
	ROUND(T.SUMEPS, 2) AS wt_pe,
	v_EntryMonth AS monthinfo,
	v_EntryYear AS yearinfo
FROM
	TmpComposition T
	INNER JOIN mpx_fund_master F ON T.fund_code = F.fund_code
ORDER BY
	F.fund_name;

END;

/ / DELIMITER;