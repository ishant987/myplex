USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[SpFundSearchCatLagger]    Script Date: 03-03-2022 15:20:01 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[SpFundSearchCatLagger] @EntryDate VARCHAR(10),
    @FundTypeID INT,
    @duration INT AS BEGIN
SET
    NOCOUNT ON;

SELECT
    TOP 1 FINALDATA.NAMEOFFUND,
    FINALDATA.TYPENAME,
    FINALDATA.WEEKLY_CHANGE
FROM
    (
        SELECT
            TBFUNDMASTER.NAMEOFFUND,
            TBFUNDTYPE.TYPENAME,
            "WEEKLY_CHANGE" = CASE
                WHEN Z.PREVVALUE <= 0 THEN 0
                ELSE ((Z.CURVALUE - Z.PREVVALUE) / Z.PREVVALUE) * 100
            END
        FROM
            (
                SELECT
                    X.FUNDCODE,
                    X.PREVVALUE,
                    Y.CURVALUE
                FROM
                    (
                        SELECT
                            CLOSINGNAV AS PREVVALUE,
                            FUNDCODE
                        FROM
                            TBFUNDDETAIL
                        WHERE
                            TBFUNDDETAIL.ENTRYDATE = DATEADD(
                                DAY,
                                - @duration,
                                CONVERT(DATETIME, @EntryDate, 103)
                            )
                    ) X
                    INNER JOIN (
                        SELECT
                            CLOSINGNAV AS CURVALUE,
                            FUNDCODE
                        FROM
                            TBFUNDDETAIL
                        WHERE
                            TBFUNDDETAIL.ENTRYDATE = DATEADD(DAY, 0, CONVERT(DATETIME, @EntryDate, 103))
                    ) Y ON X.FUNDCODE = Y.FUNDCODE
            ) Z
            INNER JOIN TBFUNDMASTER ON Z.FUNDCODE = TBFUNDMASTER.FUNDCODE
            INNER JOIN TBFUNDTYPE ON TBFUNDMASTER.FUNDTYPEID = TBFUNDTYPE.FUNDTYPEID
            AND TBFUNDTYPE.FUNDTYPEID = @FundTypeID
    ) FINALDATA
ORDER BY
    FINALDATA.WEEKLY_CHANGE ASC
END