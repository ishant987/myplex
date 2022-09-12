USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[SpFundHouseGet]    Script Date: 25-02-2022 10:24:42 ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER OFF
GO
ALTER  PROCEDURE [dbo].[SpFundHouseGet]

AS

BEGIN
		SELECT DISTINCT FundHouse from TbFundMaster
		/*Select 
			FundTypeID As FUNDTYPEID
			,TypeName As FUNDTYPE
 From TbFundType Where (@TypeID Is NULL Or FundTypeID = @TypeID)
 ORDER BY TypeName*/
END
