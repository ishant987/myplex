DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_monthly_ranking`(IN `p_start_date` DATE, IN `p_end_date` DATE, IN `p_start_date_p1` DATE, IN `p_end_date_p1` DATE, IN `p_start_date_p2` DATE, IN `p_end_date_p2` DATE, IN `p_start_date_p3` DATE, IN `p_end_date_p3` DATE, IN `p_start_date_p4` DATE, IN `p_end_date_p4` DATE, IN `p_fund_type_id` INT)
BEGIN

	DECLARE NOT_FOUND INT DEFAULT 0;
	DECLARE v_CurFundCode VARCHAR(100) DEFAULT NULL;
	DECLARE v_CurVolatality DOUBLE  DEFAULT 0;
	DECLARE v_CurBeta DOUBLE  DEFAULT 0;
	DECLARE v_CurJensensAlpha DOUBLE  DEFAULT 0;
	DECLARE RATIO_CURSOR CURSOR FOR SELECT FUNDCODE FROM TmpRatioData GROUP BY FUNDCODE;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET NOT_FOUND = 1;



    DROP TABLE IF EXISTS TmpRatioData;
DROP TABLE IF EXISTS Tmp_STDDEV;
DROP TABLE IF EXISTS tmp_monthly_ratio_data;


CREATE TEMPORARY TABLE tmp_monthly_ratio_data 
(
	start_date DATE,
	end_date DATE,
	fund_code VARCHAR(25),
	per_change_aaum FLOAT NULL,
	aaum FLOAT NULL,
	one_year_return FLOAT NULL,
	p1_volatality FLOAT NULL,
	p2_volatality FLOAT NULL,
	p3_volatality FLOAT NULL,
	p4_volatality FLOAT NULL,
	p1_beta FLOAT NULL,
	p2_beta FLOAT NULL,
	p3_beta FLOAT NULL,
	p4_beta FLOAT NULL,
	p1_jensen_alpha FLOAT NULL,
	p2_jensen_alpha FLOAT NULL,
	p3_jensen_alpha FLOAT NULL,
	p4_jensen_alpha FLOAT NULL
);


CREATE TEMPORARY TABLE TmpRatioData 
		(
			ENTRYDATE		DATETIME,
			FUNDCODE		VARCHAR(25),
			INDICES		VARCHAR(100),
			INDICESCLOSING	FLOAT,
			INDICESPER		FLOAT,
			FUNDCLOSING		FLOAT,
			FUNDPER		FLOAT,
			INCEPTIONDATE	DATETIME,
			RISKFREERETURN	FLOAT,
			FUNDTERM		FLOAT

		);
CREATE TEMPORARY TABLE Tmp_STDDEV
			(
				FUNDCODE			VARCHAR(25),				
				VOLATILITY			FLOAT NULL
				);
INSERT INTO TmpRatioData (ENTRYDATE, FUNDCODE, INDICES, 
			INDICESCLOSING, INDICESPER, FUNDCLOSING, FUNDPER, INCEPTIONDATE, RISKFREERETURN, FUNDTERM)					
SELECT FUNDTABLE.entry_date AS ENTRYDATE, FUNDTABLE.fund_code AS FUNDCODE, mpx_indices_detail.name AS INDICES, mpx_indices_detail.closing_value AS INDICESCLOSING,
		mpx_indices_detail.percentage_change AS INDICESPER, FUNDTABLE.FUNDCLOSING, FUNDTABLE.FUNDPER,
		FUNDTABLE.INCEPTIONDATE, FUNDTABLE.risk_free_return AS RISKFREERETURN,
		CAST(TIMESTAMPDIFF(DAY, FUNDTABLE.INCEPTIONDATE, p_end_date) AS DECIMAL(10,5))/365  AS FUNDTERM 

		FROM mpx_indices_detail INNER JOIN 

		(SELECT mpx_fund_detail.entry_date, mpx_fund_detail.fund_code, X.name, mpx_fund_detail.closing_nav AS FUNDCLOSING, 
		 mpx_fund_detail.percentage_change AS FUNDPER,  X.INCEPTIONDATE, X.risk_free_return FROM
		mpx_fund_detail INNER JOIN  
		(SELECT FISOURCE.fund_code, FISOURCE.name, FISOURCE.risk_free_return, 
	 CASE
		 WHEN FISOURCE.FUNDOPENING <= FISOURCE.INDICESOPENING THEN FISOURCE.INDICESOPENING
		 WHEN FISOURCE.FUNDOPENING > FISOURCE.INDICESOPENING THEN FISOURCE.FUNDOPENING
		 END AS INCEPTIONDATE,
		 CASE
		 WHEN FISOURCE.FUNDOPENING <= FISOURCE.INDICESOPENING THEN TIMESTAMPDIFF(DAY, FISOURCE.FUNDOPENING, p_end_date)
		 WHEN FISOURCE.FUNDOPENING > FISOURCE.INDICESOPENING THEN TIMESTAMPDIFF(DAY, FISOURCE.INDICESOPENING, p_end_date)
		 END AS TERM
		FROM

		(SELECT FMASTER.fund_code, IMASTER.name,FMASTER.risk_free_return,
CASE 
WHEN FMASTER.FUNDOPDATE <= p_start_date THEN p_start_date
WHEN FMASTER.FUNDOPDATE >= p_start_date THEN FMASTER.FUNDOPDATE
END AS 'FUNDOPENING',
CASE
WHEN IMASTER.INDICESOPDATE <= p_start_date THEN p_start_date
WHEN IMASTER.INDICESOPDATE >= p_start_date THEN IMASTER.INDICESOPDATE
END AS 'INDICESOPENING'
FROM
(SELECT fund_code,indices_name, risk_free_return, fund_opened AS FUNDOPDATE FROM mpx_fund_master 
		WHERE fund_type_id=p_fund_type_id AND fund_opened <= p_start_date) FMASTER 
		INNER JOIN 
(SELECT name, MIN(entry_date) AS INDICESOPDATE FROM mpx_indices_detail GROUP BY name) IMASTER
		ON FMASTER.indices_name = IMASTER.name) FISOURCE)X

		ON mpx_fund_detail.fund_code = X.fund_code WHERE mpx_fund_detail.entry_date >= X.INCEPTIONDATE 
		 AND mpx_fund_detail.entry_date <= p_end_date AND mpx_fund_detail.holiday = 0)FUNDTABLE
		ON mpx_indices_detail.name = FUNDTABLE.name AND mpx_indices_detail.entry_date = FUNDTABLE.entry_date
		 WHERE mpx_indices_detail.entry_date >= FUNDTABLE.INCEPTIONDATE AND mpx_indices_detail.entry_date <= p_end_date  AND 
		 mpx_indices_detail.holiday = 0;

INSERT INTO Tmp_STDDEV (FUNDCODE, VOLATILITY)
SELECT RETURNDATA.FUNDCODE, STDDEV(RETURNDATA.DAILYEXCESS) AS VOLATILITY
FROM
(SELECT FUNDCODE, FUNDCLOSING AS DAILYEXCESS FROM TmpRatioData) RETURNDATA GROUP BY RETURNDATA.FUNDCODE;



INSERT INTO tmp_monthly_ratio_data(
	start_date,
	end_date,
	fund_code
)
SELECT p_start_date,p_end_date,FUNDCODE  AS fund_code
FROM TmpRatioData GROUP BY TmpRatioData.FUNDCODE;

OPEN RATIO_CURSOR;
FETCH RATIO_CURSOR INTO v_CurFundCode;
WHILE NOT_FOUND = 0
DO
SET @volp1 = (SELECT STDDEV(RETURNDATA.DAILYEXCESS) AS p1_volatality
FROM
(SELECT FUNDCODE, FUNDCLOSING AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
UPDATE tmp_monthly_ratio_data SET p1_volatality = @volp1 WHERE fund_code = v_CurFundCode;

SET @volp2 = (SELECT STDDEV(RETURNDATA.DAILYEXCESS) AS p2_volatality
FROM
(SELECT FUNDCODE, FUNDCLOSING AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
UPDATE tmp_monthly_ratio_data SET p2_volatality = @volp2 WHERE fund_code = v_CurFundCode;

SET @volp3 = (SELECT STDDEV(RETURNDATA.DAILYEXCESS) AS p3_volatality
FROM
(SELECT FUNDCODE, FUNDCLOSING AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
UPDATE tmp_monthly_ratio_data SET p3_volatality = @volp3 WHERE fund_code = v_CurFundCode;

SET @volp4 = (SELECT STDDEV(RETURNDATA.DAILYEXCESS) AS p4_volatality
FROM
(SELECT FUNDCODE, FUNDCLOSING AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
UPDATE tmp_monthly_ratio_data SET p4_volatality = @volp4 WHERE fund_code = v_CurFundCode;

SET @corelp1 = (SELECT (count(*) * sum(FUNDCLOSING * INDICESCLOSING) - sum(FUNDCLOSING) * sum(INDICESCLOSING)) / (sqrt(count(*) * sum(FUNDCLOSING * FUNDCLOSING) - sum(FUNDCLOSING) * sum(FUNDCLOSING)) * sqrt(count(*) * sum(INDICESCLOSING * INDICESCLOSING) - sum(INDICESCLOSING) * sum(INDICESCLOSING))) AS correlation_coefficient_sample FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode);
SET @corelp2 = (SELECT (count(*) * sum(FUNDCLOSING * INDICESCLOSING) - sum(FUNDCLOSING) * sum(INDICESCLOSING)) / (sqrt(count(*) * sum(FUNDCLOSING * FUNDCLOSING) - sum(FUNDCLOSING) * sum(FUNDCLOSING)) * sqrt(count(*) * sum(INDICESCLOSING * INDICESCLOSING) - sum(INDICESCLOSING) * sum(INDICESCLOSING))) AS correlation_coefficient_sample FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode);
SET @corelp3 = (SELECT (count(*) * sum(FUNDCLOSING * INDICESCLOSING) - sum(FUNDCLOSING) * sum(INDICESCLOSING)) / (sqrt(count(*) * sum(FUNDCLOSING * FUNDCLOSING) - sum(FUNDCLOSING) * sum(FUNDCLOSING)) * sqrt(count(*) * sum(INDICESCLOSING * INDICESCLOSING) - sum(INDICESCLOSING) * sum(INDICESCLOSING))) AS correlation_coefficient_sample FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode);
SET @corelp4 = (SELECT (count(*) * sum(FUNDCLOSING * INDICESCLOSING) - sum(FUNDCLOSING) * sum(INDICESCLOSING)) / (sqrt(count(*) * sum(FUNDCLOSING * FUNDCLOSING) - sum(FUNDCLOSING) * sum(FUNDCLOSING)) * sqrt(count(*) * sum(INDICESCLOSING * INDICESCLOSING) - sum(INDICESCLOSING) * sum(INDICESCLOSING))) AS correlation_coefficient_sample FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode);

SET @sdfp1 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, FUNDPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
SET @sdfp2 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, FUNDPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
SET @sdfp3 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, FUNDPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
SET @sdfp4 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, FUNDPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);


SET @sdip1 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, INDICESPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
SET @sdip2 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, INDICESPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
SET @sdip3 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, INDICESPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);
SET @sdip4 =  (SELECT STDDEV(RETURNDATA.DAILYEXCESS)
FROM
(SELECT FUNDCODE, INDICESPER AS DAILYEXCESS FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode) RETURNDATA GROUP BY RETURNDATA.FUNDCODE);


SET @betap1 = @corelp1 * (@sdfp1 / @sdip1);
SET @betap2 = @corelp2 * (@sdfp2 / @sdip2);
SET @betap3 = @corelp3 * (@sdfp3 / @sdip3);
SET @betap4 = @corelp4 * (@sdfp4 / @sdip4);

UPDATE tmp_monthly_ratio_data 
SET 
p1_beta = @betap1,
p2_beta = @betap2,
p3_beta = @betap3,
p4_beta = @betap4 
WHERE fund_code = v_CurFundCode;


SET @rf = (SELECT (RISKFREERETURN / 2) AS rf_value FROM TmpRatioData WHERE FUNDCODE = v_CurFundCode LIMIT 1);

SET @rpp1 = (SELECT final_data.fund_change FROM
		(SELECT
		CASE 
		WHEN (Z.fund_start_value <= 0 OR Z.fund_end_value <= 0) THEN 0
		ELSE ((Z.fund_end_value - Z.fund_start_value)/Z.fund_start_value) * 100
		END AS "fund_change"
		FROM
		(SELECT X.FUNDCODE, X.fund_start_value, Y.fund_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);
SET @rmp1 = (SELECT final_data.index_change FROM
		(SELECT
		CASE 
		WHEN (Z.index_start_value <= 0 OR Z.index_end_value <= 0) THEN 0
		ELSE ((Z.index_end_value - Z.index_start_value)/Z.index_start_value) * 100
		END AS "index_change"
		FROM
		(SELECT X.FUNDCODE, X.index_start_value, Y.index_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p1 AND ENTRYDATE <= p_end_date_p1 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);
		
SET @rpp2 = (SELECT final_data.fund_change FROM
		(SELECT
		CASE 
		WHEN (Z.fund_start_value <= 0 OR Z.fund_end_value <= 0) THEN 0
		ELSE ((Z.fund_end_value - Z.fund_start_value)/Z.fund_start_value) * 100
		END AS "fund_change"
		FROM
		(SELECT X.FUNDCODE, X.fund_start_value, Y.fund_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);
SET @rmp2 = (SELECT final_data.index_change FROM
		(SELECT
		CASE 
		WHEN (Z.index_start_value <= 0 OR Z.index_end_value <= 0) THEN 0
		ELSE ((Z.index_end_value - Z.index_start_value)/Z.index_start_value) * 100
		END AS "index_change"
		FROM
		(SELECT X.FUNDCODE, X.index_start_value, Y.index_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p2 AND ENTRYDATE <= p_end_date_p2 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);
		
SET @rpp3 = (SELECT final_data.fund_change FROM
		(SELECT
		CASE 
		WHEN (Z.fund_start_value <= 0 OR Z.fund_end_value <= 0) THEN 0
		ELSE ((Z.fund_end_value - Z.fund_start_value)/Z.fund_start_value) * 100
		END AS "fund_change"
		FROM
		(SELECT X.FUNDCODE, X.fund_start_value, Y.fund_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);
SET @rmp3 = (SELECT final_data.index_change FROM
		(SELECT
		CASE 
		WHEN (Z.index_start_value <= 0 OR Z.index_end_value <= 0) THEN 0
		ELSE ((Z.index_end_value - Z.index_start_value)/Z.index_start_value) * 100
		END AS "index_change"
		FROM
		(SELECT X.FUNDCODE, X.index_start_value, Y.index_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p3 AND ENTRYDATE <= p_end_date_p3 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);
		
SET @rpp4 = (SELECT final_data.fund_change FROM
		(SELECT
		CASE 
		WHEN (Z.fund_start_value <= 0 OR Z.fund_end_value <= 0) THEN 0
		ELSE ((Z.fund_end_value - Z.fund_start_value)/Z.fund_start_value) * 100
		END AS "fund_change"
		FROM
		(SELECT X.FUNDCODE, X.fund_start_value, Y.fund_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);
SET @rmp4 = (SELECT final_data.index_change FROM
		(SELECT
		CASE 
		WHEN (Z.index_start_value <= 0 OR Z.index_end_value <= 0) THEN 0
		ELSE ((Z.index_end_value - Z.index_start_value)/Z.index_start_value) * 100
		END AS "index_change"
		FROM
		(SELECT X.FUNDCODE, X.index_start_value, Y.index_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE ASC LIMIT 1)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE, INDICESCLOSING AS index_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date_p4 AND ENTRYDATE <= p_end_date_p4 AND FUNDCODE = v_CurFundCode ORDER BY ENTRYDATE DESC LIMIT 1)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data);


SET @jap1 = 
((@rpp1 - @rf) - (@betap1*(@rmp1 - @rf)));
SET @jap2 = ((@rpp2 - @rf) - (@betap2*(@rmp2 - @rf)));
SET @jap3 = ((@rpp3 - @rf) - (@betap3*(@rmp3 - @rf)));
SET @jap4 = ((@rpp4 - @rf) - (@betap1*(@rmp4 - @rf)));


UPDATE tmp_monthly_ratio_data SET 
p1_jensen_alpha = @jap1,
p2_jensen_alpha = @jap2,
p3_jensen_alpha = @jap3,
p4_jensen_alpha = @jap4 
WHERE fund_code = v_CurFundCode;


FETCH RATIO_CURSOR INTO v_CurFundCode;

END WHILE;

CLOSE RATIO_CURSOR;


UPDATE tmp_monthly_ratio_data 
INNER JOIN (SELECT mpx_corpus_entry.fund_code, mpx_corpus_entry.corpus_entry, mpx_corpus_entry.entry_date FROM mpx_corpus_entry WHERE mpx_corpus_entry.entry_date = p_end_date  GROUP BY fund_code) t2 ON tmp_monthly_ratio_data.fund_code = t2.fund_code
SET aaum = t2.corpus_entry;


UPDATE tmp_monthly_ratio_data
INNER JOIN
(SELECT final_data.per_change,final_data.fund_code FROM
		(SELECT
		CASE 
		WHEN (Z.aaum_start_value <= 0 OR Z.aaum_end_value <= 0) THEN 0
		ELSE ((Z.aaum_end_value - Z.aaum_start_value)/Z.aaum_start_value) * 100
		END AS "per_change",
		Z.fund_code
		FROM
		(SELECT X.fund_code, X.aaum_start_value, Y.aaum_end_value FROM 
		(SELECT mpx_corpus_entry.fund_code, mpx_corpus_entry.corpus_entry as aaum_start_value, mpx_corpus_entry.entry_date FROM mpx_corpus_entry WHERE MONTH(mpx_corpus_entry.entry_date) = MONTH(p_start_date) AND YEAR(mpx_corpus_entry.entry_date) = YEAR(p_start_date)  GROUP BY fund_code)X
		INNER JOIN
		(SELECT mpx_corpus_entry.fund_code, mpx_corpus_entry.corpus_entry as aaum_end_value, mpx_corpus_entry.entry_date FROM mpx_corpus_entry WHERE mpx_corpus_entry.entry_date = p_end_date  GROUP BY fund_code)Y
		ON X.fund_code = Y.fund_code)Z) final_data) t2 ON tmp_monthly_ratio_data.fund_code = t2.fund_code
SET per_change_aaum = t2.per_change;

UPDATE tmp_monthly_ratio_data
INNER JOIN
(SELECT final_data.fund_change,final_data.fund_code FROM
		(SELECT
		CASE 
		WHEN (Z.fund_start_value <= 0 OR Z.fund_end_value <= 0) THEN 0
		ELSE ((Z.fund_end_value - Z.fund_start_value)/Z.fund_start_value) * 100
		END AS "fund_change",
		Z.FUNDCODE AS fund_code
		FROM
		(SELECT X.FUNDCODE, X.fund_start_value, Y.fund_end_value FROM 
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_start_value FROM TmpRatioData WHERE ENTRYDATE >= p_start_date AND ENTRYDATE <= p_start_date GROUP BY FUNDCODE)X
		INNER JOIN
		(SELECT ENTRYDATE, FUNDCODE,  FUNDCLOSING AS fund_end_value FROM TmpRatioData WHERE ENTRYDATE >= p_end_date AND ENTRYDATE <= p_end_date GROUP BY FUNDCODE)Y
		ON X.FUNDCODE = Y.FUNDCODE)Z) final_data) t2 ON tmp_monthly_ratio_data.fund_code = t2.fund_code
SET one_year_return = t2.fund_change;



INSERT INTO mpx_monthly_ratio_calculations
SELECT p_start_date AS start_date,
	p_end_date AS end_date,
	t1.fund_code,
	t1.fund_name,
	t2.per_change_aaum,
	t2.aaum,
	t2.one_year_return,
	t2.p1_volatality,
	t2.p2_volatality,
	t2.p3_volatality,
	t2.p4_volatality,
	t2.p1_beta,
	t2.p2_beta,
	t2.p3_beta,
	t2.p4_beta,
	t2.p1_jensen_alpha,
	t2.p2_jensen_alpha,
	t2.p3_jensen_alpha,
	t2.p4_jensen_alpha FROM 
(SELECT fund_code,fund_name FROM mpx_fund_master 
WHERE fund_type_id = p_fund_type_id) t1 
LEFT JOIN 
(SELECT * FROM tmp_monthly_ratio_data) t2
ON t1.fund_code = t2.fund_code; 

SELECT * FROM mpx_monthly_ratio_calculations;

END$$
DELIMITER ;