USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[risk_tolerance_portfolio]    Script Date: 25-02-2022 15:50:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[risk_tolerance_portfolio] 
	-- Add the parameters for the stored procedure here
	-- @p_tot_amt_pack DECIMAL(10,2),
	@portfolio_id INT
	
AS
DECLARE
@p_q1_v7 DECIMAL(10,3),
@p_q2_v2 DECIMAL(10,3),
@p_q3_v10 DECIMAL(10,3),
@tot_avg DECIMAL(10,3),
@check_qs DECIMAL(10,3),
@very_high VARCHAR(100),
@very_high_remarks VARCHAR(100),
@status_show VARCHAR(50),


@p_paid_package_name INT
BEGIN

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	-- SELECT <@Param1, sysname, @p1>, <@Param2, sysname, @p2>
SET @p_q1_v7=(SELECT ((SUM(q1_v1)+Sum(q1_v2)+Sum(q1_v3)+Sum(q1_v4)+Sum(q1_v5)+Sum(q1_v6)+Sum(q1_v7))/7.0) FROM tb_risk_tolerance_portfolio_reg WHERE portfolio_id=@portfolio_id);
SET @p_q2_v2=(SELECT (SUM(q2_v1)+SUM(q2_v2))/2.0 FROM tb_risk_tolerance_portfolio_reg WHERE portfolio_id=@portfolio_id);
SET @check_qs=(SELECT q3_v8 FROM tb_risk_tolerance_portfolio_reg WHERE portfolio_id=@portfolio_id);
if @check_qs=1 BEGIN
SET @p_q3_v10=(SELECT (SUM(q3_v1)+SUM(q3_v2)+SUM(q3_v3)+SUM(q3_v4)+SUM(q3_v5)+SUM(q3_v6)+SUM(q3_v7)+SUM(q3_v9)+SUM(q3_v10))/9.0 FROM tb_risk_tolerance_portfolio_reg WHERE portfolio_id=@portfolio_id);

END
else
SET @p_q3_v10=(SELECT (SUM(q3_v1)+SUM(q3_v2)+SUM(q3_v3)+SUM(q3_v4)+SUM(q3_v5)+SUM(q3_v6)+SUM(q3_v7))/7.0 FROM tb_risk_tolerance_portfolio_reg WHERE portfolio_id=@portfolio_id);
SET @tot_avg =(@p_q1_v7 + @p_q2_v2 + @p_q3_v10)/3.0;


				
SELECT @p_q1_v7 as accor1,@p_q2_v2 as accor2,@p_q3_v10 as accor3,@tot_avg as tot_avg,"tolerance_level" = CASE 
		WHEN (@tot_avg > 0 and @tot_avg <=1.0) THEN 'Very High'
		WHEN (@tot_avg > 1.001 and @tot_avg <=2.0) THEN 'High'
		WHEN (@tot_avg > 2.001 and @tot_avg <=3.0) THEN 'Moderate'
		WHEN (@tot_avg > 3.001 and @tot_avg <=4.0) THEN 'Low'
		WHEN ((@tot_avg > 4.001 and @tot_avg <=5.0)or(@tot_avg>5.001)) THEN 'Very Low'
		ELSE 'None'
		END,
		"equity" = CASE 
		WHEN (@tot_avg > 0 and @tot_avg <=1.0) THEN '100'
		WHEN (@tot_avg > 1.001 and @tot_avg <=2.0) THEN '80'
		WHEN (@tot_avg > 2.001 and @tot_avg <=3.0) THEN '60'
		WHEN (@tot_avg > 3.001 and @tot_avg <=4.0) THEN '40'
		WHEN ((@tot_avg > 4.001 and @tot_avg <=5.0)or(@tot_avg>5.001)) THEN '20'
		ELSE 'None'
		END,
		"debt" = CASE 
		WHEN (@tot_avg > 0 and @tot_avg <=1.0) THEN '0'
		WHEN (@tot_avg > 1.001 and @tot_avg <=2.0) THEN '20'
		WHEN (@tot_avg > 2.001 and @tot_avg <=3.0) THEN '40'
		WHEN (@tot_avg > 3.001 and @tot_avg <=4.0) THEN '60'
		WHEN ((@tot_avg > 4.001 and @tot_avg <=5.0)or(@tot_avg>5.001)) THEN '80'
		ELSE 'None'
		END,
		"capacity_to_take_risk_for_total" = CASE
		WHEN (@tot_avg > 0 and @tot_avg <=1.0) THEN 'Highly Aggressive'
		WHEN (@tot_avg > 1.001 and @tot_avg <=2.0) THEN 'Aggressive'
		WHEN (@tot_avg > 2.001 and @tot_avg <=3.0) THEN 'Moderate'
		WHEN (@tot_avg > 3.001 and @tot_avg <=4.0) THEN 'Conservative'
		WHEN ((@tot_avg > 4.001 and @tot_avg <=5.0)or(@tot_avg>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END,
		"capacity_to_take_risk_for_accor1" = CASE
		WHEN (@p_q1_v7 > 0 and @p_q1_v7 <=1.0) THEN 'Highly Aggressive'
		WHEN (@p_q1_v7 > 1.001 and @p_q1_v7 <=2.0) THEN 'Aggressive'
		WHEN (@p_q1_v7 > 2.001 and @p_q1_v7 <=3.0) THEN 'Moderate'
		WHEN (@p_q1_v7 > 3.001 and @p_q1_v7 <=4.0) THEN 'Conservative'
		WHEN ((@p_q1_v7 > 4.001 and @p_q1_v7 <=5.0)or(@p_q1_v7>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END,
		"capacity_to_take_risk_for_accor2" = CASE
		WHEN (@p_q2_v2 > 0 and @p_q2_v2 <=1.0) THEN 'Highly Aggressive'
		WHEN (@p_q2_v2 > 1.001 and @p_q2_v2 <=2.0) THEN 'Aggressive'
		WHEN (@p_q2_v2 > 2.001 and @p_q2_v2 <=3.0) THEN 'Moderate'
		WHEN (@p_q2_v2 > 3.001 and @p_q2_v2 <=4.0) THEN 'Conservative'
		WHEN ((@p_q2_v2 > 4.001 and @p_q2_v2 <=5.0)or(@p_q2_v2>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END,
		"capacity_to_take_risk_for_accor3" = CASE
		WHEN (@p_q3_v10 > 0 and @p_q3_v10 <=1.0) THEN 'Highly Aggressive'
		WHEN (@p_q3_v10 > 1.001 and @p_q3_v10 <=2.0) THEN 'Aggressive'
		WHEN (@p_q3_v10 > 2.001 and @p_q3_v10 <=3.0) THEN 'Moderate'
		WHEN (@p_q3_v10 > 3.001 and @p_q3_v10 <=4.0) THEN 'Conservative'
		WHEN ((@p_q3_v10 > 4.001 and @p_q3_v10 <=5.0)or(@p_q3_v10>5.001)) THEN 'Highly Conservative'
		ELSE  'None'
		END,

		"accor1_star" = CASE
		WHEN (@p_q1_v7 > 0 and @p_q1_v7 <=1.0) THEN '5'
		WHEN (@p_q1_v7 > 1.001 and @p_q1_v7 <=2.0) THEN '4'
		WHEN (@p_q1_v7 > 2.001 and @p_q1_v7 <=3.0) THEN '3'
		WHEN (@p_q1_v7 > 3.001 and @p_q1_v7 <=4.0) THEN '2'
		WHEN ((@p_q1_v7 > 4.001 and @p_q1_v7 <=5.0)or(@p_q1_v7>5.001)) THEN '1'
		ELSE  'None'
		END,
		"accor2_star" = CASE
		WHEN (@p_q2_v2 > 0 and @p_q2_v2 <=1.0) THEN '5'
		WHEN (@p_q2_v2 > 1.001 and @p_q2_v2 <=2.0) THEN '4'
		WHEN (@p_q2_v2 > 2.001 and @p_q2_v2 <=3.0) THEN '3'
		WHEN (@p_q2_v2 > 3.001 and @p_q2_v2 <=4.0) THEN '2'
		WHEN ((@p_q2_v2 > 4.001 and @p_q2_v2 <=5.0)or(@p_q2_v2>5.001)) THEN '1'
		ELSE  'None'
		END,
		"accor3_star" = CASE
		WHEN (@p_q3_v10 > 0 and @p_q3_v10 <=1.0) THEN '5'
		WHEN (@p_q3_v10 > 1.001 and @p_q3_v10 <=2.0) THEN '4'
		WHEN (@p_q3_v10 > 2.001 and @p_q3_v10 <=3.0) THEN '3'
		WHEN (@p_q3_v10 > 3.001 and @p_q3_v10 <=4.0) THEN '2'
		WHEN ((@p_q3_v10 > 4.001 and @p_q3_v10 <=5.0)or(@p_q3_v10>5.001)) THEN '1'
		ELSE  'None'
		END
		;
  
END



