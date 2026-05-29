<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getNameTable')) {
    function getNameTable($table_name, $field_name, $key_name, $value)
    {
        return DB::table($table_name)->where($key_name, $value)->value($field_name);
    }
    function getNameTableMultiple($table_name, $field_name, $key_name, $value, $key2, $value2)
    {
        return DB::table($table_name)->where($key_name, $value)->where($key2, $value2)->value($field_name);
    }
}

if (!function_exists('printValue')) {
    function printValue($value)
    {
        return is_numeric($value) ? number_format($value, 2) : ' ';
    }
}

if (!function_exists('printRank')) {
    function printRank($value)
    {
        // return $value;
        return is_numeric($value) ? $value : ' ';
    }
}

if (!function_exists('printNoData')) {
    function printNoData()
    {
        return '<div class="graph_section">
                            <p style="text-align: center;">Please search with your desired input to view the information</p>
                        </div>';
    }
}

if(!function_exists('getAmountbyfund')){
    function getAmountbyfund($fund_code, $content_per, $month, $year){
        if(strlen($month)==1){
            $month_format = '0'.$month;
        }
        $yearMonth = $year.'-'.$month_format;
        // dd($yearMonth);
        $aaum_in_lakhs = DB::table('corpus_entry')->where('fund_code', $fund_code)->where('entry_date', 'like', $yearMonth . '%')->value('corpus_entry');
        $aaum_in_crores = $aaum_in_lakhs / 100;
        $amount = ($aaum_in_crores * $content_per) / 100;
        return number_format($amount,2);
    }
}

// if(!function_exists('get_ordering')){
//     function get_ordering($risk_ratio,$fundReturns){

//         // dd($risk_ratio,$fundReturns);

//         $ratio_array = ['beta','volatility','tracking_error'];

//         if(isset($risk_ratio) && isset($fundReturns)){

//             if(in_array($risk_ratio,$ratio_array)){

//                 $sorted_array =  asort($fundReturns);
    
//             }else{
//                 $sorted_array = arsort($fundReturns);
//             }
//         }

//         dd($sorted_array);

//      return $sorted_array;

//     }
// }

function custom_sort($array, $order = 'asc') {
    // Separate numerical and 'N/A' values
    $numeric_values = [];
    $na_values = [];
    
    foreach ($array as $key => $value) {
        if ($value !== "N/A") {
            $numeric_values[$key] = $value;
        } else {
            $na_values[$key] = $value;
        }
    }

    // Sort numerical values
    if ($order === 'asc') {
        asort($numeric_values);
    } else {
        arsort($numeric_values);
    }

    // Combine arrays while preserving keys
    return $numeric_values + $na_values;
}



function calculateRSquared(array $x, array $y): float
{
    $n = count($x);

    if ($n !== count($y) || $n < 2) {
        return 0;
    }

    $meanX = array_sum($x) / $n;
    $meanY = array_sum($y) / $n;

    $covariance = 0;
    $varX = 0;
    $varY = 0;

    for ($i = 0; $i < $n; $i++) {
        $dx = $x[$i] - $meanX;
        $dy = $y[$i] - $meanY;

        $covariance += $dx * $dy;
        $varX += $dx * $dx;
        $varY += $dy * $dy;
    }

    if ($varX == 0 || $varY == 0) {
        return 0;
    }

    // Pearson correlation
    $r = $covariance / sqrt($varX * $varY);

    // R²
    return $r * $r;
}