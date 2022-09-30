DELIMITER / / CREATE PROCEDURE find_missing_date_nav (
	p_fund_code VARCHAR(50),
	p_start_date date,
	p_end_date date
) BEGIN

SELECT t1.selected_date as missing_date, p_fund_code AS fund_code
FROM
(select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
WHERE selected_date between p_start_date and p_end_date) AS t1
LEFT JOIN
	( SELECT * FROM mpx_fund_detail WHERE fund_code=p_fund_code COLLATE utf8_unicode_ci AND entry_date BETWEEN p_start_date and p_end_date GROUP BY (entry_date) ) AS fd
ON t1.selected_date=fd.entry_date
WHERE fd.fund_code IS NULL;

END;

/ / DELIMITER;