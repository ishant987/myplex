DELIMITER //

CREATE   PROCEDURE sp_monthly_corpus_change (
p_entry_date VARCHAR(10),
p_type_id INT)

BEGIN
	DECLARE v_prev_date	DATETIME(3);
	DECLARE v_cur_date	DATETIME(3);
	BEGIN
		SET v_prev_date = TIMESTAMPADD(DAY, -1, TIMESTAMPADD(MONTH, -1, TIMESTAMPADD(DAY, 1, STR_TO_DATE(p_entry_date, 103))));
		SET v_cur_date = STR_TO_DATE(p_entry_date, 103);
		SELECT mpx_fund_master.fund_name,mpx_fund_master.fund_code, final_data.current_value, final_data.diff_value, final_data.change_value FROM 
		(SELECT X.fund_code, Y.cur_value AS "current_value",
		CASE
			WHEN X.prev_value > 0 THEN ((Y.cur_value - X.prev_value) / X.prev_value)  * 100
		ELSE  0
		END AS "change_value"
		, 
		CASE
			WHEN X.prev_value > 0 THEN (Y.cur_value - X.prev_value) 
		ELSE  0
		END AS "diff_value"
		FROM
		(SELECT mpx_corpus_entry.corpus_entry AS prev_value, mpx_corpus_entry.fund_code FROM mpx_corpus_entry WHERE mpx_corpus_entry.entry_date = v_prev_date) X 
		INNER JOIN (SELECT mpx_corpus_entry.corpus_entry AS cur_value, mpx_corpus_entry.fund_code FROM mpx_corpus_entry WHERE mpx_corpus_entry.entry_date = v_cur_date) Y ON X.fund_code = Y.fund_code) final_data
		INNER JOIN mpx_fund_master ON final_data.fund_code = mpx_fund_master.fund_code
		WHERE (mpx_fund_master.fund_type_id = p_type_id )
		ORDER BY final_data.change_value DESC;
	END;
END;
//

DELIMITER ;