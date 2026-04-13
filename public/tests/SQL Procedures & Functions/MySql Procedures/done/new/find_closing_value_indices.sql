DELIMITER / / CREATE PROCEDURE find_closing_value_indices (
	p_indices_name VARCHAR(50),
	p_entry_date date
) 
BEGIN

SELECT closing_value FROM mpx_indices_detail WHERE name=p_indices_name COLLATE utf8_unicode_ci AND DATE_SUB(entry_date, INTERVAL -1 DAY)=p_entry_date;

END;

/ / DELIMITER;