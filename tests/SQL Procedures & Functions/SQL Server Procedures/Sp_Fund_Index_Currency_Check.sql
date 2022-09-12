USE [MYPLEXUSDB_70803]
GO
    /****** Object:  StoredProcedure [dbo].[Sp_Fund_Index_Currency_Check]    Script Date: 02-03-2022 18:33:51 ******/
SET
    ANSI_NULLS ON
GO
SET
    QUOTED_IDENTIFIER ON
GO
    ALTER PROCEDURE [dbo].[Sp_Fund_Index_Currency_Check] @StartDate VARCHAR(10) = NULL,
    @EndDate VARCHAR(10) = NULL,
    @varName NVARCHAR(100) = NULL,
    @varID INT = 0,
    @radio_val INT,
    @scheme_1 NVARCHAR(100),
    @scheme_2 NVARCHAR(100),
    @index_1 NVARCHAR(100),
    @index_2 NVARCHAR(100),
    @currrency_1 NVARCHAR(100),
    @currrency_2 NVARCHAR(100),
    @tab_for VARCHAR(10) AS BEGIN
SET
    NOCOUNT ON;

DECLARE @cntFromFund_1 INT,
@cntFromFund_2 INT,
@cntFromCur_1 INT,
@cntFromCur_2 INT,
@cntFromIndex_1 INT,
@cntFromIndex_2 INT,
@newFromDateFund_1 DATE,
@newFromDateFund_2 DATE,
@newFromDateCur_1 DATE,
@newFromDateCur_2 DATE,
@newFromDateIndex_1 DATE,
@newFromDateIndex_2 DATE,
@date_from_1 INT,
@date_from_2 INT,
@final_from_date DATE,
@cntToFund_1 INT,
@cntToFund_2 INT,
@cntToCur_1 INT,
@cntToCur_2 INT,
@cntToIndex_1 INT,
@cntToIndex_2 INT,
@newToDateFund_1 DATE,
@newToDateFund_2 DATE,
@newToDateCur_1 DATE,
@newToDateCur_2 DATE,
@newToDateIndex_1 DATE,
@newToDateIndex_2 DATE,
@date_to_1 INT,
@date_to_2 INT,
@final_to_date DATE,
@cntFromFund_1_scheme varchar(100),
@cnttoFund_1_scheme varchar(100),
@cntFromFund_2_scheme varchar(100),
@cnttoFund_2_scheme varchar(100),
@cntFromFund_1_index varchar(100),
@cnttoFund_1_index varchar(100),
@cntFromFund_2_index varchar(100),
@cnttoFund_2_index varchar(100),
@cntFromFund_1_currency varchar(100),
@cnttoFund_1_currency varchar(100),
@cntFromFund_2_currency varchar(100),
@cnttoFund_2_currency varchar(100),
@final_from_scheme varchar(100),
@final_to_scheme varchar(100),
@final_schemeindexcurrency_name varchar(100),
@show_msg varchar(1) = 0,
@final_message varchar(255) IF @radio_val = 1 BEGIN
SET
    @cntFromFund_1 = (
        SELECT
            count(*)
        from
            TbFundDetail D1
        WHERE
            D1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND D1.FundCode = @scheme_1
    );

SET
    @cntFromFund_2 = (
        SELECT
            count(*)
        from
            TbFundDetail D2
        WHERE
            D2.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND D2.FundCode = @scheme_2
    );

IF @cntFromFund_1 = 0 BEGIN
SET
    @newFromDateFund_1 = (
        SELECT
            top 1 D1.EntryDate
        from
            TbFundDetail D1
        WHERE
            D1.FundCode = @scheme_1
        order by
            D1.EntryDate ASC
    );

SET
    @cntFromFund_1_scheme =(
        SELECT
            NameOfFund
        FROM
            [MYPLEXUSDB_70803].[dbo].[TbFundMaster]
        WHERE
            FundCode = @scheme_1
    );

IF @tab_for = 'DP' BEGIN
SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_1_scheme,
        ' NAV available from ',
        CONVERT(VARCHAR, @newFromDateFund_1, 103)
    );

END
ELSE IF @tab_for = 'RA' BEGIN
SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_1_scheme,
        ' data available from ',
        CONVERT(VARCHAR, @newFromDateFund_1, 103)
    );

END
ELSE BEGIN
SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_1_scheme,
        ' composition available from ',
        FORMAT(@newFromDateFund_1, 'y')
    );

-- SET @final_message = CONCAT('For ',@cntFromFund_1_scheme,' composition available from ',CONVERT(VARCHAR, @newFromDateFund_1, 103));
END
SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateFund_1 = CONVERT(DATETIME, @StartDate, 103);

END IF @cntFromFund_2 = 0 BEGIN
SET
    @newFromDateFund_2 = (
        SELECT
            top 1 D2.EntryDate
        from
            TbFundDetail D2
        WHERE
            D2.FundCode = @scheme_2
        order by
            D2.EntryDate ASC
    );

SET
    @cntFromFund_2_scheme =(
        SELECT
            NameOfFund
        FROM
            [MYPLEXUSDB_70803].[dbo].[TbFundMaster]
        WHERE
            FundCode = @scheme_2
    );

IF @tab_for = 'DP' BEGIN
SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_2_scheme,
        ' NAV available from ',
        CONVERT(VARCHAR, @newFromDateFund_2, 103)
    );

END
ELSE IF @tab_for = 'RA' BEGIN
SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_2_scheme,
        ' data available from ',
        CONVERT(VARCHAR, @newFromDateFund_2, 103)
    );

END
ELSE BEGIN
SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_2_scheme,
        ' composition available from ',
        FORMAT(@newFromDateFund_2, 'y')
    );

-- SET @final_message = CONCAT('For ',@cntFromFund_2_scheme,' composition available from ',CONVERT(VARCHAR, @newFromDateFund_2, 103));
END
SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateFund_2 = CONVERT(DATETIME, @StartDate, 103);

END
SET
    @date_from_1 = DATEDIFF(day, getdate(), @newFromDateFund_1);

SET
    @date_from_2 = DATEDIFF(day, getdate(), @newFromDateFund_2);

IF @date_from_1 < @date_from_2 BEGIN
SET
    @final_from_date = @newFromDateFund_2;

SET
    @final_schemeindexcurrency_name = @cntFromFund_2_scheme;

END
ELSE BEGIN
SET
    @final_from_date = @newFromDateFund_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_scheme;

END
SET
    @cntToFund_1 = (
        SELECT
            count(*)
        from
            TbFundDetail D1
        WHERE
            D1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND D1.FundCode = @scheme_1
    );

SET
    @cntToFund_2 = (
        SELECT
            count(*)
        from
            TbFundDetail D2
        WHERE
            D2.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND D2.FundCode = @scheme_2
    );

IF @cntToFund_1 = 0 BEGIN
SET
    @newToDateFund_1 = (
        SELECT
            top 1 D1.EntryDate
        from
            TbFundDetail D1
        WHERE
            D1.FundCode = @scheme_1
        order by
            D1.EntryDate DESC
    );

-- SET @cnttoFund_1_scheme=(SELECT NameOfFund FROM [MYPLEXUSDB_70803].[dbo].[TbFundMaster] WHERE FundCode = @scheme_1); 
END
ELSE BEGIN
SET
    @newToDateFund_1 = CONVERT(DATETIME, @EndDate, 103);

END IF @cntToFund_2 = 0 BEGIN
SET
    @newToDateFund_2 = (
        SELECT
            top 1 D2.EntryDate
        from
            TbFundDetail D2
        WHERE
            D2.FundCode = @scheme_2
        order by
            D2.EntryDate DESC
    );

-- SET @cnttoFund_2_scheme=(SELECT NameOfFund FROM [MYPLEXUSDB_70803].[dbo].[TbFundMaster] WHERE FundCode = @scheme_2); 
END
ELSE BEGIN
SET
    @newToDateFund_2 = CONVERT(DATETIME, @EndDate, 103);

END
SET
    @date_to_1 = DATEDIFF(day, getdate(), @newToDateFund_1);

SET
    @date_to_2 = DATEDIFF(day, getdate(), @newToDateFund_2);

IF @date_to_1 > @date_to_2 BEGIN
SET
    @final_to_date = @newToDateFund_2;

-- SET @final_to_scheme=@cnttoFund_2_scheme;
END
ELSE BEGIN
SET
    @final_to_date = @newToDateFund_1;

-- SET @final_to_scheme=@cnttoFund_1_scheme;
END
END IF @radio_val = 2 BEGIN
SET
    @cntFromFund_1 = (
        SELECT
            count(*)
        from
            TbFundDetail D1
        WHERE
            D1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND D1.FundCode = @scheme_1
    );

SET
    @cntFromIndex_1 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E1
        WHERE
            E1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND E1.IndicesName = @index_1
    );

IF @cntFromFund_1 = 0 BEGIN
SET
    @newFromDateFund_1 = (
        SELECT
            top 1 D1.EntryDate
        from
            TbFundDetail D1
        WHERE
            D1.FundCode = @scheme_1
        order by
            D1.EntryDate ASC
    );

SET
    @cntFromFund_1_scheme =(
        SELECT
            NameOfFund
        FROM
            [MYPLEXUSDB_70803].[dbo].[TbFundMaster]
        WHERE
            FundCode = @scheme_1
    );

SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_1_scheme,
        ' NAV available from ',
        CONVERT(VARCHAR, @newFromDateFund_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN -- SET @cntFromFund_1_scheme = '';
-- SET @final_message = '';
SET
    @newFromDateFund_1 = CONVERT(DATETIME, @StartDate, 103);

END IF @cntFromIndex_1 = 0 BEGIN
SET
    @newFromDateIndex_1 = (
        SELECT
            top 1 E1.EntryDate
        from
            TbIndicesDetail E1
        WHERE
            E1.IndicesName = @index_1
        order by
            E1.EntryDate ASC
    );

SET
    @cntFromFund_1_index = @index_1;

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_1_index,
        ' from ',
        CONVERT(VARCHAR, @newFromDateIndex_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN -- SET @cntFromFund_1_index = '';
-- SET @final_message = '';
SET
    @newFromDateIndex_1 = CONVERT(DATETIME, @StartDate, 103)
END
SET
    @date_from_1 = DATEDIFF(day, getdate(), @newFromDateFund_1);

SET
    @date_from_2 = DATEDIFF(day, getdate(), @newFromDateIndex_1);

IF @date_from_1 < @date_from_2 BEGIN
SET
    @final_from_date = @newFromDateIndex_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_index;

END
ELSE BEGIN
SET
    @final_from_date = @newFromDateFund_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_scheme;

END
SET
    @cntToFund_1 = (
        SELECT
            count(*)
        from
            TbFundDetail D1
        WHERE
            D1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND D1.FundCode = @scheme_1
    );

SET
    @cntToIndex_1 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E1
        WHERE
            E1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND E1.IndicesName = @index_1
    );

IF @cntToFund_1 = 0 BEGIN
SET
    @newToDateFund_1 = (
        SELECT
            top 1 D1.EntryDate
        from
            TbFundDetail D1
        WHERE
            D1.FundCode = @scheme_1
        order by
            D1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateFund_1 = CONVERT(DATETIME, @EndDate, 103);

END IF @cntToIndex_1 = 0 BEGIN
SET
    @newToDateIndex_1 = (
        SELECT
            top 1 E1.EntryDate
        from
            TbIndicesDetail E1
        WHERE
            E1.IndicesName = @index_1
        order by
            E1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateIndex_1 = CONVERT(DATETIME, @EndDate, 103)
END
SET
    @date_to_1 = DATEDIFF(day, getdate(), @newToDateFund_1);

SET
    @date_to_2 = DATEDIFF(day, getdate(), @newToDateIndex_1);

IF @date_to_1 > @date_to_2 BEGIN
SET
    @final_to_date = @newToDateIndex_1;

END
ELSE BEGIN
SET
    @final_to_date = @newToDateFund_1;

END
END IF @radio_val = 3 BEGIN
SET
    @cntFromFund_1 = (
        SELECT
            count(*)
        from
            TbFundDetail D1
        WHERE
            D1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND D1.FundCode = @scheme_1
    );

SET
    @cntFromCur_1 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F1
        WHERE
            F1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND F1.CurrencyID = @currrency_1
    );

IF @cntFromFund_1 = 0 BEGIN
SET
    @newFromDateFund_1 = (
        SELECT
            top 1 D1.EntryDate
        from
            TbFundDetail D1
        WHERE
            D1.FundCode = @scheme_1
        order by
            D1.EntryDate ASC
    );

SET
    @cntFromFund_1_scheme =(
        SELECT
            NameOfFund
        FROM
            [MYPLEXUSDB_70803].[dbo].[TbFundMaster]
        WHERE
            FundCode = @scheme_1
    );

SET
    @final_message = CONCAT(
        'For ',
        @cntFromFund_1_scheme,
        ' NAV available from ',
        CONVERT(VARCHAR, @newFromDateFund_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateFund_1 = CONVERT(DATETIME, @StartDate, 103);

END IF @cntFromCur_1 = 0 BEGIN
SET
    @newFromDateCur_1 = (
        SELECT
            top 1 F1.EntryDate
        from
            TbCurrencyDetail F1
        WHERE
            F1.CurrencyID = @currrency_1
        order by
            F1.EntryDate ASC
    );

SET
    @cntFromFund_1_currency = (
        SELECT
            CurrencyName
        from
            TbCurrencyMaster F1
        WHERE
            F1.CurrencyID = @currrency_1
    );

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_1_currency,
        ' from ',
        CONVERT(VARCHAR, @newFromDateCur_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateCur_1 = CONVERT(DATETIME, @StartDate, 103)
END
SET
    @date_from_1 = DATEDIFF(day, getdate(), @newFromDateFund_1);

SET
    @date_from_2 = DATEDIFF(day, getdate(), @newFromDateCur_1);

IF @date_from_1 < @date_from_2 BEGIN
SET
    @final_from_date = @newFromDateCur_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_currency;

END
ELSE BEGIN
SET
    @final_from_date = @newFromDateFund_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_scheme;

END
SET
    @cntToFund_1 = (
        SELECT
            count(*)
        from
            TbFundDetail D1
        WHERE
            D1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND D1.FundCode = @scheme_1
    );

SET
    @cntToCur_1 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F1
        WHERE
            F1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND F1.CurrencyID = @currrency_1
    );

IF @cntToFund_1 = 0 BEGIN
SET
    @newToDateFund_1 = (
        SELECT
            top 1 D1.EntryDate
        from
            TbFundDetail D1
        WHERE
            D1.FundCode = @scheme_1
        order by
            D1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateFund_1 = CONVERT(DATETIME, @EndDate, 103);

END IF @cntToCur_1 = 0 BEGIN
SET
    @newToDateCur_1 = (
        SELECT
            top 1 F1.EntryDate
        from
            TbCurrencyDetail F1
        WHERE
            F1.CurrencyID = @currrency_1
        order by
            F1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateCur_1 = CONVERT(DATETIME, @EndDate, 103)
END
SET
    @date_to_1 = DATEDIFF(day, getdate(), @newToDateFund_1);

SET
    @date_to_2 = DATEDIFF(day, getdate(), @newToDateCur_1);

IF @date_to_1 > @date_to_2 BEGIN
SET
    @final_to_date = @newToDateCur_1;

END
ELSE BEGIN
SET
    @final_to_date = @newToDateFund_1;

END
END IF @radio_val = 4 BEGIN
SET
    @cntFromIndex_1 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E1
        WHERE
            E1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND E1.IndicesName = @index_1
    );

SET
    @cntFromIndex_2 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E2
        WHERE
            E2.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND E2.IndicesName = @index_2
    );

IF @cntFromIndex_1 = 0 BEGIN
SET
    @newFromDateIndex_1 = (
        SELECT
            top 1 E1.EntryDate
        from
            TbIndicesDetail E1
        WHERE
            E1.IndicesName = @index_1
        order by
            E1.EntryDate ASC
    );

SET
    @cntFromFund_1_index = @index_1;

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_1_index,
        ' from ',
        CONVERT(VARCHAR, @newFromDateIndex_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateIndex_1 = CONVERT(DATETIME, @StartDate, 103)
END IF @cntFromIndex_2 = 0 BEGIN
SET
    @newFromDateIndex_2 = (
        SELECT
            top 1 E2.EntryDate
        from
            TbIndicesDetail E2
        WHERE
            E2.IndicesName = @index_2
        order by
            E2.EntryDate ASC
    );

SET
    @cntFromFund_2_index = @index_2;

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_2_index,
        ' from ',
        CONVERT(VARCHAR, @newFromDateIndex_2, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateIndex_2 = CONVERT(DATETIME, @StartDate, 103)
END
SET
    @date_from_1 = DATEDIFF(day, getdate(), @newFromDateIndex_1);

SET
    @date_from_2 = DATEDIFF(day, getdate(), @newFromDateIndex_2);

IF @date_from_1 < @date_from_2 BEGIN
SET
    @final_from_date = @newFromDateIndex_2;

SET
    @final_schemeindexcurrency_name = @cntFromFund_2_index;

END
ELSE BEGIN
SET
    @final_from_date = @newFromDateIndex_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_index;

END
SET
    @cntToIndex_1 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E1
        WHERE
            E1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND E1.IndicesName = @index_1
    );

SET
    @cntToIndex_2 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E2
        WHERE
            E2.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND E2.IndicesName = @index_2
    );

IF @cntToIndex_1 = 0 BEGIN
SET
    @newToDateIndex_1 = (
        SELECT
            top 1 E1.EntryDate
        from
            TbIndicesDetail E1
        WHERE
            E1.IndicesName = @index_1
        order by
            E1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateIndex_1 = CONVERT(DATETIME, @EndDate, 103)
END IF @cntToIndex_2 = 0 BEGIN
SET
    @newToDateIndex_2 = (
        SELECT
            top 1 E2.EntryDate
        from
            TbIndicesDetail E2
        WHERE
            E2.IndicesName = @index_2
        order by
            E2.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateIndex_2 = CONVERT(DATETIME, @EndDate, 103)
END
SET
    @date_to_1 = DATEDIFF(day, getdate(), @newToDateIndex_1);

SET
    @date_to_2 = DATEDIFF(day, getdate(), @newToDateIndex_2);

IF @date_to_1 > @date_to_2 BEGIN
SET
    @final_to_date = @newToDateIndex_2;

END
ELSE BEGIN
SET
    @final_to_date = @newToDateIndex_1;

END
END IF @radio_val = 5 BEGIN
SET
    @cntFromIndex_1 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E1
        WHERE
            E1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND E1.IndicesName = @index_1
    );

SET
    @cntFromCur_1 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F1
        WHERE
            F1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND F1.CurrencyID = @varID
    );

IF @cntFromIndex_1 = 0 BEGIN
SET
    @newFromDateIndex_1 = (
        SELECT
            top 1 E1.EntryDate
        from
            TbIndicesDetail E1
        WHERE
            E1.IndicesName = @index_1
        order by
            E1.EntryDate ASC
    );

SET
    @cntFromFund_1_index = @index_1;

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_1_index,
        ' from ',
        CONVERT(VARCHAR, @newFromDateIndex_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateIndex_1 = CONVERT(DATETIME, @StartDate, 103)
END IF @cntFromCur_1 = 0 BEGIN
SET
    @newFromDateCur_1 = (
        SELECT
            top 1 F1.EntryDate
        from
            TbCurrencyDetail F1
        WHERE
            F1.CurrencyID = @currrency_1
        order by
            F1.EntryDate ASC
    );

SET
    @cntFromFund_1_currency = (
        SELECT
            CurrencyName
        from
            TbCurrencyMaster F1
        WHERE
            F1.CurrencyID = @currrency_1
    );

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_1_currency,
        ' from ',
        CONVERT(VARCHAR, @newFromDateCur_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateCur_1 = CONVERT(DATETIME, @StartDate, 103)
END
SET
    @date_from_1 = DATEDIFF(day, getdate(), @newFromDateIndex_1);

SET
    @date_from_2 = DATEDIFF(day, getdate(), @newFromDateCur_1);

IF @date_from_1 < @date_from_2 BEGIN
SET
    @final_from_date = @newFromDateCur_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_currency;

END
ELSE BEGIN
SET
    @final_from_date = @newFromDateIndex_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_index;

END
SET
    @cntToIndex_1 = (
        SELECT
            count(*)
        from
            TbIndicesDetail E1
        WHERE
            E1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND E1.IndicesName = @index_1
    );

SET
    @cntToCur_1 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F1
        WHERE
            F1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND F1.CurrencyID = @varID
    );

IF @cntToIndex_1 = 0 BEGIN
SET
    @newToDateIndex_1 = (
        SELECT
            top 1 E1.EntryDate
        from
            TbIndicesDetail E1
        WHERE
            E1.IndicesName = @index_1
        order by
            E1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateIndex_1 = CONVERT(DATETIME, @EndDate, 103)
END IF @cntToCur_1 = 0 BEGIN
SET
    @newToDateCur_1 = (
        SELECT
            top 1 F1.EntryDate
        from
            TbCurrencyDetail F1
        WHERE
            F1.CurrencyID = @currrency_1
        order by
            F1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateCur_1 = CONVERT(DATETIME, @EndDate, 103)
END
SET
    @date_to_1 = DATEDIFF(day, getdate(), @newToDateIndex_1);

SET
    @date_to_2 = DATEDIFF(day, getdate(), @newToDateCur_1);

IF @date_to_1 > @date_to_2 BEGIN
SET
    @final_to_date = @newToDateCur_1;

END
ELSE BEGIN
SET
    @final_to_date = @newToDateIndex_1;

END
END IF @radio_val = 6 BEGIN
SET
    @cntFromCur_1 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F1
        WHERE
            F1.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND F1.CurrencyID = @currrency_1
    );

SET
    @cntFromCur_2 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F2
        WHERE
            F2.EntryDate = CONVERT(DATETIME, @StartDate, 103)
            AND F2.CurrencyID = @currrency_2
    );

IF @cntFromCur_1 = 0 BEGIN
SET
    @newFromDateCur_1 = (
        SELECT
            top 1 F1.EntryDate
        from
            TbCurrencyDetail F1
        WHERE
            F1.CurrencyID = @currrency_1
        order by
            F1.EntryDate ASC
    );

SET
    @cntFromFund_1_currency = (
        SELECT
            CurrencyName
        from
            TbCurrencyMaster F1
        WHERE
            F1.CurrencyID = @currrency_1
    );

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_1_currency,
        ' from ',
        CONVERT(VARCHAR, @newFromDateCur_1, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateCur_1 = CONVERT(DATETIME, @StartDate, 103)
END IF @cntFromCur_2 = 0 BEGIN
SET
    @newFromDateCur_2 = (
        SELECT
            top 1 F2.EntryDate
        from
            TbCurrencyDetail F2
        WHERE
            F2.CurrencyID = @currrency_2
        order by
            F2.EntryDate ASC
    );

SET
    @cntFromFund_2_currency = (
        SELECT
            CurrencyName
        from
            TbCurrencyMaster F1
        WHERE
            F1.CurrencyID = @currrency_2
    );

SET
    @final_message = CONCAT(
        'We are taking closing value of ',
        @cntFromFund_2_currency,
        ' from ',
        CONVERT(VARCHAR, @newFromDateCur_2, 103)
    );

SET
    @show_msg = 1;

END
ELSE BEGIN
SET
    @newFromDateCur_2 = CONVERT(DATETIME, @StartDate, 103)
END
SET
    @date_from_1 = DATEDIFF(day, getdate(), @newFromDateCur_1);

SET
    @date_from_2 = DATEDIFF(day, getdate(), @newFromDateCur_2);

IF @date_from_1 < @date_from_2 BEGIN
SET
    @final_from_date = @newFromDateCur_2;

SET
    @final_schemeindexcurrency_name = @cntFromFund_2_currency;

END
ELSE BEGIN
SET
    @final_from_date = @newFromDateCur_1;

SET
    @final_schemeindexcurrency_name = @cntFromFund_1_currency;

END
SET
    @cntToCur_1 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F1
        WHERE
            F1.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND F1.CurrencyID = @currrency_1
    );

SET
    @cntToCur_2 = (
        SELECT
            count(*)
        FROM
            TbCurrencyDetail F2
        WHERE
            F2.EntryDate = CONVERT(DATETIME, @EndDate, 103)
            AND F2.CurrencyID = @currrency_2
    );

IF @cntToCur_1 = 0 BEGIN
SET
    @newToDateCur_1 = (
        SELECT
            top 1 F1.EntryDate
        from
            TbCurrencyDetail F1
        WHERE
            F1.CurrencyID = @currrency_1
        order by
            F1.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateCur_1 = CONVERT(DATETIME, @EndDate, 103)
END IF @cntToCur_2 = 0 BEGIN
SET
    @newToDateCur_2 = (
        SELECT
            top 1 F2.EntryDate
        from
            TbCurrencyDetail F2
        WHERE
            F2.CurrencyID = @currrency_2
        order by
            F2.EntryDate DESC
    );

END
ELSE BEGIN
SET
    @newToDateCur_2 = CONVERT(DATETIME, @EndDate, 103)
END
SET
    @date_to_1 = DATEDIFF(day, getdate(), @newToDateCur_1);

SET
    @date_to_2 = DATEDIFF(day, getdate(), @newToDateCur_2);

IF @date_to_1 > @date_to_2 BEGIN
SET
    @final_to_date = @newToDateCur_2;

END
ELSE BEGIN
SET
    @final_to_date = @newToDateCur_1;

END
END
SELECT
    CONVERT(VARCHAR, @final_from_date, 103) AS 'frm_dt',
    @final_schemeindexcurrency_name AS name,
    @final_message AS final_msg,
    CONVERT(VARCHAR, @final_to_date, 103) AS 'to_dt',
    @show_msg AS show_msg;

END