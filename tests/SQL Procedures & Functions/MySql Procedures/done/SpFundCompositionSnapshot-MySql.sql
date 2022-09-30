DELIMITER //

CREATE PROCEDURE sp_fund_composition_snapshot (
p_start_month		INT,
p_start_year		INT,
p_fund_code		VARCHAR(25))

BEGIN
	SELECT 
		C.scrip_name, 
		C.industry, 
		C.category, 
		C.content_per,
		((C.content_per*A.corpus_entry)/100) amount,
		A.corpus_entry
	FROM mpx_fund_composition C
	INNER JOIN mpx_corpus_entry A ON A.fund_code=C.fund_code AND C.entry_date=A.entry_date
	WHERE MONTH(A.entry_date) = p_start_month 
	AND YEAR(A.entry_date) = p_start_year 
	AND A.fund_code = p_fund_code COLLATE utf8_unicode_ci
	ORDER BY C.scrip_name;
END;
//

DELIMITER ;


