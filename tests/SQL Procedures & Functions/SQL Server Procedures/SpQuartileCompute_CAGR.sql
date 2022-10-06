USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[SpQuartileCompute_CAGR]    Script Date: 03-03-2022 15:16:33 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[SpQuartileCompute_CAGR] AS DECLARE @Quartile FLOAT,
    @FQuartile FLOAT,
    @SQuartile FLOAT,
    @TQuartile FLOAT,
    @4Quartile FLOAT,
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
            @Quartile = (@Quartile / 4)
        SET
            @Quartile = CAST(@Quartile AS DECIMAL(10, 5))
        SET
            @FQuartile = (
                SELECT
                    MAX(CAGRVALUE) AS FQUARTILE
                FROM
                    #FINALRATIODATA)
                SET
                    @FQuartile = CAST((@FQuartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @SQuartile = CAST((@FQuartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @TQuartile = CAST((@SQuartile - @Quartile) AS DECIMAL(10, 5))
                SET
                    @4Quartile = CAST((@TQuartile - @Quartile) AS DECIMAL(10, 5)) -- select @Quartile AS Q ,@FQuartile AS FQ,@SQuartile AS SQ,@TQuartile AS TQ,@4Quartile AS Q4
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
                    @FetchValue = CAST(@FetchValue AS DECIMAL(10, 5)) IF @FetchValue >= @4Quartile
                    AND @FetchValue < @TQuartile BEGIN
                UPDATE
                    #FINALRATIODATA SET QUARTILE =  4 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
            END
            ELSE IF @FetchValue >= @TQuartile
            AND @FetchValue < @SQuartile BEGIN
        UPDATE
            #FINALRATIODATA SET QUARTILE =  3 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
    END
    ELSE IF @FetchValue >= @SQuartile
    AND @FetchValue < @FQuartile BEGIN
UPDATE
    #FINALRATIODATA SET QUARTILE = 2  WHERE #FINALRATIODATA.FUNDCODE = @FundCode
END
ELSE IF @FetchValue >= @FQuartile BEGIN
UPDATE
    #FINALRATIODATA SET QUARTILE =  1 WHERE #FINALRATIODATA.FUNDCODE = @FundCode
END FETCH NEXT
FROM
    QUARTILECURSOR INTO @FundCode,
    @FetchValue
END CLOSE QUARTILECURSOR DEALLOCATE QUARTILECURSOR
UPDATE
    #FINALRATIODATA SET QUARTILE = 4  WHERE QUARTILE IS NULL
    /* SELECT @FQuartile AS Q1, @SQuartile AS Q2, @TQuartile AS Q3, @4Quartile AS Q4 */
END