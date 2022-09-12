DELIMITER $$
CREATE PROCEDURE `sp_snapshot_weekly_benchmark`(IN `p_entry_date` VARCHAR(10))
BEGIN
	DECLARE NOT_FOUND INT DEFAULT 0;
	DECLARE v_CurFundType VARCHAR(100);
	DECLARE v_CurMedian	DOUBLE;
	DECLARE FUND_CURSOR CURSOR FOR SELECT FUNDTYPE FROM fund_temp GROUP BY FUNDTYPE;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET NOT_FOUND = 1;

	BEGIN
	DROP TABLE IF EXISTS fund_temp;
		CREATE TEMPORARY TABLE fund_temp (
			FUNDTYPE VARCHAR(100),
			CHANGEVAL DOUBLE,
			FundTypeID INT
		);

		DROP TABLE IF EXISTS Newfund_temp;
		CREATE TEMPORARY TABLE Newfund_temp (
			FUNDTYPE VARCHAR(100),
			MEANVAL	DOUBLE,
			MEDIANVAL DOUBLE,
			FundTypeID INT
		);
		
		INSERT INTO fund_temp (FUNDTYPE, CHANGEVAL,FundTypeID) 
		SELECT final_data.name, final_data.weekly_change,final_data.ft_id FROM
		(SELECT K.name,K.ft_id,
		CASE 
		WHEN (Z.prev_value <= 0 OR Z.cur_value <= 0) THEN 0
		ELSE ((Z.cur_value - Z.prev_value)/Z.prev_value) * 100
		END AS "weekly_change"
		FROM
		(SELECT X.fund_code, X.prev_value, Y.cur_value FROM 
		(SELECT closing_nav AS prev_value, fund_code FROM mpx_fund_detail
		WHERE mpx_fund_detail.entry_date = TIMESTAMPADD(DAY, -7, p_entry_date))X
		INNER JOIN
		(SELECT closing_nav AS cur_value, fund_code FROM mpx_fund_detail
		WHERE mpx_fund_detail.entry_date = TIMESTAMPADD(DAY, -1, p_entry_date))Y
		ON X.fund_code = Y.fund_code)Z INNER JOIN 
		((SELECT mpx_fund_master.fund_code, mpx_fund_type.name,mpx_fund_type.ft_id FROM mpx_fund_master 
		INNER JOIN mpx_fund_type ON mpx_fund_master.fund_type_id = mpx_fund_type.ft_id)) K ON Z.fund_code = K.fund_code) final_data;
		INSERT INTO Newfund_temp SELECT FUNDTYPE, AVG(CHANGEVAL), 0,FundTypeID FROM fund_temp GROUP BY FundTypeID,FUNDTYPE;
				
		OPEN FUND_CURSOR;
		FETCH FUND_CURSOR INTO v_CurFundType;
			WHILE NOT_FOUND = 0
				DO
				SET @rowindex := -1;
				SET v_CurMedian = 0;
				SET v_CurMedian = (SELECT AVG(g.CHANGEVAL) AS MEDIANVAL
				FROM (SELECT @rowindex:=@rowindex + 1 AS rowindex, CHANGEVAL FROM fund_temp WHERE FUNDTYPE = v_CurFundType ORDER BY CHANGEVAL) g
				WHERE g.rowindex IN (FLOOR(@rowindex / 2) , CEIL(@rowindex / 2)));
				UPDATE Newfund_temp SET MEDIANVAL = v_CurMedian WHERE FUNDTYPE = v_CurFundType;
				FETCH FUND_CURSOR INTO v_CurFundType;
			END WHILE;
		CLOSE FUND_CURSOR;
		SELECT FUNDTYPE, MEANVAL 'CHANGEVALUE', MEDIANVAL,FundTypeID FROM Newfund_temp;
	END;
END$$
DELIMITER ;