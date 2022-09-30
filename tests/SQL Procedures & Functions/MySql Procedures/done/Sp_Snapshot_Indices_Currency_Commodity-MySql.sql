DELIMITER $$
CREATE PROCEDURE `sp_snapshot_indices_currency_commodity`(IN `p_flag` VARCHAR(50), IN `p_entry_date` VARCHAR(10), IN `p_days` INT)
BEGIN
IF UPPER(p_flag)='GET_CURRENCY' THEN
		SELECT mpx_currency_master.cm_id, mpx_currency_master.name, Z.cur_value,
		CASE 
			WHEN Z.prev_value <= 0 THEN 0
			ELSE ((Z.cur_value - Z.prev_value)/Z.prev_value) * 100
		END AS "PER_CHANGE"
		FROM
			(SELECT X.cm_id, X.prev_value, Y.cur_value FROM 
				(SELECT entry_value AS prev_value, cm_id 
					FROM mpx_currency_detail 
					WHERE mpx_currency_detail.entry_date = TIMESTAMPADD(DAY, -p_days, p_entry_date)
				) as X
				INNER JOIN
				(SELECT entry_value AS cur_value, cm_id FROM mpx_currency_detail
				WHERE mpx_currency_detail.entry_date = TIMESTAMPADD(DAY, -1, p_entry_date)) as Y
				ON X.cm_id = Y.cm_id
			) as Z 
		INNER JOIN mpx_currency_master ON Z.cm_id = mpx_currency_master.cm_id
		WHERE mpx_currency_master.cm_id = 2 OR mpx_currency_master.cm_id = 3 OR mpx_currency_master.cm_id = 5 
		ORDER BY mpx_currency_master.name;
		
ELSEIF UPPER(p_flag)='GET_COMMODITY' THEN
		SELECT mpx_currency_master.cm_id,mpx_currency_master.name,Z.cur_value,
		CASE 
		WHEN Z.prev_value <= 0 THEN 0
		ELSE ((Z.cur_value - Z.prev_value)/Z.prev_value) * 100
		END AS "PER_CHANGE"
		FROM
			(SELECT X.cm_id, X.prev_value, Y.cur_value FROM 
				(SELECT entry_value AS prev_value, cm_id 
					FROM mpx_currency_detail
					WHERE mpx_currency_detail.entry_date = TIMESTAMPADD(DAY, -p_days, p_entry_date)
				) AS X
				INNER JOIN
				(SELECT entry_value AS cur_value, cm_id FROM mpx_currency_detail
					WHERE mpx_currency_detail.entry_date = TIMESTAMPADD(DAY, -1, p_entry_date)
				) AS Y
				ON X.cm_id = Y.cm_id
			) AS Z 
		INNER JOIN mpx_currency_master ON Z.cm_id = mpx_currency_master.cm_id
		WHERE mpx_currency_master.cm_id = 1 OR mpx_currency_master.cm_id = 4 OR  mpx_currency_master.cm_id = 7 
		ORDER BY mpx_currency_master.name;
		
ELSEIF UPPER(p_flag)='GET_INDICES' THEN
		DROP TABLE IF EXISTS TmpIndexTable;
		CREATE TEMPORARY TABLE TmpIndexTable(index_name	VARCHAR(200));
		INSERT INTO TmpIndexTable (index_name) VALUES ('S&P CNX Nifty Total Return Index');
		INSERT INTO TmpIndexTable (index_name) VALUES ('S&P CNX 500');
		INSERT INTO TmpIndexTable (index_name) VALUES ('BSE Sensex');
		INSERT INTO TmpIndexTable (index_name) VALUES ('BSE MidCap');
		INSERT INTO TmpIndexTable (index_name) VALUES ('S&P CNX Nifty Junior');
		INSERT INTO TmpIndexTable (index_name) VALUES ('BSE 200');
		SELECT Z.name,Z.cur_value,
		CASE 
			WHEN Z.prev_value <= 0 THEN 0
			ELSE ((Z.cur_value - Z.prev_value)/Z.prev_value) * 100
		END AS "PER_CHANGE"
		FROM
			(SELECT X.name, X.prev_value, Y.cur_value FROM 
				(SELECT closing_value AS prev_value, name FROM mpx_indices_detail
					WHERE mpx_indices_detail.entry_date = TIMESTAMPADD(DAY, -p_days, p_entry_date)
			) AS X
			INNER JOIN
			(SELECT closing_value AS cur_value, name FROM mpx_indices_detail
				WHERE mpx_indices_detail.entry_date = TIMESTAMPADD(DAY, -1, p_entry_date)
			) AS Y
			ON X.name = Y.name) AS Z 
		WHERE Z.name IN (SELECT index_name FROM TmpIndexTable)
		ORDER BY Z.name;

END IF;
END$$
DELIMITER ;