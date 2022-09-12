DELIMITER //

CREATE  PROCEDURE sp_fund_index_currency (

p_flag VARCHAR(50)/* =NULL */,
p_start_date		VARCHAR(10)/* =NULL */,
p_end_date		VARCHAR(10)/* =NULL */,
p_var_id		INT/* =0 */,
p_var_name		VARCHAR(100)/* =NULL */,
p_fund_code1 VARCHAR(200)/* =NULL */,
p_fund_code2 VARCHAR(200)/* =NULL */,
p_year_id		INT/* =0 */)

BEGIN
IF UPPER(p_flag)='GET_FUND'
   THEN
    SELECT fund_id,fund_name,fund_code FROM mpx_fund_master ORDER BY fund_name;
ELSEIF UPPER(p_flag)='GET_INDEX'
THEN	
	SELECT * FROM mpx_indices_master ORDER BY name;
ELSEIF UPPER(p_flag)='GET_CURRENCY'
THEN
    SELECT * FROM mpx_currency_master WHERE cm_id <>6 ORDER BY name; 
ELSEIF UPPER(p_flag)='GRAPH_INDEX'
THEN
	SELECT D.closing_value VALUE,D.entry_date DATE,D.name NAME
    FROM mpx_indices_detail D 
	WHERE D.entry_date>=STR_TO_DATE(p_start_date, 103) AND D.entry_date<=STR_TO_DATE(p_end_date, 103) AND D.name=p_var_name
	ORDER BY 2;			
ELSEIF UPPER(p_flag)='GRAPH_CURRENCY'
THEN
    SELECT D.entry_value VALUE,D.entry_date DATE,F.name NAME
    FROM mpx_currency_master F
    INNER JOIN mpx_currency_detail D ON F.cm_id=D.cm_id
    WHERE D.entry_date>=STR_TO_DATE(p_start_date, 103) AND D.entry_date<=STR_TO_DATE(p_end_date, 103) AND F.cm_id=p_var_id
    ORDER BY 2;
ELSEIF UPPER(p_flag)='GRAPH_FUND'
THEN
    SELECT D.closing_nav VALUE,D.entry_date DATE,F.fund_name NAME,F.fund_code
    FROM mpx_fund_master F
    INNER JOIN mpx_fund_detail D ON F.fund_code=D.fund_code
    WHERE D.entry_date>=STR_TO_DATE(p_start_date, 103) AND D.entry_date<=STR_TO_DATE(p_end_date, 103) AND F.fund_code=p_var_name
    ORDER BY 2;
ELSEIF UPPER(p_flag)='GET_CMP_AAUM'
THEN
    SELECT fund_name,corpus_entry,percentage_change,corpus_change 
    FROM mpx_corpus_entry AS t1
    INNER JOIN mpx_fund_master AS t2 ON t1.fund_code = t2.fund_code 
    WHERE YEAR(entry_date)=p_year_id AND month(entry_date)=p_var_id AND t1.fund_code in (p_fund_code1,p_fund_code2) 
    ORDER BY 1;
ELSEIF UPPER(p_flag)='GET_BY_fund_type_id'
THEN
    SELECT fund_name,fund_code FROM mpx_fund_master WHERE fund_type_id =p_var_id ORDER BY 1;
END IF;
END;
//

DELIMITER ;