USE [MYPLEXUSDB_70803_COPY]
GO
  /****** Object:  StoredProcedure [dbo].[Sp_SIPCalcWithNAV]    Script Date: 25-02-2022 12:57:14 ******/
SET
  ANSI_NULLS ON
GO
SET
  QUOTED_IDENTIFIER ON
GO
  ALTER PROCEDURE [dbo].[Sp_SIPCalcWithNAV] @Duration INT,
  @FundCode NVARCHAR(50),
  @MonthlySIP float,
  @SIPDayOfMonth INT --,@SIPReturn float    
  AS BEGIN
SET
  NOCOUNT ON;

DECLARE @EntryDate DATE,
@ClosingNav DECIMAL(10, 2),
@N_UNIT DECIMAL(10, 2),
@LatestNav DECIMAL(10, 2),
@TOT_UNITS DECIMAL(10, 2),
@CURRENT_VALUE DECIMAL(10, 2),
@LatestDate DATE,
@ALLVALUES VARCHAR(2000),
@ALLDATES VARCHAR(2000),
@ALLNAVS VARCHAR(2000),
@ALLUNITS VARCHAR(2000),
@CUR_DATE VARCHAR(10),
@yr varchar(4),
@mn varchar(2) DECLARE @Counter INT
SET
  @Counter = 1;

SET
  @ALLVALUES = '[';

SET
  @ALLDATES = '[';

SET
  @TOT_UNITS = 0.00;

SET
  @CURRENT_VALUE = 0.00;

SET
  @N_UNIT = 0.00;

SET
  @ALLNAVS = '[';

SET
  @ALLUNITS = '[';

SELECT
  @yr = YEAR(GETDATE());

SELECT
  @mn = MONTH(GETDATE());

IF @SIPDayOfMonth = 31 BEGIN IF @mn = 4
or @mn = 6
or @mn = 9
or @mn = 11
SET
  @SIPDayOfMonth = 30;

ELSE IF @mn = 2
SET
  @SIPDayOfMonth = 28;

END
SET
  @CUR_DATE = @yr + '/' + @mn + '/' + CAST(@SIPDayOfMonth AS VARCHAR(2));

-- SELECT CAST(@CUR_DATE AS datetime); 
WHILE (@Counter <= @Duration) BEGIN
select
  @EntryDate = EntryDate,
  @ClosingNav = ClosingNav
from
  TbFundDetail
where
  fundcode = @FundCode
  and EntryDate =(
    SELECT
      DATEADD(MONTH, - @Counter, @CUR_DATE)
  );

SELECT
  @N_UNIT =(@MonthlySIP / @ClosingNav);

SET
  @ALLVALUES = CONCAT(@ALLVALUES, ',', CONVERT(varchar, @MonthlySIP * -1));

SET
  @ALLDATES = CONCAT(
    @ALLDATES,
    ',',
    '"',
    CONVERT(varchar(10), FORMAT(@EntryDate, 'MM-dd-yyyy')),
    '"'
  );

SET
  @ALLNAVS = CONCAT(@ALLNAVS, ',', CONVERT(varchar, @ClosingNav));

SET
  @ALLUNITS = CONCAT(@ALLUNITS, ',', CONVERT(varchar, @N_UNIT));

SET
  @TOT_UNITS = @TOT_UNITS + @N_UNIT;

SET
  @N_UNIT = 0.00;

SET
  @Counter = @Counter + 1
END
select
  @LatestNav = ClosingNav,
  @LatestDate = EntryDate
from
  TbFundDetail
where
  fundcode = @FundCode
  and EntryDate =(
    SELECT
      max(EntryDate)
    from
      TbFundDetail
    where
      fundcode = @FundCode
  );

SET
  @CURRENT_VALUE = @TOT_UNITS * @LatestNav;

SET
  @ALLVALUES = CONCAT(@ALLVALUES, ',', CONVERT(varchar, @CURRENT_VALUE));

SET
  @ALLDATES = CONCAT(
    @ALLDATES,
    ',"',
    CONVERT(varchar(10), FORMAT(@LatestDate, 'MM-dd-yyyy'))
  );

SET
  @ALLUNITS = CONCAT(@ALLUNITS, ',', CONVERT(varchar, @TOT_UNITS));

SET
  @ALLNAVS = CONCAT(@ALLNAVS, ',', CONVERT(varchar, @LatestNav));

SET
  @ALLVALUES = CONCAT(@ALLVALUES, ']');

SET
  @ALLDATES = CONCAT(@ALLDATES, '"]');

SET
  @ALLNAVS = CONCAT(@ALLNAVS, ']');

SET
  @ALLUNITS = CONCAT(@ALLUNITS, ']');

select
  STUFF(@ALLUNITS, 2, 1, '') as 'ALLUNITS',
  STUFF(@ALLNAVS, 2, 1, '') as 'ALLNAVS',
  STUFF(@ALLVALUES, 2, 1, '') as 'ALLVALUES',
  STUFF(@ALLDATES, 2, 1, '') as 'ALLDATES',
  @CURRENT_VALUE as 'CURRENTVALUE',
  @MonthlySIP * @Duration as 'INVESTEDAMT';

END