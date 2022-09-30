DELIMITER $$
CREATE PROCEDURE `sp_snapshot_weekly_fund`(IN `p_entry_date` VARCHAR(10))
BEGIN
	SELECT final_data.fund_name, final_data.name, final_data.weekly_change 
	FROM (SELECT mpx_fund_master.fund_name, mpx_fund_type.name, 
	CASE 
	WHEN Z.prev_value <= 0 THEN 0
	ELSE ((Z.cur_value - Z.prev_value)/Z.prev_value) * 100
	END AS "weekly_change"
	FROM
	(SELECT X.fund_code, X.prev_value, Y.cur_value FROM 
	(SELECT closing_nav AS prev_value, fund_code FROM mpx_fund_detail
	WHERE mpx_fund_detail.entry_date = TIMESTAMPADD(DAY, -7, p_entry_date))X
	INNER JOIN
	(SELECT closing_nav AS cur_value, fund_code FROM mpx_fund_detail
	WHERE mpx_fund_detail.entry_date = TIMESTAMPADD(DAY, -1, p_entry_date))Y
	ON X.fund_code = Y.fund_code)Z INNER JOIN mpx_fund_master ON Z.fund_code = mpx_fund_master.fund_code INNER JOIN mpx_fund_type ON mpx_fund_master.fund_type_id = mpx_fund_type.ft_id) final_data ORDER BY final_data.weekly_change DESC
	LIMIT 10;
END$$
DELIMITER ;