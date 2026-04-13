DELIMITER //

CREATE PROCEDURE sp_snapshot_change_val_new (
p_entry_date VARCHAR(10),
p_fund_type_id INT,
p_days INT)

BEGIN
	DECLARE v_cur_fund_type VARCHAR(100);
	DECLARE v_cur_median DOUBLE;

	BEGIN
		SELECT final_data.fund_code,k1.fund_name,final_data.change_value FROM
		(SELECT K.name,K.fund_type_id,K.fund_code,
		CASE 
		WHEN (Z.prev_value <= 0 OR Z.cur_value <= 0) THEN 0
		ELSE ((Z.cur_value - Z.prev_value)/Z.prev_value) * 100
		END AS "change_value"
		FROM
		(SELECT X.fund_code, X.prev_value, Y.cur_value FROM 
		(SELECT closing_nav AS prev_value, fund_code FROM mpx_fund_detail
		WHERE mpx_fund_detail.entry_date = TIMESTAMPADD(DAY, -@Days, STR_TO_DATE(p_entry_date, 103)))X
		INNER JOIN
		(SELECT closing_nav AS cur_value, fund_code FROM mpx_fund_detail
		WHERE mpx_fund_detail.entry_date = TIMESTAMPADD(DAY, -1, STR_TO_DATE(p_entry_date, 103)))Y
		ON X.fund_code = Y.fund_code)Z INNER JOIN 
		((SELECT mpx_fund_master.fund_code, mpx_fund_type.name,mpx_fund_type.ft_id  FROM mpx_fund_master 
		INNER JOIN mpx_fund_type ON mpx_fund_master.fund_type_id = mpx_fund_type.ft_id)) K ON Z.fund_code = K.fund_code) final_data,
		mpx_fund_master k1 WHERE final_data.fund_code=k1.fund_code AND final_data.fund_type_id=p_fund_type_id;
	END;
END;
//

DELIMITER ;