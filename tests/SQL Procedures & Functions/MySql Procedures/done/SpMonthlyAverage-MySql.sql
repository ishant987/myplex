DELIMITER //

CREATE  PROCEDURE sp_monthly_average (
p_entry_date	VARCHAR(10),
p_type_id	INT)

BEGIN
    SELECT X.fund_name, X.fund_code, X.indices_name,
        CASE 
            WHEN (X.startvalue6 <> 0 AND closingvalue6 <> 0) THEN (((X.closingvalue6 - X.startvalue6)/ X.startvalue6)*100)
            WHEN X.startvalue6 = 0 THEN 0
            END AS "sixmonths",
        CASE 
            WHEN (X.startvalue1 <> 0 AND X.closingvalue1 <> 0) THEN (((X.closingvalue1 - X.startvalue1)/ X.startvalue1)*100)
            WHEN X.startvalue1 = 0 THEN 0
            END AS "oneyear",
        CASE 
            WHEN (X.startvalue2 <> 0 AND X.closingvalue2 <> 0) THEN ((POWER((X.closingvalue2/X.startvalue2),0.5) - 1) * 100)
            WHEN X.startvalue2 = 0 THEN 0
            END AS "twoyear",
        CASE 
            WHEN (X.startvalue3 <> 0 AND X.closingvalue3 <> 0) THEN  ((POWER((X.closingvalue3/X.startvalue3),0.33) - 1) * 100)
            WHEN X.startvalue3 = 0 THEN 0
            END AS "threeyear"
        FROM
        (SELECT Y.fund_name, Y.fund_code, Y.indices_name, 
            IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail
            WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
LIMIT 1),0) AS startvalue6,
        (SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -182, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103)  AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
LIMIT 1) AS closingvalue6,
            IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail 
            WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
LIMIT 1),0) AS startvalue1,
        (SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(YEAR, -1, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
LIMIT 1) AS closingvalue1,
            IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail 
            WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
LIMIT 1),0) AS startvalue2,
        (SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -730, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
LIMIT 1) AS closingvalue2,
            IFNULL((SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail 
            WHERE mpx_fund_detail.fund_code = Y.fund_code AND Y.fund_opened < TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103)) AND
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date
LIMIT 1),0) AS startvalue3,
        (SELECT mpx_fund_detail.closing_nav FROM mpx_fund_detail WHERE mpx_fund_detail.fund_code = Y.fund_code AND
            mpx_fund_detail.entry_date > TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103)) AND Y.fund_opened < TIMESTAMPADD(DAY, -1095, STR_TO_DATE(p_entry_date, 103)) AND  
            mpx_fund_detail.entry_date <= STR_TO_DATE(p_entry_date, 103) AND mpx_fund_detail.holiday = 0 ORDER BY mpx_fund_detail.entry_date DESC
LIMIT 1) AS closingvalue3
            FROM (SELECT fund_name, fund_code, indices_name, fund_opened FROM mpx_fund_master WHERE fund_opened < STR_TO_DATE(p_entry_date, 103) AND fund_type_id = p_type_id ) Y) X
            ORDER BY X.fund_name;
END;
//

DELIMITER ;