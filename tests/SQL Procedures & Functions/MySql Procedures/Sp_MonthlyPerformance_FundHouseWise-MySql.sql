DELIMITER / / CREATE PROCEDURE sp_monthly_performance_fund_house_wise (
	p_end_date VARCHAR(10),
	p_force_calculate VARCHAR(01)
) BEGIN DECLARE NOT_FOUND INT DEFAULT 0;

DECLARE v_CountAlreadyRowsPresent int;

DECLARE v_FundTypeID BIGINT;

DECLARE v_FundName VARCHAR(255);

DECLARE v_fund_code VARCHAR(50);

DECLARE v_TimeName VARCHAR(20);

DECLARE v_TimeSpan INT;

DECLARE v_DaysAdjust INT;

DECLARE v_StartDate VARCHAR(10);

DECLARE v_RiskFreeExecuted TINYINT;

DECLARE v_CountDated INT;

DECLARE csr_TimeIntervals CURSOR FOR
select
	TimeName,
	TimeSpan,
	DaysAdjust
from
	tmp_time_Intervals;

DECLARE csr_FundTypes CURSOR FOR
select
	name,
	ft_id
from
	mpx_fund_type
WHERE
	monthly_performance = 'Y';

DECLARE csr_funds CURSOR FOR
select
	fund_code,
	fund_name
from
	mpx_fund_master
where
	fund_type_id = v_FundTypeID
	and OpDate <= STR_TO_DATE(v_StartDate, 103);

DECLARE CONTINUE HANDLER FOR NOT FOUND
SET
	NOT_FOUND = 1;

select
	count(*) AS v_CountAlreadyRowsPresent
from
	mpx_monthly_fund_house_performance
where
	dated = STR_TO_DATE(p_end_date, 103);

IF (
	v_CountAlreadyRowsPresent = 0
	OR p_force_calculate = 'Y'
) THEN CREATE TEMPORARY TABLE temp_cov_data (
	FUNDCODE VARCHAR(25),
	FUNDNAME VARCHAR(255),
	COVAR DOUBLE NULL
);

CREATE TEMPORARY TABLE temp_risk_data (
	FUNDNAME VARCHAR(255),
	FUNDCODE VARCHAR(25),
	SIXMNTH DOUBLE NULL,
	ONEYR DOUBLE NULL,
	TWOYR DOUBLE NULL,
	THREEYR DOUBLE NULL
);

CREATE TEMPORARY TABLE final_ratio_data (
	FUNDCODE VARCHAR(25),
	COVAR DOUBLE NULL,
	VARIANCE DOUBLE NULL,
	MEANAVERAGE DOUBLE NULL,
	RETURNVALUENAV DOUBLE NULL,
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

CREATE TEMPORARY TABLE return_ratio_data (
	Classification varchar(255),
	TimeSpan varchar(20),
	fund_name varchar(255),
	FundHouse varchar(255),
	fund_code varchar(50),
	FundTypeId int,
	CAGRVALUE DOUBLE NULL,
	CAGRRank INT,
	RETLESSIDX DOUBLE NULL,
	RetLessIdxRank INT,
	JENSENVALUE DOUBLE NULL,
	JensenRank INT,
	BETAVALUE DOUBLE NULL,
	BetaRank INT,
	COVAR DOUBLE NULL,
	COVRank INT
);

SET
	v_RiskFreeExecuted = 0;

DROP TEMPORARY TABLE IF EXISTS tmp_time_Intervals;

CREATE TEMPORARY TABLE tmp_time_Intervals (
	TimeName varchar(20),
	TimeSpan int,
	DaysAdjust int
);

insert into
	tmp_time_Intervals
values
	('VARCHAR6M', 5, 0),
	('1 Y', 11, -1),
	('3 Y', 35, -1);

OPEN csr_TimeIntervals;

FETCH csr_TimeIntervals INTO v_TimeName,
v_TimeSpan,
v_DaysAdjust;

WHILE NOT_FOUND = 0 DO TRUNCATE TABLE temp_cov_data;

TRUNCATE TABLE final_ratio_data;

SET
	NOT_FOUND = 0;

OPEN csr_FundTypes;

FETCH csr_FundTypes INTO v_FundName,
v_FundTypeID;

WHILE NOT_FOUND = 0 DO
set
	v_StartDate = FORMAT(
		TIMESTAMPADD(
			DAY,
			v_DaysAdjust,
			TIMESTAMPADD(
				MONTH,
				TIMESTAMPDIFF(MONTH, 0, STR_TO_DATE(p_end_date, 103)) - v_TimeSpan,
				0
			)
		),
		'dd/MM/yyyy'
	);

SET
	NOT_FOUND = 0;

OPEN csr_funds;

FETCH csr_funds INTO v_fund_code,
v_FundName;

WHILE NOT_FOUND = 0 DO CALL sp_get_beta1(
	v_StartDate,
	p_end_date,
	v_fund_code,
	6.5
);

FETCH csr_funds INTO v_fund_code,
v_FundName;

END WHILE;

CLOSE csr_funds;

INSERT INTO
	temp_cov_data CALL sp_performance_ranking_classification(v_StartDate, v_EndDate, v_FundTypeID, 'COEFFVAR');

IF v_RiskFreeExecuted = 0 THEN
INSERT INTO
	temp_risk_data CALL sp_monthly_return_less_index(v_EndDate, v_FundTypeID);

FETCH csr_FundTypes INTO v_FundName,
v_FundTypeID;

END IF;

END WHILE;

CLOSE csr_FundTypes;

insert into
	return_ratio_data
select
	b.Classification,
	v_TimeName,
	b.fund_name,
	b.FundHouse,
	b.fund_code,
	b.FundTypeID,
	a.CAGRVALUE,
	RANK() OVER(
		PARTITION BY b.Classification
		ORDER BY
			a.CAGRVALUE DESC
	) CAGRRank,
	CASE
		WHEN v_TimeSpan = 5 then d.SIXMNTH
		WHEN v_TimeSpan = 11 then d.ONEYR
		WHEN v_TimeSpan = 35 then d.THREEYR
	END RETLESSIDX,
	RANK() OVER(
		PARTITION BY b.Classification
		ORDER BY
			d.SIXMNTH DESC
	) RetLessIdxRank,
	a.JENSENVALUE,
	RANK() OVER(
		PARTITION BY b.Classification
		ORDER BY
			a.JENSENVALUE DESC
	) JensenRank,
	a.BETAVALUE,
	RANK() OVER(
		PARTITION BY b.Classification
		ORDER BY
			a.BETAVALUE ASC
	) BetaRank,
	c.COVAR,
	RANK() OVER(
		PARTITION BY b.Classification
		ORDER BY
			c.COVAR ASC
	) COVRank
from
	final_ratio_data a
	inner join mpx_fund_master b on a.FUNDCODE = b.fund_code
	inner join temp_cov_data c on b.FUNDCODE = c.fund_code
	inner join temp_risk_data d on c.FUNDCODE = d.fund_code
order by
	b.fund_name;

SET
	v_RiskFreeExecuted = 1;

FETCH csr_TimeIntervals INTO v_TimeName,
v_TimeSpan,
v_DaysAdjust;

END WHILE;

SELECT
	count(*) INTO v_CountDated
from
	mpx_monthly_fund_house_performance
where
	dated = STR_TO_DATE(p_end_date, 103);

START TRANSACTION;

IF v_CountDated > 0 THEN
DELETE FROM
	mpx_monthly_fund_house_performance
where
	dated = STR_TO_DATE(p_end_date, 103);

END IF;

INSERT INTO
	mpx_monthly_fund_house_performance (
		dated,
		fund_type_id,
		timespan,
		fund_code,
		cagr,
		cagr_rank,
		ret_less_idx,
		ret_less_idx_rank,
		jensen,
		jensen_rank,
		beta,
		beta_rank,
		co_var,
		co_var_rank
	)
SELECT
	STR_TO_DATE(p_end_date, 103),
	FundTypeId,
	TimeSpan,
	fund_code,
	CAGRVALUE,
	CAGRRank,
	RETLESSIDX,
	RetLessIdxRank,
	JENSENVALUE,
	JensenRank,
	BETAVALUE,
	BetaRank,
	COVAR,
	COVRank
FROM
	return_ratio_data;

COMMIT;

END IF;

select
	tfm.Classification,
	v01.timespan,
	e.fundCount Population,
	tfm.fund_name,
	tfm.FundHouse,
	CAGR,
	CAGRRank,
	CAGRRankImprovement,
	RETLESSIDX,
	RetLessIdxRank,
	RetLessIdxRankImprovement,
	JENSEN,
	JensenRank,
	JensenRankImprovement,
	BETA,
	BetaRank,
	BetaRankImprovement,
	COVAR,
	COVarRank,
	COVarRankImprovement
from
	mpx_monthly_fund_house_performance v01
	inner join (
		select
			e1.FundTypeId,
			e1.timespan,
			count(*) as fundCount
		from
			mpx_monthly_fund_house_performance e1
		where
			e1.dated = STR_TO_DATE(p_end_date, 103)
		group by
			e1.FundTypeId,
			e1.timespan
	) as e on v01.fund_type_id = e.FundTypeId
	and v01.timespan = e.TimeSpan
	inner join mpx_fund_master tfm on v01.fund_code = tfm.fund_code
where
	v01.dated = STR_TO_DATE(p_end_date, 103)
order by
	tfm.fund_house,
	v01.timespan,
	tfm.classification,
	tfm.fund_name;

END;

/ / DELIMITER;