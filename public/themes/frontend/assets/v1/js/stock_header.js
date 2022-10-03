   const url_list =[
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/TIS',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/ONG',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/AE13',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/HDF01',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/BAF',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/KMB',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/AP31',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/HU',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/SPI',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/TM4',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/RI',
    'https://priceapi.moneycontrol.com/pricefeed/nse/equitycash/SBI',
    'https://priceapi.moneycontrol.com/pricefeed/notapplicable/inidicesindia/in%3BNSX',
    'https://priceapi.moneycontrol.com/pricefeed/notapplicable/indicesglobal/gb%3BFTSE',
    'https://priceapi.moneycontrol.com/pricefeed/mcx/commodityfuture/GOLD?expiry=05OCT2022',
    'https://priceapi.moneycontrol.com/pricefeed/mcx/commodityfuture/COPPER?expiry=31OCT2022',
    'https://priceapi.moneycontrol.com/pricefeed/mcx/commodityfuture/SILVER?expiry=05DEC2022'
   ];
   $.each(url_list,function(key,val){
    $.ajax({
        url: val,
        type: "GET",
        dataType: 'json',
        cache: true,
        success: function(result) {

            if (result.code == 200) {
                updateHtml(result)
            }

        }
    });
   });
    function updateHtml(result){
      if (result.data.ty == 4) {
                    var exdt = result.data.expirydate;
                    var date = new Date(exdt);
                    var daynm = date.toDateString();
                    var parts = daynm.split(" ");
                    var dt = parts[2] + parts[1] + parts[3];
                    symb = result.data.symbol;
                    stkname = result.data.company + ' ' + dt;
                } else {
                    symb = result.data.symbol;
                    stkname = result.data.company;
                }
                var chgchk = parseFloat(result.data.pricechange);
                if (chgchk < 0) {
                    arr = 'down_trade';
                    arr1 = 'ph-caret-down-fill';
                }else{
                  arr = 'up_trade';
                    arr1 = 'ph-caret-up-fill';
                }
                var link = '#';

                var perchg = parseFloat(result.data.pricepercentchange);
                perchg = perchg.toFixed(2);
                if (perchg > 0)
                    perchg = '+' + perchg;

                var stackhtml =  '<div class="single_trade_info">' + stkname +' '+ result.data.pricecurrent + '<span class="' + arr +
                    '"><i class="' + arr1 + '"></i>'+ perchg +'</span> </div>';
                $(".trade_details_result").slick('slickAdd',stackhtml);
    }