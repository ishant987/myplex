<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Snapshot</title>
</head>

<body style="font-family: 'Volte-Semibold'; color: #000;">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
    @font-face {
    font-family: 'Volte-Regular';
    src: url('../fonts/Volte-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Volte-Medium';
    src: url('../fonts/Volte-Medium.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Volte-Semibold';
    src: url('../fonts/Volte-Semibold.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Volte-Bold';
    src: url('../fonts/Volte-Bold.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
table {
    width: 100%;
    border-collapse: collapse;
     
}
.container {
    width: 100%;
    max-width: 96%;
    margin: 0 auto;
}
.half {
    width: 50%;
}
tbody tr:last-child td {
    border-bottom: 0 !important;
}
tbody tr:last-child {
    border-radius: 5px;
}

.table-col {
    justify-content: space-between;
}
.top-banner::after {
    position: absolute;
    content: '';
    top: -10px;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('images/top-layer.png');
    background-repeat: no-repeat;
    background-size: contain;
    z-index: 0;
}
</style>

    <div class="top-banner" style="border-top: 10px solid #6ab130; background-image: url('images/banner-img.jpg'); background-repeat: no-repeat; background-size: cover; padding-bottom: 70px; position: relative;">
        <div class="container">
            <table style="">
                <tbody style="">
                    <tr style="">
                        <td style="">
                            <p style="width: 480px; margin: 0 auto; text-transform: uppercase; font-size: 55px; line-height: 50px; font-family: 'Volte-Bold'; text-align: center; color: #fff; background-color: #6ab130; padding: 35px 30px 0 30px;"><span style="position: relative; z-index: 1;">myplexus.com</span></p>
                            <p style="width: 480px; margin: 0 auto; font-size:28px; text-align: center; color: #fff; background-color: #6ab130; padding: 0px 30px 30px 30px; border-bottom-right-radius: 25px; border-bottom-left-radius: 25px;"><span style="position: relative; z-index: 1;">Search, Research Mutual Funds</span></p>
                        </td>
                    </tr>
                    <tr style=" margin-top: 90px;">
                        <td style="">
                            <p style="text-align: center; font-family: 'Volte-Bold'; font-size: 60px; color: #fff;">Composition Snapshot</p>
                            <p style="text-align: center; color: #6ab130; font-size: 35px;">
                                <span class="title">Fund Title Here -</span>
                                <span class="date">February 2022</span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<table style="margin-bottom: 40px; margin-top: 35px;">
        
        <thead style="" class="container">
            <tr style=" text-align: left;">
                <th style="background-color: #000; color: #509b41; padding: 15px 20px; ">Fund Category</th>
                <th style="background-color: #000; color: #509b41; padding: 15px 20px; ">% Change</th>
                <th style="background-color: #000; color: #509b41; padding: 15px 20px; ">Median</th>
            </tr>
        </thead>
        <tbody style="box-shadow: 2px 8px 15px -6px #0000001f;  border: 1px solid #e7e4e4; border-top: 0; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" class="container">

            <tr style=" background-color:#f7f7fb;">
                <td style=" padding: 15px 20px; border-bottom: 1px solid #000;">ABY Funds Pvt. Ltd.</td>
                <td style=" padding: 15px 20px; border-bottom: 1px solid #000;">20%</td>
                <td style=" padding: 15px 20px; border-bottom: 1px solid #000;">ABY Funds Pvt. Ltd.</td>
            </tr>
            <tr style=" background-color:#f7f7fb;">
                <td style=" padding: 15px 20px; border-bottom: 1px solid #000;">ABY Funds Pvt. Ltd.</td>
                <td style=" padding: 15px 20px; border-bottom: 1px solid #000;">22%</td>
                <td style=" padding: 15px 20px; border-bottom: 1px solid #000;">ABY Funds Pvt. Ltd.</td>
            </tr>
            <tr style=" background-color:#f7f7fb;">
                <td style=" padding: 15px 20px;">ABY Funds Pvt. Ltd.</td>
                <td style=" padding: 15px 20px;">20%</td>
                <td style=" padding: 15px 20px;">ABY Funds Pvt. Ltd.</td>
            </tr>

        </tbody>
    </table>
    

</body>

</html>