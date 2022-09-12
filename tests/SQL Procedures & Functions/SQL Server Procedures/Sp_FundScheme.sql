USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[Sp_FundScheme]    Script Date: 28-02-2022 14:39:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[Sp_FundScheme]

@FLAG VARCHAR(100),
@SearchCode	VARCHAR(500)

AS
		
BEGIN

IF UPPER(@FLAG)='BY_CLASSIFICATION'
BEGIN

SELECT M.NameOfFund, M.FundManager, convert(varchar(10),OpDate,103) OpDate ,
	M.Facevalue, M.RiskFreeReturn,M.IndicesName,M.Classification , Classification TypeName,T.Term 
	FROM TbFundMaster M 	
	INNER JOIN TbFundTerm T ON M.FundTermID = T.FundTermID
	WHERE M.Classification = @SearchCode	
	Order By M.NameOfFund
	
END		

ELSE IF UPPER(@FLAG)='BY_FUNDHOUSE'
BEGIN	
	SELECT M.NameOfFund, M.FundManager, convert(varchar(10),OpDate,103) OpDate ,
		M.Facevalue, M.RiskFreeReturn,M.IndicesName,M.Classification , Classification TypeName,T.Term 
		FROM TbFundMaster M 	
	INNER JOIN TbFundTerm T ON M.FundTermID = T.FundTermID
		WHERE M.FundHouse =@SearchCode
	
	Order By M.NameOfFund
END
	



END
