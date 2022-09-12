USE [MYPLEXUSDB_70803]
GO
/****** Object:  UserDefinedFunction [dbo].[GetAllDaysInBetween]    Script Date: 26-02-2022 10:42:39 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER FUNCTION [dbo].[GetAllDaysInBetween](@FirstDay DATE, @LastDay DATE)
RETURNS @retDays TABLE 
(
    DayInBetween DATE
)
AS 
BEGIN
    DECLARE @currentDay DATE
    SELECT @currentDay = @FirstDay

    WHILE @currentDay <= @LastDay
    BEGIN

        INSERT @retDays (DayInBetween)
            SELECT @currentDay

        SELECT @currentDay = DATEADD(DAY, 1, @currentDay)
    END 

    RETURN
END
