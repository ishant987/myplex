DELIMITER //

CREATE   PROCEDURE sp_fund_name_by_fund_house_get (
p_fund_house VARCHAR(255))

BEGIN
	SELECT * FROM  mpx_fund_master WHERE fund_house =p_fund_house Order By fund_name;
END;
//

DELIMITER ;