USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[SpFundCompositionTopScripIndividual]    Script Date: 02-03-2022 18:24:26 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[SpFundCompositionTopScripIndividual] @StartMonth INT,
    @StartYear BIGINT AS BEGIN Declare @check_date_cnt INT,
    @newmonth INT,
    @newyear BIGINT
SET
    NOCOUNT ON;

SET
    @check_date_cnt = (
        SELECT
            count(*)
        FROM
            [MYPLEXUSDB_70803].[dbo].[TbFundComposition]
        WHERE
            Month(EntryDate) = @StartMonth
            AND YEAR(EntryDate) = @StartYear
    );

if(@check_date_cnt = 0) BEGIN
SET
    @newmonth = (
        SELECT
            top 1 Month(D1.EntryDate)
        from
            [MYPLEXUSDB_70803].[dbo].[TbFundComposition] D1
        order by
            D1.EntryDate DESC
    );

SET
    @newyear = (
        SELECT
            top 1 year(D1.EntryDate)
        from
            [MYPLEXUSDB_70803].[dbo].[TbFundComposition] D1
        order by
            D1.EntryDate DESC
    );

SELECT
    FINALDATA.SCRIPNAME,
    FINALDATA.INDUSTRY,
    FINALDATA.NAMEOFFUND,
    FINALDATA.CONTENTPER,
    FINALDATA.AMOUNT,
    @newmonth as month_cnt,
    @newyear as yr_cnt
FROM
    (
        SELECT
            Z.SCRIPNAME,
            Z.INDUSTRY,
            Z.NAMEOFFUND,
            Z.CONTENTPER,
            "AMOUNT" = (TBCORPUSENTRY.CORPUSENTRY * Z.CONTENTPER) / 100
        FROM
            (
                SELECT
                    Y.ENTRYDATE,
                    Y.FUNDCODE,
                    Y.NAMEOFFUND,
                    Y.SCRIPNAME,
                    Y.INDUSTRY,
                    Y.CONTENTPER
                FROM
                    (
                        SELECT
                            TBFUNDCOMPOSITION.ENTRYDATE,
                            TBFUNDCOMPOSITION.FUNDCODE,
                            TBFUNDMASTER.NAMEOFFUND,
                            TBFUNDCOMPOSITION.SCRIPNAME,
                            TBFUNDCOMPOSITION.INDUSTRY,
                            TBFUNDCOMPOSITION.CONTENTPER
                        FROM
                            TBFUNDCOMPOSITION
                            INNER JOIN TBFUNDMASTER ON TBFUNDCOMPOSITION.FUNDCODE = TBFUNDMASTER.FUNDCODE
                        WHERE
                            MONTH(ENTRYDATE) = @newmonth
                            AND YEAR(ENTRYDATE) = @newyear
                            AND TBFUNDMASTER.FUNDCODE IN (
                                SELECT
                                    FUNDCODE
                                FROM
                                    #TmpFundCodes)) Y)Z
                                    INNER JOIN TBCORPUSENTRY ON TBCORPUSENTRY.FUNDCODE = Z.FUNDCODE
                                    AND TBCORPUSENTRY.ENTRYDATE = Z.ENTRYDATE
                            ) FINALDATA
                        ORDER BY
                            FINALDATA.NAMEOFFUND,
                            FINALDATA.AMOUNT DESC
                    END
                    ELSE BEGIN
                SELECT
                    FINALDATA.SCRIPNAME,
                    FINALDATA.INDUSTRY,
                    FINALDATA.NAMEOFFUND,
                    FINALDATA.CONTENTPER,
                    FINALDATA.AMOUNT
                FROM
                    (
                        SELECT
                            Z.SCRIPNAME,
                            Z.INDUSTRY,
                            Z.NAMEOFFUND,
                            Z.CONTENTPER,
                            "AMOUNT" = (TBCORPUSENTRY.CORPUSENTRY * Z.CONTENTPER) / 100
                        FROM
                            (
                                SELECT
                                    Y.ENTRYDATE,
                                    Y.FUNDCODE,
                                    Y.NAMEOFFUND,
                                    Y.SCRIPNAME,
                                    Y.INDUSTRY,
                                    Y.CONTENTPER
                                FROM
                                    (
                                        SELECT
                                            TBFUNDCOMPOSITION.ENTRYDATE,
                                            TBFUNDCOMPOSITION.FUNDCODE,
                                            TBFUNDMASTER.NAMEOFFUND,
                                            TBFUNDCOMPOSITION.SCRIPNAME,
                                            TBFUNDCOMPOSITION.INDUSTRY,
                                            TBFUNDCOMPOSITION.CONTENTPER
                                        FROM
                                            TBFUNDCOMPOSITION
                                            INNER JOIN TBFUNDMASTER ON TBFUNDCOMPOSITION.FUNDCODE = TBFUNDMASTER.FUNDCODE
                                        WHERE
                                            MONTH(ENTRYDATE) = @StartMonth
                                            AND YEAR(ENTRYDATE) = @StartYear
                                            AND TBFUNDMASTER.FUNDCODE IN (
                                                SELECT
                                                    FUNDCODE
                                                FROM
                                                    #TmpFundCodes)) Y)Z
                                                    INNER JOIN TBCORPUSENTRY ON TBCORPUSENTRY.FUNDCODE = Z.FUNDCODE
                                                    AND TBCORPUSENTRY.ENTRYDATE = Z.ENTRYDATE
                                            ) FINALDATA
                                        ORDER BY
                                            FINALDATA.NAMEOFFUND,
                                            FINALDATA.AMOUNT DESC
                                    END
                            END