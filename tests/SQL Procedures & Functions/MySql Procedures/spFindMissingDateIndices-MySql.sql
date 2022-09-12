DELIMITER // 

CREATE PROCEDURE find_missing_date_indices (
    p_indices_name VARCHAR(50),
    p_start_date date,
    p_end_date date
) 

BEGIN
SELECT get_all_days_in_between(p_start_date, p_end_date) as total_days;
SELECT retDays AS missing_date, p_indices_name AS indices_name
FROM DayInBetween
WHERE NOT EXISTS (SELECT name FROM mpx_indices_detail WHERE entry_date = retDays AND name = p_indices_name);
END

// DELIMITER;