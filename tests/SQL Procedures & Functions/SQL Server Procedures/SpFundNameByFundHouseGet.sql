USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[SpFundNameByFundHouseGet]    Script Date: 25-02-2022 10:31:02 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER   PROCEDURE [dbo].[SpFundNameByFundHouseGet]

@FundHouse VARCHAR(255)

AS

BEGIN
	SELECT * FROM  TbFundMaster WHERE FundHouse =@FundHouse Order By NameOfFund

		/*Select 
			FundTermID As FUNDTERMID
			,Term As FUNDTERM
 From TbFundTerm Where (@TermID Is NULL Or FundTermID = @TermID)
 ORDER BY Term*/
END
