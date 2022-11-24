<?php

namespace App\Lib\Core;

class Useful
{
    public static function strip($str)
    {
        $str = stripslashes($str);

        return $str;
    }

    public static function clearJunk($str)
    {
        $str = addslashes($str);

        return $str;
    }

    public static function isEmail($str)
    {
        if (ereg("^.+@.+\\..+$", $str)) {
            $ret=true;
        } else {
            $ret=false;
        }
        return $ret;
    }

    public static function printR($var, $exit=true)
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";

        if ($exit) {
            exit();
        }
    }

    public static function getFileExtension($localFileName)
    {
        $localFileExt = strrchr($localFileName, ".");
        $localFileExt = strtolower($localFileExt);
        return $localFileExt;
    }

    public static function stripOnlyPTags($text)
    {
        $text = str_ireplace('<p>', '', $text);
        $text = str_ireplace('</p>', '', $text);
        return $text;
    }

    // Generates a strong password of N length containing at least one lower case letter,
    // one uppercase letter, one digit, and one special character. The remaining characters
    // in the password are chosen at random from those four sets.
    //
    // The available characters in each set are user friendly - there are no ambiguous
    // characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
    // makes it much easier for users to manually type or speak their passwords.
    //
    // Note: the $add_dashes option will increase the length of the password by
    // floor(sqrt(N)) characters.
    public static function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false) {
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        }
        if (strpos($available_sets, 'u') !== false) {
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        }
        if (strpos($available_sets, 'd') !== false) {
            $sets[] = '23456789';
        }
        if (strpos($available_sets, 's') !== false) {
            $sets[] = '!@#$%&*?';
        }
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }
        $password = str_shuffle($password);
        if (!$add_dashes) {
            return $password;
        }
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public static function generatePIN($digits = 4)
    {
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while ($i < $digits) {
            //generate a random number between 1 and 9.
            $pin .= mt_rand(1, 9);
            $i++;
        }
        return $pin;
    }

    public static function dateadd($day, $toadd)
    {
        $tmp = explode("-", $day);
        $dadate = mktime(0, 0, 0, $tmp[1], $tmp[0] + ($toadd), $tmp[2]);

        return date('Y-m-d', $dadate);
    }

    public static function dateminus($day, $tominus)
    {
        $tmp = explode("-", $day);
        $newDate = mktime(0, 0, 0, $tmp[1], $tmp[0] - ($tominus), $tmp[2]);

        return date('Y-m-d', $newDate);
    }

    public static function get_yesterday()
    {
        return date("Y-m-d", strtotime("yesterday"));
    }

    public static function get_tomorrow()
    {
        return date("Y-m-d", strtotime("tomorrow"));
    }
    public function getYears($year,$date){
        return date('Y-m-d', strtotime('-'.$year.' year', strtotime($date)));
    }
    public static function get_current_week()
    {
        $monday = strtotime("last monday");
        $monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;
        $sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
        //echo date("Y-m-d",$monday)." - ".date("Y-m-d",$sunday)."<br>";
        $this_week_sd = date("Y-m-d", $monday);
        $this_week_ed = date("Y-m-d", $sunday);

        return array($this_week_sd, $this_week_ed);
    }

    public static function get_current_month()
    {
        $month_sd = date("Y-m-d", strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
        $month_ed = date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'))));

        return array($month_sd, $month_ed);
    }

    public static function get_last_week()
    {
        $monday = strtotime("last monday");
        $monday = date('W', $monday) == date('W') ? $monday - 7 * 86400 : $monday;
        $sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
        //echo date("Y-m-d",$monday)." - ".date("Y-m-d",$sunday)."<br>";
        $last_week_sd = date("Y-m-d", $monday);
        $last_week_ed = date("Y-m-d", $sunday);

        return array($last_week_sd, $last_week_ed);
    }

    public static function get_last_month()
    {
        $last_month_sd = date("Y-m-d", strtotime(date('m', strtotime("last month")) . '/01/' . date('y', strtotime("last month")) . ' 00:00:00'));
        $last_month_ed = date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime(date('m', strtotime("last month")) . '/01/' . date('y', strtotime("last month")) . ' 00:00:00'))));

        return array($last_month_sd, $last_month_ed);
    }
    public static function get_last_month_quatery($s_date,$param)
    {
        $param= $param==0 ? $param : 3;
        $last_month_sd =  date('Y-m-d', strtotime("-".$param." months", strtotime($s_date)));
        $last_month_ed = date("Y-m-t", strtotime($last_month_sd));

        return array($last_month_sd, $last_month_ed);
    }

    public static function get_past_month_date($monthNo=1, $format='Y-m-d H:i:s')
    {
        return date($format, strtotime('-'.$monthNo.' month'));
    }
    
    public static function dateDiff($date1, $date2) {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $seconds_diff = $ts2 - $ts1;

        return floor($seconds_diff / 3600 / 24);
    }

    public static function isHoliday($date) {
        $timestamp = strtotime($date);
        $weekday= date("l", $timestamp );
        $normalized_weekday = strtolower($weekday);
        // return $normalized_weekday ;
        if (($normalized_weekday == "sunday") || ($normalized_weekday == "monday")) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function uniqueRandomNumbersWithinRange($min, $max, $quantity)
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    public static function uniqueRandomString($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    public static function getShortContent($orgStringData, $maxShowChar)
    {
        $descp_length = strlen($orgStringData);
        /*echo $orgStringData."<br>".$descp_length ."--". $maxShowChar."<br>";*/
        if ($descp_length > $maxShowChar) {
            $stringData = substr($orgStringData, 0, strpos($orgStringData, ' ', $maxShowChar)) . " ...";
            if ($stringData == " ...") {
                $stringData = $orgStringData;
            }
        } else {
            $stringData = $orgStringData;
        }
        return $stringData;
    }

    public static function removeSpaceFromNumber($num)
    {
        return preg_replace('/[^0-9]/', '', $num);
    }

    public static function removeSpaceMakeLower($str)
    {
        return strtolower(preg_replace("/\s+/", '', $str));
    }

    public static function hideEmail($email)
    {
        $mail_segments = explode("@", $email);
        $mail_segments[0] = substr($mail_segments[0], 0, 2).str_repeat("*", strlen($mail_segments[0])-2);
        $mail_segments[1] = substr($mail_segments[1], 0, 2).str_repeat("*", strlen($mail_segments[1])-2);

        return implode("@", $mail_segments);
    }

    public static function hidePhone($phone)
    {
        return str_repeat("*", strlen($phone)-4) . substr($phone, -4);
    }
    public static function currencyFormat($number){
        setlocale(LC_MONETARY,"en_IN");
        return money_format('%!i',$number);

    }
}
