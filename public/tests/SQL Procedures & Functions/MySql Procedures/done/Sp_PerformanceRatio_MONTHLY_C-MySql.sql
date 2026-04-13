DELIMITER / / CREATE PROCEDURE sp_performance_ratio_monthly_c (
  p_start_date VARCHAR(10),
  p_end_date VARCHAR(10),
  p_fund_type_id INT,
  p_risk_free_return double
) BEGIN DECLARE NOT_FOUND INT DEFAULT 0;

DECLARE v_FundCode VARCHAR(50);

DECLARE CURSOR1 CURSOR FOR
SELECT
  m.fund_code AS FundCode
FROM
  mpx_fund_master m
where
  m.fund_type_id = p_fund_type_id
  and m.fund_opened <= STR_TO_DATE(p_start_date, 103);

DECLARE CONTINUE HANDLER FOR NOT FOUND
SET
  NOT_FOUND = 1;

CREATE TEMPORARY TABLE FINALRATIODATA (
  FUNDCODE VARCHAR(25),
  COVAR DOUBLE NULL,
  VARIANCE DOUBLE NULL,
  RETURNVALUEINDEX DOUBLE NULL,
  CAGRVALUE DOUBLE NULL,
  BETAVALUE DOUBLE NULL,
  JENSENVALUE DOUBLE NULL,
  SHARPEVALUE DOUBLE NULL,
  TRACKINGVALUE DOUBLE NULL,
  INFVALUE DOUBLE NULL,
  STDEVVALUE DOUBLE NULL,
  RSQUAREVALUE DOUBLE NULL,
  TREYNORVALUE DOUBLE NULL,
  SKEWVALUE DOUBLE NULL,
  KURTOSISVALUE DOUBLE NULL,
  COEFFVARVALUE DOUBLE NULL,
  RISKADJVALUE DOUBLE NULL
);

OPEN CURSOR1;

FETCH CURSOR1 INTO v_FundCode;

WHILE NOT_FOUND = 0 DO CALL sp_get_beta_mr(
  p_start_date,
  p_end_date,
  v_FundCode,
  p_risk_free_return
);

FETCH CURSOR1 INTO v_FundCode;

END WHILE;

CLOSE CURSOR1;

INSERT INTO
  mpx_monthly_ranking (
    fund_code,
    stdev_value,
    beta_value,
    jensen_value,
    start_date,
    end_date,
    fund_type_id
  )
SELECT
  FINALRATIODATA.FUNDCODE as FundCode,
  FINALRATIODATA.STDEVVALUE AS STDEVVALUE,
  FINALRATIODATA.BETAVALUE AS BETAVALUE,
  FINALRATIODATA.JENSENVALUE as JENSENVALUE,
  STR_TO_DATE(p_start_date, 103) AS STARTDATE,
  STR_TO_DATE(p_end_date, 103) AS ENDDATE,
  p_fund_type_id
FROM
  FINALRATIODATA
where
  beta_value is not null
  or stdev_value is not null
  or jensen_value is not null
order by
  FINALRATIODATA.FUNDCODE;

END;

/ / DELIMITER;