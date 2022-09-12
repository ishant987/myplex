USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[SpMonthlyTop10]    Script Date: 02-03-2022 10:56:54 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER   PROCEDURE [dbo].[SpMonthlyTop10]

@EntryDate	VARCHAR(10),
@TypeID	INT,
@TermID	INT

 AS

BEGIN
SET NOCOUNT ON;

	CREATE TABLE #TopTenReturn (
			Days6			VARCHAR(255) null,
			Days1			VARCHAR(255) null,
			Days2			VARCHAR(255) null,
			Days3			VARCHAR(255) null,
			RecID			INT null
		)


	CREATE TABLE #ReturnPercent (
			NameofFund		VARCHAR(255) null,
			FundID			VARCHAR(50) null,
			WeeklyAvg		FLOAT null,
			FortNightAvg		FLOAT null,
			MonthlyAvg		FLOAT null,
			BiMonthlyAvg		FLOAT null
		)

		INSERT INTO #ReturnPercent (NameOfFund, FundID,  WeeklyAvg, FortNightAvg, MonthlyAvg, BiMonthlyAvg) 

		SELECT X.NAMEOFFUND, X.FUNDCODE, 
		     
		    "SIXMONTHS" 
		      = CASE 
		        WHEN X.STARTVALUE6 <> 0 THEN (((X.CLOSINGVALUE6 - X.STARTVALUE6)/ X.STARTVALUE6)*100)
		        WHEN X.STARTVALUE6 = 0 THEN 0
		        END,
		    "ONEYEAR" 
		      = CASE 
		        WHEN X.STARTVALUE1 <> 0 THEN (((X.CLOSINGVALUE1 - X.STARTVALUE1)/ X.STARTVALUE1)*100)
		        WHEN X.STARTVALUE1 = 0 THEN 0
		        END,

		    "TWOYEAR" 
		      = CASE 
		        WHEN X.STARTVALUE2 <> 0 THEN ((POWER((X.CLOSINGVALUE2/X.STARTVALUE2),0.5) - 1) * 100)
		        WHEN X.STARTVALUE2 = 0 THEN 0
		        END,
		    "THREEYEAR" 
		      = CASE 
		        WHEN X.STARTVALUE3 <> 0 THEN  ((POWER((X.CLOSINGVALUE3/X.STARTVALUE3),0.33) - 1) * 100)
		        WHEN X.STARTVALUE3 = 0 THEN 0
		        END
		
		    FROM
		
		   (SELECT Y.NAMEOFFUND, Y.FUNDCODE, Y.INDICESNAME, 
		
		     ISNULL((SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL
		     WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND Y.OPDATE < DATEADD(DAY, -182, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -182, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103) AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE),0) AS STARTVALUE6,
		    (SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND Y.OPDATE < DATEADD(DAY, -182, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -182, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103)  AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE DESC) AS CLOSINGVALUE6,
		
		     ISNULL((SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL 
		     WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND Y.OPDATE < DATEADD(DAY, -365, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -365, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103) AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE),0) AS STARTVALUE1,
		    (SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND Y.OPDATE < DATEADD(DAY, -365, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -365, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103) AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE DESC) AS CLOSINGVALUE1,
		
		     ISNULL((SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL 
		     WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND Y.OPDATE < DATEADD(DAY, -730, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -730, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103) AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE),0) AS STARTVALUE2,
		    (SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND Y.OPDATE < DATEADD(DAY, -730, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -730, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103) AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE DESC) AS CLOSINGVALUE2,
		
		     ISNULL((SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL 
		     WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND Y.OPDATE < DATEADD(DAY, -1095, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -1095, CONVERT(DATETIME, @EntryDate, 103)) AND
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103) AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE),0) AS STARTVALUE3,
		    (SELECT TOP 1 TBFUNDDETAIL.CLOSINGNAV FROM TBFUNDDETAIL WHERE TBFUNDDETAIL.FUNDCODE = Y.FUNDCODE AND
		

		     TBFUNDDETAIL.ENTRYDATE > DATEADD(DAY, -1095, CONVERT(DATETIME, @EntryDate, 103)) AND Y.OPDATE < DATEADD(DAY, -1095, CONVERT(DATETIME, @EntryDate, 103)) AND  
		     TBFUNDDETAIL.ENTRYDATE <= CONVERT(DATETIME, @EntryDate, 103) AND TBFUNDDETAIL.HOLIDAY = 0 ORDER BY TBFUNDDETAIL.ENTRYDATE DESC) AS CLOSINGVALUE3
		
		     FROM (SELECT NAMEOFFUND, FUNDCODE, INDICESNAME, OPDATE FROM TBFUNDMASTER WHERE OPDATE < CONVERT(DATETIME, @EntryDate, 103) AND FUNDTYPEID = @TypeID AND FUNDTERMID = @TermID) Y) X

		     

					
		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionOne6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 0 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionOne1 		= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 0 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionOne2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 0 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionOne3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 0 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					1

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionTwo6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 1 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionTwo1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 1 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionTwo2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 1 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionTwo3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 1 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					2

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionThree6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 2 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionThree1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 2 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionThree2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 2 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionThree3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 2 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					3

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionFour6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 3 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionFour1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 3 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionFour2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 3 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionFour3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 3 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					4

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionFive6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 4 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionFive1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 4 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionFive2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 4 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionFive3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 4 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					5

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionSix6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 5 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionSix1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 5 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionSix2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 5 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionSix3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 5 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					6

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionSeven6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 6 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionSeven1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 6 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionSeven2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 6 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionSeven3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 6 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					7

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionEight6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 7 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionEight1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 7 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionEight2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 7 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionEight3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 7 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					8

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionNine6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 8 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionNine1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 8 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionNine2 		= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 8 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionNine3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 8 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					9

		INSERT INTO #TopTenReturn ( Days6, Days1, Days2, Days3, RecID )
			
			SELECT 	
					PositionTen6	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE WeeklyAvg <> 0 AND FundID NOT IN (SELECT TOP 9 FundID FROM #ReturnPercent WHERE WeeklyAvg <> 0 ORDER BY WeeklyAvg DESC) ORDER BY WeeklyAvg DESC),
					PositionTen1	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE FortNightAvg <> 0 AND FundID NOT IN (SELECT TOP 9 FundID FROM #ReturnPercent WHERE FortNightAvg <> 0 ORDER BY FortNightAvg DESC) ORDER BY FortNightAvg DESC),
					PositionTen2	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE MonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 9 FundID FROM #ReturnPercent WHERE MonthlyAvg <> 0 ORDER BY MonthlyAvg DESC) ORDER BY MonthlyAvg DESC),
					PositionTen3	 	= (SELECT TOP 1 NameOfFund FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 AND FundID NOT IN (SELECT TOP 9 FundID FROM #ReturnPercent WHERE BiMonthlyAvg <> 0 ORDER BY BiMonthlyAvg DESC) ORDER BY BiMonthlyAvg DESC),
					10


			SELECT 
					Days6		AS SixMonths,
					Days1		AS OneYear,
					Days2		AS TwoYears,
					Days3		AS ThreeYears,
					RecID		AS RecID
			FROM #TopTenReturn	WHERE
				(DAYS6 IS NOT NULL AND 
							DAYS1 IS NOT NULL AND 
							DAYS2 IS NOT NULL AND 
							DAYS3 IS NOT NULL)	




END
