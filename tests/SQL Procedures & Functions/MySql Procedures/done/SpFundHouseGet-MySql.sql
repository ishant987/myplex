DELIMITER //

CREATE  PROCEDURE sp_fund_house_get()

BEGIN
    SELECT DISTINCT fund_house from mpx_fund_master;
END;
//

DELIMITER ;


