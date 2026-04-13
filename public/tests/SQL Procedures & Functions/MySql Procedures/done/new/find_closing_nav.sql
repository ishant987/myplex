DELIMITER / / CREATE PROCEDURE find_closing_nav (
	p_fund_code VARCHAR(50),
	p_entry_date date
) BEGIN

SELECT closing_nav FROM mpx_fund_detail WHERE fund_code=p_fund_code COLLATE utf8_unicode_ci AND DATE_SUB(entry_date, INTERVAL -1 DAY)=p_entry_date;

END;

/ / DELIMITER;