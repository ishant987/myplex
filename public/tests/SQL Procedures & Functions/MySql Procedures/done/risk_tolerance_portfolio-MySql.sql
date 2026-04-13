DELIMITER //

CREATE PROCEDURE risk_tolerance_portfolio (p_portfolio_id INT)
	
BEGIN
DECLARE v_p_q1_v7 DECIMAL(10,3);
DECLARE v_p_q2_v2 DECIMAL(10,3);
DECLARE v_p_q3_v10 DECIMAL(10,3);
DECLARE v_tot_avg DECIMAL(10,3);
DECLARE v_check_qs DECIMAL(10,3);
DECLARE v_very_high VARCHAR(100);
DECLARE v_very_high_remarks VARCHAR(100);
DECLARE v_status_show VARCHAR(50);

DECLARE v_p_paid_package_name INT;
BEGIN
SET v_p_q1_v7=(SELECT ((SUM(q1_v1)+Sum(q1_v2)+Sum(q1_v3)+Sum(q1_v4)+Sum(q1_v5)+Sum(q1_v6)+Sum(q1_v7))/7.0) FROM mpx_risk_tolerance_portfolio_reg WHERE portfolio_id=p_portfolio_id);
SET v_p_q2_v2=(SELECT (SUM(q2_v1)+SUM(q2_v2))/2.0 FROM mpx_risk_tolerance_portfolio_reg WHERE portfolio_id=p_portfolio_id);
SET v_check_qs=(SELECT q3_v8 FROM mpx_risk_tolerance_portfolio_reg WHERE portfolio_id=p_portfolio_id);
if v_check_qs=1 THEN
SET v_p_q3_v10=(SELECT (SUM(q3_v1)+SUM(q3_v2)+SUM(q3_v3)+SUM(q3_v4)+SUM(q3_v5)+SUM(q3_v6)+SUM(q3_v7)+SUM(q3_v9)+SUM(q3_v10))/9.0 FROM mpx_risk_tolerance_portfolio_reg WHERE portfolio_id=p_portfolio_id);
else
SET v_p_q3_v10=(SELECT (SUM(q3_v1)+SUM(q3_v2)+SUM(q3_v3)+SUM(q3_v4)+SUM(q3_v5)+SUM(q3_v6)+SUM(q3_v7))/7.0 FROM mpx_risk_tolerance_portfolio_reg WHERE portfolio_id=p_portfolio_id);
end if;
SET v_tot_avg =(v_p_q1_v7 + v_p_q2_v2 + v_p_q3_v10)/3.0;

SELECT v_p_q1_v7 as accor1,v_p_q2_v2 as accor2,v_p_q3_v10 as accor3,v_tot_avg as tot_avg, 
CASE 
		WHEN (v_tot_avg > 0 and v_tot_avg <=1.0) THEN 'Very High'
		WHEN (v_tot_avg > 1.001 and v_tot_avg <=2.0) THEN 'High'
		WHEN (v_tot_avg > 2.001 and v_tot_avg <=3.0) THEN 'Moderate'
		WHEN (v_tot_avg > 3.001 and v_tot_avg <=4.0) THEN 'Low'
		WHEN ((v_tot_avg > 4.001 and v_tot_avg <=5.0)or(v_tot_avg>5.001)) THEN 'Very Low'
		ELSE 'None'
		END AS "tolerance_level",
		CASE 
		WHEN (v_tot_avg > 0 and v_tot_avg <=1.0) THEN '100'
		WHEN (v_tot_avg > 1.001 and v_tot_avg <=2.0) THEN '80'
		WHEN (v_tot_avg > 2.001 and v_tot_avg <=3.0) THEN '60'
		WHEN (v_tot_avg > 3.001 and v_tot_avg <=4.0) THEN '40'
		WHEN ((v_tot_avg > 4.001 and v_tot_avg <=5.0)or(v_tot_avg>5.001)) THEN '20'
		ELSE 'None'
		END AS "equity",
		CASE 
		WHEN (v_tot_avg > 0 and v_tot_avg <=1.0) THEN '0'
		WHEN (v_tot_avg > 1.001 and v_tot_avg <=2.0) THEN '20'
		WHEN (v_tot_avg > 2.001 and v_tot_avg <=3.0) THEN '40'
		WHEN (v_tot_avg > 3.001 and v_tot_avg <=4.0) THEN '60'
		WHEN ((v_tot_avg > 4.001 and v_tot_avg <=5.0)or(v_tot_avg>5.001)) THEN '80'
		ELSE 'None'
		END AS "debt",
		CASE
		WHEN (v_tot_avg > 0 and v_tot_avg <=1.0) THEN 'Highly Aggressive'
		WHEN (v_tot_avg > 1.001 and v_tot_avg <=2.0) THEN 'Aggressive'
		WHEN (v_tot_avg > 2.001 and v_tot_avg <=3.0) THEN 'Moderate'
		WHEN (v_tot_avg > 3.001 and v_tot_avg <=4.0) THEN 'Conservative'
		WHEN ((v_tot_avg > 4.001 and v_tot_avg <=5.0)or(v_tot_avg>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END AS "capacity_to_take_risk_for_total",
		CASE
		WHEN (v_p_q1_v7 > 0 and v_p_q1_v7 <=1.0) THEN 'Highly Aggressive'
		WHEN (v_p_q1_v7 > 1.001 and v_p_q1_v7 <=2.0) THEN 'Aggressive'
		WHEN (v_p_q1_v7 > 2.001 and v_p_q1_v7 <=3.0) THEN 'Moderate'
		WHEN (v_p_q1_v7 > 3.001 and v_p_q1_v7 <=4.0) THEN 'Conservative'
		WHEN ((v_p_q1_v7 > 4.001 and v_p_q1_v7 <=5.0)or(v_p_q1_v7>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END AS "capacity_to_take_risk_for_accor1",
		CASE
		WHEN (v_p_q2_v2 > 0 and v_p_q2_v2 <=1.0) THEN 'Highly Aggressive'
		WHEN (v_p_q2_v2 > 1.001 and v_p_q2_v2 <=2.0) THEN 'Aggressive'
		WHEN (v_p_q2_v2 > 2.001 and v_p_q2_v2 <=3.0) THEN 'Moderate'
		WHEN (v_p_q2_v2 > 3.001 and v_p_q2_v2 <=4.0) THEN 'Conservative'
		WHEN ((v_p_q2_v2 > 4.001 and v_p_q2_v2 <=5.0)or(v_p_q2_v2>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END AS "capacity_to_take_risk_for_accor2",
		CASE
		WHEN (v_p_q3_v10 > 0 and v_p_q3_v10 <=1.0) THEN 'Highly Aggressive'
		WHEN (v_p_q3_v10 > 1.001 and v_p_q3_v10 <=2.0) THEN 'Aggressive'
		WHEN (v_p_q3_v10 > 2.001 and v_p_q3_v10 <=3.0) THEN 'Moderate'
		WHEN (v_p_q3_v10 > 3.001 and v_p_q3_v10 <=4.0) THEN 'Conservative'
		WHEN ((v_p_q3_v10 > 4.001 and v_p_q3_v10 <=5.0)or(v_p_q3_v10>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END AS "capacity_to_take_risk_for_accor3",
		CASE
		WHEN (v_p_q1_v7 > 0 and v_p_q1_v7 <=1.0) THEN '5'
		WHEN (v_p_q1_v7 > 1.001 and v_p_q1_v7 <=2.0) THEN '4'
		WHEN (v_p_q1_v7 > 2.001 and v_p_q1_v7 <=3.0) THEN '3'
		WHEN (v_p_q1_v7 > 3.001 and v_p_q1_v7 <=4.0) THEN '2'
		WHEN ((v_p_q1_v7 > 4.001 and v_p_q1_v7 <=5.0)or(v_p_q1_v7>5.001)) THEN '1'
		ELSE  'None'
		END AS "accor1_star",
		CASE
		WHEN (v_p_q2_v2 > 0 and v_p_q2_v2 <=1.0) THEN '5'
		WHEN (v_p_q2_v2 > 1.001 and v_p_q2_v2 <=2.0) THEN '4'
		WHEN (v_p_q2_v2 > 2.001 and v_p_q2_v2 <=3.0) THEN '3'
		WHEN (v_p_q2_v2 > 3.001 and v_p_q2_v2 <=4.0) THEN '2'
		WHEN ((v_p_q2_v2 > 4.001 and v_p_q2_v2 <=5.0)or(v_p_q2_v2>5.001)) THEN '1'
		ELSE  'None'
		END AS "accor2_star",
		CASE
		WHEN (v_p_q3_v10 > 0 and v_p_q3_v10 <=1.0) THEN '5'
		WHEN (v_p_q3_v10 > 1.001 and v_p_q3_v10 <=2.0) THEN '4'
		WHEN (v_p_q3_v10 > 2.001 and v_p_q3_v10 <=3.0) THEN '3'
		WHEN (v_p_q3_v10 > 3.001 and v_p_q3_v10 <=4.0) THEN '2'
		WHEN ((v_p_q3_v10 > 4.001 and v_p_q3_v10 <=5.0)or(v_p_q3_v10>5.001)) THEN '1'
		ELSE  'None'
		END AS "accor3_star"
		;
  
END;
END;
//

DELIMITER ;