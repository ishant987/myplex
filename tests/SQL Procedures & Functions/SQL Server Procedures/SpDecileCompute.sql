USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[SpDecileCompute]    Script Date: 03-03-2022 16:11:33 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[SpDecileCompute] AS DECLARE @Quartile FLOAT,
    @FQuartile FLOAT,
    @SQuartile FLOAT,
    @TQuartile FLOAT,
    @4Quartile FLOAT,
    @5Quartile FLOAT,
    @6Quartile FLOAT,
    @7Quartile FLOAT,
    @8Quartile FLOAT,
    @9Quartile FLOAT,
    @10Quartile FLOAT,
    @LQuartile FLOAT,
    @FundCode VARCHAR(25),
    @FetchValue FLOAT BEGIN
SET
    NOCOUNT ON;

SET
    @Quartile = (
        SELECT
            (MAX(COMPVALUE) - MIN(COMPVALUE)) AS QUARDIFF
        FROM
            #QUARTILEDATA)
        SET
            @Quartile = (@Quartile / 10)
        SET
            @Quartile = CAST(@Quartile AS DECIMAL(10, 5))
        SET
            @FQuartile = (
                SELECT
                    MAX(COMPVALUE) AS FQUARTILE
                FROM
                    #QUARTILEDATA)		
                SET
                    @FQuartile = CAST(@FQuartile AS DECIMAL(10, 5))
                SET
                    @SQuartile = CAST((@FQuartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @TQuartile = CAST((@SQuartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @4Quartile = CAST((@TQuartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @5Quartile = CAST((@4Quartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @6Quartile = CAST((@5Quartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @7Quartile = CAST((@6Quartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @8Quartile = CAST((@7Quartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @9Quartile = CAST((@8Quartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @10Quartile = CAST((@9Quartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @LQuartile = (
                        SELECT
                            MIN(COMPVALUE) AS FQUARTILE
                        FROM
                            #QUARTILEDATA)
                            DECLARE QUARTILECURSOR CURSOR FOR
                        SELECT
                            FUNDCODE,
                            COMPVALUE
                        FROM
                            #QUARTILEDATA
                            OPEN QUARTILECURSOR FETCH NEXT
                        FROM
                            QUARTILECURSOR INTO @FundCode,
                            @FetchValue WHILE @ @FETCH_STATUS = 0 BEGIN
                        SET
                            @FetchValue = CAST(@FetchValue AS DECIMAL(10, 5))
                            /*
                             IF @FetchValue >= @10Quartile AND @FetchValue < @9Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  10 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @9Quartile AND @10Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  9 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @8Quartile AND @9Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  8 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @7Quartile AND @8Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  7 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @6Quartile AND @7Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  6 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @5Quartile AND @6Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  5 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @4Quartile AND @5Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  4 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @TQuartile AND @4Quartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  3 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @SQuartile AND @TQuartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  2 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue BETWEEN @FQuartile AND @SQuartile
                             BEGIN
                             UPDATE #QUARTILEDATA SET QUARTILE =  1 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                             END
                             */
                            IF @FetchValue >= @10Quartile
                            AND @FetchValue < @9Quartile BEGIN
                        UPDATE
                            #QUARTILEDATA SET QUARTILE =  10 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
                    END
                    ELSE IF @FetchValue >= @9Quartile
                    AND @FetchValue < @8Quartile BEGIN
                UPDATE
                    #QUARTILEDATA SET QUARTILE =  9 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
            END
            ELSE IF @FetchValue >= @8Quartile
            AND @FetchValue < @7Quartile BEGIN
        UPDATE
            #QUARTILEDATA SET QUARTILE =  8 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
    END
    ELSE IF @FetchValue >= @7Quartile
    AND @FetchValue < @6Quartile BEGIN
UPDATE
    #QUARTILEDATA SET QUARTILE =  7 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
END
ELSE IF @FetchValue >= @6Quartile
AND @FetchValue < @5Quartile BEGIN
UPDATE
    #QUARTILEDATA SET QUARTILE =  6 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
END
ELSE IF @FetchValue >= @5Quartile
AND @FetchValue < @4Quartile BEGIN
UPDATE
    #QUARTILEDATA SET QUARTILE =  5 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
END
ELSE IF @FetchValue >= @4Quartile
AND @FetchValue < @TQuartile BEGIN
UPDATE
    #QUARTILEDATA SET QUARTILE =  4 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
END
ELSE IF @FetchValue >= @TQuartile
AND @FetchValue < @SQuartile BEGIN
UPDATE
    #QUARTILEDATA SET QUARTILE =  3 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
END
ELSE IF @FetchValue >= @SQuartile
AND @FetchValue < @FQuartile BEGIN
UPDATE
    #QUARTILEDATA SET QUARTILE =  2 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
END
ELSE IF @FetchValue >= @FQuartile BEGIN
UPDATE
    #QUARTILEDATA SET QUARTILE =  1 WHERE #QUARTILEDATA.FUNDCODE = @FundCode
END FETCH NEXT
FROM
    QUARTILECURSOR INTO @FundCode,
    @FetchValue
END CLOSE QUARTILECURSOR DEALLOCATE QUARTILECURSOR
UPDATE
    #QUARTILEDATA SET QUARTILE = 10 WHERE QUARTILE IS NULL
END