DELIMITER //

CREATE PROCEDURE sp_fund_type_term (  
  
p_flag VARCHAR(100)/* =NULL */,  
p_type_id INT/* =NULL */)  
  
    
BEGIN  
  
IF UPPER(p_flag)='GET_FUNDTYPE'  
THEN  
  
 Select distinct T.ft_id,T.name    
  From mpx_fund_master M  
  INNER JOIN mpx_fund_type T ON M.fund_type_id=T.ft_id  
 order by name;  
   
  
ELSEIF UPPER(p_flag)='GET_FUNDTERM'  
THEN   
 Select T.fund_term_id,T.term    
   From mpx_fund_master M  
   INNER JOIN mpx_fund_term T ON M.fund_term_id=T.ftm_id  
     where M.fund_type_id =p_type_id
 Limit 1;  
END IF;  
   
END;
//

DELIMITER ;