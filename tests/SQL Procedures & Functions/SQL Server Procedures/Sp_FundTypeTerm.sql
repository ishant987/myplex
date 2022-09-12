USE [MYPLEXUSDB_70803]
GO
/****** Object:  StoredProcedure [dbo].[Sp_FundTypeTerm]    Script Date: 28-02-2022 14:41:41 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
  
ALTER PROCEDURE [dbo].[Sp_FundTypeTerm]  
  
@FLAG VARCHAR(100)=NULL,  
@TypeID INT=NULL  
  
AS  
    
BEGIN  
SET NOCOUNT ON; 
  
IF UPPER(@FLAG)='GET_FUNDTYPE'  
BEGIN  
  
 Select distinct  T.FundTypeID,T.TypeName    
  From TBFUNDMASTER M  
  INNER JOIN TbFundType T ON M.FundTypeID=T.FundTypeID  
 order by TypeName  
   
END    
  
ELSE IF UPPER(@FLAG)='GET_FUNDTERM'  
BEGIN   
 Select top 1  T.FundTermID,T.Term    
   From TBFUNDMASTER M  
   INNER JOIN TbFundTerm T ON M.FundTermID=T.FundTermID  
     where FundTypeID =@TypeID  
END  
   
  
  
  
END  