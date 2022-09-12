DELIMITER //

CREATE      PROCEDURE sp_monthly_indices (
p_entry_date		VARCHAR(10),
p_type_id		INT)

BEGIN
    SELECT Z.indices_name, Z.avg6, Z.avg1, Z.avg2, Z.avg3 FROM
    (SELECT X.indices_name, 
    CASE 
            WHEN X.starting6 <> 0 THEN ((X.closing6 - X.starting6) / X.starting6) * 100
            WHEN X.starting6 = 0 THEN 0
            END AS "avg6",
    CASE 
            WHEN X.starting1 <> 0 THEN ((X.closing1 - X.starting1) / X.starting1) * 100
            WHEN X.starting1 = 0 THEN 0
            END AS "avg1",		
    CASE 
            WHEN X.starting2 <> 0 THEN ((POWER((X.closing2/X.starting2),0.5) -1) * 100)
            WHEN X.starting2 = 0 THEN 0
            END AS "avg2",
    CASE 
            WHEN X.starting3 <> 0 THEN ((POWER((X.closing3/X.starting3),0.33) -1) * 100)
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
            AND mpx_fund_master.fund_type_id = p_type_id GROUP BY mpx_indices_detail.indices_name) Y) X)Z
        ORDER BY Z.avg6 DESC;
END;
//

DELIMITER ;