USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[SpDecileCompute_CAGR]    Script Date: 03-03-2022 15:17:04 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[SpDecileCompute_CAGR] AS DECLARE @Quartile FLOAT,
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
            (MAX(CAGRVALUE) - MIN(CAGRVALUE)) AS QUARDIFF
        FROM
            #FINALRATIODATA)
        SET
            @Quartile = (@Quartile / 10)
        SET
            @Quartile = CAST(@Quartile AS DECIMAL(10, 5))
        SET
            @FQuartile = (
                SELECT
                    MAX(CAGRVALUE) AS FQUARTILE
                FROM
                    #FINALRATIODATA)		
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
                            MIN(CAGRVALUE) AS FQUARTILE
                        FROM
                            #FINALRATIODATA)
                            DECLARE QUARTILECURSOR CURSOR FOR
                        SELECT
                            FUNDCODE,
                            CAGRVALUE
                        FROM
                            #FINALRATIODATA
                            OPEN QUARTILECURSOR FETCH NEXT
                        FROM
                            QUARTILECURSOR INTO @FundCode,
                            @FetchValue WHILE @ @FETCH_STATUS = 0 BEGIN
                        SET
                            @FetchValue = CAST(@FetchValue AS DECIMAL(10, 5))
                            /*				IF @FetchValue >= @10Quartile AND @FetchValue < @9Quartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  10 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @9Quartile AND @FetchValue < @8Quartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  9 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @8Quartile AND @FetchValue < @7Quartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  8 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @7Quartile AND @FetchValue < @6Quartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  7 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @6Quartile AND @FetchValue < @5Quartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  6 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @5Quartile AND @FetchValue < @4Quartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  5 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @4Quartile AND @FetchValue < @TQuartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  4 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @TQuartile AND @FetchValue < @SQuartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  3 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @SQuartile AND @FetchValue < @FQuartile
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  2 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END
                             ELSE IF @FetchValue >= @FQuartile 
                             BEGIN
                             UPDATE #FINALRATIODATA SET DECILE =  1 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                             END*/
                            IF @FetchValue >= @LQuartile
                            AND @FetchValue < @10Quartile BEGIN
                        UPDATE
                            #FINALRATIODATA SET DECILE =  10 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
                    END
                    ELSE IF @FetchValue >= @10Quartile
                    AND @FetchValue < @9Quartile BEGIN
                UPDATE
                    #FINALRATIODATA SET DECILE =  9 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
            END
            ELSE IF @FetchValue >= @9Quartile
            AND @FetchValue < @8Quartile BEGIN
        UPDATE
            #FINALRATIODATA SET DECILE =  8 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
    END
    ELSE IF @FetchValue >= @8Quartile
    AND @FetchValue < @7Quartile BEGIN
UPDATE
    #FINALRATIODATA SET DECILE =  7 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
END
ELSE IF @FetchValue >= @7Quartile
AND @FetchValue < @6Quartile BEGIN
UPDATE
    #FINALRATIODATA SET DECILE =  6 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
END
ELSE IF @FetchValue >= @6Quartile
AND @FetchValue < @5Quartile BEGIN
UPDATE
    #FINALRATIODATA SET DECILE =  5 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
END
ELSE IF @FetchValue >= @5Quartile
AND @FetchValue < @4Quartile BEGIN
UPDATE
    #FINALRATIODATA SET DECILE =  4 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
END
ELSE IF @FetchValue >= @4Quartile
AND @FetchValue < @TQuartile BEGIN
UPDATE
    #FINALRATIODATA SET DECILE =  3 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
END
ELSE IF @FetchValue >= @TQuartile
AND @FetchValue < @SQuartile BEGIN
UPDATE
    #FINALRATIODATA SET DECILE =  2 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
END
ELSE IF @FetchValue >= @SQuartile
AND @FetchValue <= @FQuartile BEGIN
UPDATE
    #FINALRATIODATA SET DECILE =  1 WHERE #FINALRATIODATA.FUNDCODE = @FundCode 
END FETCH NEXT
FROM
    QUARTILECURSOR INTO @FundCode,
    @FetchValue
END CLOSE QUARTILECURSOR DEALLOCATE QUARTILECURSOR
UPDATE
    #FINALRATIODATA SET DECILE = 10 WHERE DECILE IS NULL
END