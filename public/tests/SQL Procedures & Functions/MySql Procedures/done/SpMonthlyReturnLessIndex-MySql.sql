DELIMITER //

CREATE   PROCEDURE sp_monthly_return_less_index ( 
p_entry_date	VARCHAR(10),
p_type_id	INT)

BEGIN
	CREATE TEMPORARY TABLE return_less_fund
	(
		fund_name		VARCHAR(255) null,
		fund_code		VARCHAR(255) null,
		indices_name		VARCHAR(100) null,
		days7			DOUBLE null,
		days14		DOUBLE null,
		days30		DOUBLE null,
		days60		DOUBLE null
	);

	CREATE TEMPORARY TABLE return_less_index
	(
		indices_name		VARCHAR(100) null,
		days7			DOUBLE null,
		days14		DOUBLE null,
		days30		DOUBLE null,
		days60		DOUBLE null
	);

	INSERT INTO return_less_fund (fund_name,fund_code, indices_name, days7, days14, days30, days60) 

	SELECT X.fund_name, X.fund_code, X.indices_name,
		CASE 
			WHEN X.start_value6 <> 0 THEN (((X.closing_value6 - X.start_value6)/ X.start_value6)*100)
			WHEN X.start_value6 = 0 THEN 0
			END AS "sixmonths",
		CASE 
			WHEN X.start_value1 <> 0 THEN (((X.closing_value1 - X.start_value1)/ X.start_value1)*100)
			WHEN X.start_value1 = 0 THEN 0
			END AS "oneyear",
		CASE 
			WHEN X.start_value2 <> 0 THEN ((POWER((X.closing_value2/X.start_value2),0.5)-1)*100)
			WHEN X.start_value2 = 0 THEN 0
			END AS "twoyear",
		CASE 
			WHEN X.start_value3 <> 0 THEN ((POWER((X.closing_value3/X.start_value3),0.33)-1)*100) 
			WHEN X.start_value3 = 0 THEN 0
			END AS "threeyear"	
		FROM
		(SELECT Y.fund_name, Y.fund_code, Y.indices_name, 
			IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail
			WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(Month, -6, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
			LIMIT 1),0) AS start_value6,
		(SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(Month, -6, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
		LIMIT 1) AS closing_value6,
			IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail 
			WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
		LIMIT 1),0) AS start_value1,
		(SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
		LIMIT 1) AS closing_value1,
			IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail 
			WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
		LIMIT 1),0) AS start_value2,
		(SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
		LIMIT 1) AS closing_value2,
			IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail 
			WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103)) AND
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
		LIMIT 1),0) AS start_value3,
		(SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND
			mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103)) AND Y.fund_opened < TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103)) AND  
			mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
		LIMIT 1) AS closing_value3
			FROM (SELECT fund_name, fund_code, indices_name, fund_opened FROM mpx_fund_master WHERE fund_opened < STR_TO_DATE(p_entry_date, 103) AND fund_type_id = p_type_id ) Y) X;

	INSERT INTO return_less_index (indices_name, days7, days14, days30, days60)

	SELECT X.indices_name, 
		CASE 
			WHEN X.starting6 <> 0 THEN ((X.closing6 - X.starting6) / X.starting6) * 100
			WHEN X.starting6 = 0 THEN 0
			END AS "avg6",
		CASE 
			WHEN X.starting1 <> 0 THEN ((X.closing1 - X.starting1) / X.starting1) * 100
			WHEN X.starting1 = 0 THEN 0
			END AS "avg1",
		CASE 
			WHEN X.starting2 <> 0 THEN ((POWER((X.closing2/X.starting2),0.5)-1)*100) 
			WHEN X.starting2 = 0 THEN 0
			END AS "avg2",
		CASE 
			WHEN X.starting3 <> 0 THEN ((POWER((X.closing3/X.starting3),0.33)-1)*100) 
			WHEN X.starting3 = 0 THEN 0
			END AS "avg3"
		FROM
		(SELECT Y.indices_name, 
		IFNULL((SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date
		LIMIT 1), 0) AS starting6,
		(SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(MONTH, -6, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date DESC
		LIMIT 1) AS closing6,
		IFNULL((SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date
		LIMIT 1), 0) AS starting1,
		(SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date DESC
		LIMIT 1) AS closing1,
		IFNULL((SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date
		LIMIT 1), 0) AS starting2,
		(SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(YEAR, -2, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date DESC
		LIMIT 1) AS closing2,
		IFNULL((SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date
		LIMIT 1), 0) AS starting3,
		(SELECT mpx_indices_detail.closing_value FROM mpx_indices_detail WHERE 
		mpx_indices_detail.indices_name = Y.indices_name AND Y.fund_opened < TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103))  AND
		mpx_indices_detail.entry_date > TIMESTAMPADD(YEAR, -3, STR_TO_DATE(p_entry_date, 103)) AND 
		mpx_indices_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_indices_detail.holiday = 0 ORDER BY mpx_indices_detail.entry_date DESC
		LIMIT 1) AS closing3
		FROM (SELECT DISTINCT mpx_indices_detail.indices_name, MIN(mpx_indices_detail.entry_date) AS fund_opened FROM mpx_indices_detail INNER JOIN 
			mpx_fund_master ON mpx_indices_detail.indices_name = mpx_fund_master.indices_name
			WHERE mpx_indices_detail.entry_date < STR_TO_DATE(p_entry_date, 103) 
			AND mpx_fund_master.fund_type_id = p_type_id GROUP BY mpx_indices_detail.indices_name) Y) X;

		SELECT return_less_fund.fund_name, return_less_fund.fund_code,
		CASE 
			WHEN return_less_fund.days7 <> 0 AND return_less_index.days7 <> 0 THEN return_less_fund.days7 - return_less_index.days7
			WHEN return_less_fund.days7 = 0 OR return_less_index.days7 = 0 THEN 0
			END AS "VALUES6",
		CASE 
			WHEN return_less_fund.days14 <> 0 AND return_less_index.days14 <> 0 THEN return_less_fund.days14 - return_less_index.days14
			WHEN return_less_fund.days14 = 0 OR return_less_index.days14 = 0 THEN 0
			END AS "VALUES1",
		CASE 
			WHEN return_less_fund.days30 <> 0 AND return_less_index.days30 <> 0 THEN return_less_fund.days30 - return_less_index.days30
			WHEN return_less_fund.days30 = 0 OR return_less_index.days30 = 0 THEN 0
			END AS "VALUES2",
		CASE 
			WHEN return_less_fund.days60 <> 0 AND return_less_index.days60 <> 0 THEN return_less_fund.days60 - return_less_index.days60
			WHEN return_less_fund.days60 = 0 OR return_less_index.days60 = 0 THEN 0
			END AS "VALUES3"
		FROM return_less_fund INNER JOIN return_less_index ON return_less_fund.indices_name = return_less_index.indices_name ORDER BY return_less_fund.fund_name;
END;
//

DELIMITER ;