USE [MYPLEXUSDB_70803_COPY]
GO
/****** Object:  StoredProcedure [dbo].[SpFundTypeGet]    Script Date: 25-02-2022 11:13:25 ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER OFF
GO
ALTER  PROCEDURE [dbo].[SpFundTypeGet]

@TypeID BIGINT = NULL

AS

BEGIN

		Select 
			FundTypeID As FUNDTYPEID
			,TypeName As FUNDTYPE
 From TbFundType Where (@TypeID Is NULL Or FundTypeID = @TypeID)
 ORDER BY TypeName
END
