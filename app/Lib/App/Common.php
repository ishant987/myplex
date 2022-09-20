<?php

namespace App\Lib\App;

use App\Lib\Core\UsefulSql;
use App\Lib\Core\MailPS;

class Common
{
    public static function getSlug($str, $reqConversion = false)
    {
        $str = strtolower(trim($str));
        if ($reqConversion) {
            $str = str_replace('!', 'not', $str);
            $str = str_replace('@', 'at', $str);
            $str = str_replace('#', 'hash', $str);
            $str = str_replace('$', 'doller', $str);
            $str = str_replace('%', 'percentage', $str);
            $str = str_replace('&', 'and', $str);
            $str = str_replace('*', 'star', $str);
            $str = str_replace('/', 'or', $str);
        } else {
            $str = str_replace('&', '-', $str);
            $str = str_replace('$', '-', $str);
        }

        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        $title = str_replace('-', ' ', $str);
        $titleArr = explode(' ', $title);
        $title = '';
        foreach ($titleArr as $string) {
            if (trim($string) != '') {
                if ($title == '') {
                    $title = $string;
                } else {
                    $title .= '-' . $string;
                }
            }
        }
        $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);

        return $title;
    }

    public static function generateSlug($titleOrSlug, $tableName, $field = '', $updtQry = '', $moreWhrQry = '')
    {
        if ($field == '') {
            $field = 'slug';
        }
        if ($moreWhrQry == '') {
            $moreWhrQry = " " . $moreWhrQry;
        }
        $title = strtolower(trim($titleOrSlug));
        $countNo = 0;
        $reqConversion = false;
        if ($title != '') {
            $title = self::getSlug($title, $reqConversion);
        }
        $slug = '';
        $newTitle = $title;
        $dbPrfx = env('DB_PREFIX','mpx_');

        if ($updtQry) {
            $sqlDuplicateCount = UsefulSql::getData("SELECT COUNT(*) FROM " . $dbPrfx . "" . $tableName . " WHERE " . $field . "='" . $newTitle . "' AND " . $updtQry . " " . $moreWhrQry . "");
            if ($sqlDuplicateCount == 0) {
                return $newTitle;
            }
            $updtQry = ' AND ' . $updtQry;
        }

        while ($slug == '') {
            $sqlCount = UsefulSql::getData("SELECT COUNT(*) FROM " . $dbPrfx . "" . $tableName . " WHERE " . $field . "='" . $newTitle . "' " . $updtQry . " " . $moreWhrQry . "");
            if ($sqlCount > 0) {
                $countNo++;
                $newTitle = $title . $countNo;
            } else {
                $slug = $newTitle;
            }
        }
        return $slug;
    }

    public static function formatAMFIData($data)
    {
        return str_replace(['-', ' ', '(', ')', '.', '/', '\'', '<', '>', '+', '[', ']', '*'], '', $data);
    }

    public static function formattedDBDate($data)
    {
        return date('Y-m-d', strtotime(str_replace('/', '-', $data)));
    }

    public static function months($month_format = "F")
    {
        $dataArr =  [];
        for ($i = 0; $i < 12; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $dataArr[date('n', $timestamp)] = date($month_format, $timestamp);
        }
        ksort($dataArr, SORT_NUMERIC);
        return $dataArr;
    }

    public static function years()
    {
        $min = 2010;
        $max = date('Y');
        $dataArr =  [];
        for ($i = $max; $i >= $min; $i--) {
            $dataArr[$i] = $i;
        }
        return $dataArr;
    }

    public static function getLastDateOfMonth($month, $year)
    {
        $s_date = strtotime($year . '-' . $month . '-1');
        $e_date = strtotime('-1 second', strtotime('+1 month', $s_date));
        return date('Y-m-d', $e_date);
    }

    public static function getPreviousMonthLastDate($month, $year)
    {
        $s_date = strtotime($year . '-' . $month . '-1');
        $e_date = strtotime('-1 day', $s_date);
        return date('Y-m-d', $e_date);
    }

    public static function getPreviousMonthLastDateFrmDate($date)
    {
        $newDate = strtotime('-1 month', strtotime($date));
        return date('Y-m-d', $newDate);
    }

    public static function ampSafeOnUrl($value)
    {
        return str_replace('_', '&', $value);
    }
}
