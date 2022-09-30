DELIMITER //

CREATE PROCEDURE sp_indices_composition_other (
p_month_no INT,
p_year_no INT)

BEGIN
    SELECT DISTINCT scrip_name 
    FROM mpx_mcap_eps 
    WHERE MONTH(entry_date) = p_month_no AND YEAR(entry_date) = p_year_no
    ORDER BY scrip_name ASC;
END;
//

DELIMITER ;