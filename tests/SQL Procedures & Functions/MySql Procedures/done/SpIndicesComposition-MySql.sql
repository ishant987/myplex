DELIMITER //

CREATE PROCEDURE sp_indices_composition (
p_month_no INT,
p_year_no INT,
p_indices_name VARCHAR(100))

BEGIN
	SELECT scrip_name, type, industry, percentage 
    FROM mpx_indices_composition WHERE MONTH(entry_date) = p_month_no AND YEAR(entry_date) = p_year_no AND indices_name = p_indices_name
    ORDER BY scrip_name ASC;
END;
//

DELIMITER ;