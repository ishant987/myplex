DELIMITER //

CREATE  PROCEDURE sp_fund_type_get (
p_type_id BIGINT /* = NULL */)

BEGIN
    SELECT ft_id,name AS FUNDTYPE
    FROM mpx_fund_type WHERE (p_type_id IS NULL OR ft_id = p_type_id)
    ORDER BY name ASC;
END;
//

DELIMITER ;