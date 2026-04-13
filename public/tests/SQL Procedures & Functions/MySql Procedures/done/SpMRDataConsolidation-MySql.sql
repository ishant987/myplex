DELIMITER / / CREATE PROCEDURE sp_mr_data_consolidation (p_risk_free_return double) BEGIN DECLARE NOT_FOUND INT DEFAULT 0;

DECLARE v_opDate1 varchar(10);

DECLARE v_opDate2 varchar(10);

DECLARE v_opDate3 varchar(10);

DECLARE v_opDate4 varchar(10);

DECLARE v_opDate1_end varchar(10);

DECLARE v_opDate2_end varchar(10);

DECLARE v_opDate3_end varchar(10);

DECLARE v_opDate4_end varchar(10);

DECLARE v_stdate date;

DECLARE v_endate date;

DECLARE v_FundTypeID int;

DECLARE CURSOR11 CURSOR FOR
SELECT
  c.ft_id
FROM
  mpx_fund_type c;

DECLARE CURSOR2 CURSOR FOR
SELECT
  c1.ft_id
FROM
  mpx_fund_type c1;

DECLARE CONTINUE HANDLER FOR NOT FOUND
SET
  NOT_FOUND = 1;

TRUNCATE TABLE mpx_monthly_ranking;

TRUNCATE TABLE mpx_monthly_ranking_aaum;

TRUNCATE TABLE mpx_fund_detail_mr;

TRUNCATE TABLE mpx_indices_detail_mr;

SET
  v_opDate1 =(
    SELECT
      DATE_FORMAT(date1_start, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_opDate1_end =(
    SELECT
      DATE_FORMAT(date1_end, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_opDate2 =(
    SELECT
      DATE_FORMAT(date2_start, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_opDate2_end =(
    SELECT
      DATE_FORMAT(date2_end, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_opDate3 =(
    SELECT
      DATE_FORMAT(date3_start, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_opDate3_end =(
    SELECT
      DATE_FORMAT(date3_end, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_opDate4 =(
    SELECT
      DATE_FORMAT(date4_start, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_opDate4_end =(
    SELECT
      DATE_FORMAT(date4_end, '%d/%m/%Y')
    from
      mpx_monthly_ranking_dates
  );

SET
  v_stdate =(
    SELECT
      date4_start
    from
      mpx_monthly_ranking_dates
  );

SET
  v_endate =(
    SELECT
      date1_end
    from
      mpx_monthly_ranking_dates
  );

INSERT INTO
  mpx_fund_detail_mr
SELECT
  *
FROM
  mpx_fund_detail
WHERE
  entry_date >= v_stdate
  and entry_date <= v_endate;

INSERT INTO
  mpx_indices_detail_mr
SELECT
  *
FROM
  mpx_indices_detail
WHERE
  entry_date >= v_stdate
  and entry_date <= v_endate;

OPEN CURSOR11;

FETCH CURSOR11 INTO v_FundTypeID;

WHILE NOT_FOUND = 0 DO CALL sp_performance_ratio_monthly_c(
  v_opDate1,
  v_opDate1_end,
  v_FundTypeID,
  p_risk_free_return
);

CALL sp_performance_ratio_monthly_c (
  v_opDate2,
  v_opDate2_end,
  v_FundTypeID,
  p_risk_free_return
);

CALL sp_performance_ratio_monthly_c (
  v_opDate3,
  v_opDate3_end,
  v_FundTypeID,
  p_risk_free_return
);

CALL sp_performance_ratio_monthly_c (
  v_opDate4,
  v_opDate4_end,
  v_FundTypeID,
  p_risk_free_return
);

FETCH CURSOR11 INTO v_FundTypeID;

END WHILE;

CLOSE CURSOR11;

SET
  NOT_FOUND = 0;

OPEN CURSOR2;

FETCH CURSOR2 INTO v_FundTypeID;

WHILE NOT_FOUND = 0 DO CALL sp_monthly_ranking_aaum (v_opDate1_end, v_FundTypeID);

FETCH CURSOR2 INTO v_FundTypeID;

END WHILE;

CLOSE CURSOR2;

END;

/ / DELIMITER;