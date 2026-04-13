USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[Sp_Fund_Index_Currency]    Script Date: 25-02-2022 12:54:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


ALTER  PROCEDURE [dbo].[Sp_Fund_Index_Currency]

@FLAG VARCHAR(50)=NULL,
@StartDate		VARCHAR(10)=NULL,
@EndDate		VARCHAR(10)=NULL,
@varID		INT=0,
@varName		NVARCHAR(100)=NULL,
@fundcode1 NVARCHAR(200)=NULL,
@fundcode2 NVARCHAR(200)=NULL,
@yearID		INT=0

AS
SET NOCOUNT ON;  
IF UPPER(@FLAG)='GET_FUND'
   BEGIN
		select  FundID,NameOfFund,FundCode from TbFundMaster order by NameOfFund

END		

ELSE IF UPPER(@FLAG)='GET_INDEX'
BEGIN	
	SELECT  * FROM dbo.TbIndicesMaster ORDER BY IndicesName
END
	
ELSE IF UPPER(@FLAG)='GET_CURRENCY'
BEGIN
		SELECT  * FROM TbCurrencyMaster where CurrencyID <>6 order by CurrencyName 
END



----------------------------------

	
ELSE IF UPPER(@FLAG)='GRAPH_INDEX'
BEGIN

	SELECT D.ClosingValue VALUE,D.EntryDate DATE,D.IndicesName NAME
		FROM  TbIndicesDetail D 
	WHERE D.EntryDate>=CONVERT(DATETIME, @StartDate, 103) 
		AND D.EntryDate<=CONVERT(DATETIME, @EndDate, 103)
		AND D.IndicesName=@varName
	ORDER BY 2			

END	

ELSE IF UPPER(@FLAG)='GRAPH_CURRENCY'
BEGIN
		SELECT D.EntryValue VALUE,D.EntryDate DATE,F.CurrencyName NAME
			FROM TbCurrencyMaster F
		INNER JOIN  TbCurrencyDetail D ON F.CurrencyID=D.CurrencyID
		WHERE D.EntryDate>=CONVERT(DATETIME, @StartDate, 103) 
			AND D.EntryDate<=CONVERT(DATETIME, @EndDate, 103)
			AND F.CurrencyID=@varID
		ORDER BY 2
END
	
ELSE IF UPPER(@FLAG)='GRAPH_FUND'
BEGIN
SET NOCOUNT ON;
		SELECT D.ClosingNav VALUE,D.EntryDate DATE,F.NameOfFund NAME,F.FundCode
			FROM TbFundMaster F
		INNER JOIN  TbFundDetail D ON F.FundCode=D.FundCode
		WHERE D.EntryDate>=CONVERT(DATETIME, @StartDate, 103) 
			AND D.EntryDate<=CONVERT(DATETIME, @EndDate, 103)
			AND F.FundCode=@varName
		ORDER BY 2
END	
-------------------------------

ELSE IF UPPER(@FLAG)='GET_CMP_AAUM'
BEGIN

SELECT NameOfFund,CorpusEntry,PercentageChange,CorpusChange 
	FROM dbo.TbCorpusEntry AS t1
        INNER JOIN TbFundMaster AS t2  ON t1.FundCode = t2.FundCode 
WHERE YEAR(EntryDate)=@yearID  AND      month(EntryDate)=@varID           
AND t1.FundCode in (@fundcode1,@fundcode2) 
order by 1

END

ELSE IF UPPER(@FLAG)='GET_BY_FUNDTYPEID'
BEGIN

SELECT NameOfFund,FundCode
	FROM  TbFundMaster 
WHERE FundTypeID =@varID
order by 1

END