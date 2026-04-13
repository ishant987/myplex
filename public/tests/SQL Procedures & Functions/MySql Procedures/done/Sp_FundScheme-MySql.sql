DELIMITER //

CREATE PROCEDURE sp_fund_scheme (

p_flag VARCHAR(100),
p_search_code	VARCHAR(500))

		
BEGIN

IF UPPER(p_flag)='BY_CLASSIFICATION'
THEN
SELECT M.fund_name, M.fund_manager, date_format(fund_opened,'%d/%m/%Y') fund_opened ,
	M.face_value, M.risk_free_return,M.indices_name,M.classification,T.term 
	FROM mpx_fund_master M 	
	INNER JOIN mpx_fund_term T ON M.fund_term_id = T.ftm_id
	WHERE M.classification = p_search_code	
	Order By M.fund_name;
ELSEIF UPPER(p_flag)='BY_FUNDHOUSE'
THEN	
	SELECT M.fund_name, M.fund_manager, date_format(fund_opened,'%d/%m/%Y') fund_opened ,
		M.face_value, M.risk_free_return,M.indices_name,M.classification,T.term 
		FROM mpx_fund_master M 	
	INNER JOIN mpx_fund_term T ON M.fund_term_id = T.ftm_id
		WHERE M.fund_house =p_search_code
	Order By M.fund_name;
END IF;
	
END;
//

DELIMITER ;