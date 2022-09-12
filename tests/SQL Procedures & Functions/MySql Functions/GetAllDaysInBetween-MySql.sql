DELIMITER //

CREATE FUNCTION get_all_days_in_between(p_first_day DATE, p_last_day DATE) 
RETURNS int(11)

BEGIN
    DECLARE v_currentDay DATE;
    DECLARE total_days INT;
    SET total_days = 0;
    SET v_currentDay = p_first_day;  
    create temporary table DayInBetween
    (
        retDays DATE
    ); 

    WHILE v_currentDay <= p_last_day DO    
        INSERT INTO DayInBetween(retDays) VALUES(v_currentDay);     
        SET v_currentDay = TIMESTAMPADD(DAY, 1, v_currentDay);
        SET total_days = total_days+1;
    END WHILE;

    RETURN (total_days);
END