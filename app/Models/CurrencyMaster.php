<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\CurrencyCor;

class CurrencyMaster extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currency_master';

    protected $primaryKey = 'cm_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'cm_id',
    ];


    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = CurrencyMaster::select($fields);

        $name = isset($filterArr['name']) ? $filterArr['name'] : '';
        if ($name != '') {
            $query->where('name', '=', $name);
        }

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'cm_id';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public static function getData($filterArr = false, $fields = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = CurrencyMaster::select($fields);

        $currency_id = isset($filterArr['currency_id']) ? intval($filterArr['currency_id']) : 0;
        if ($currency_id > 0) {
            $query->where('cm_id', '=', $currency_id);
        }
        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        return $query->get()->first();
    }

    public function currencycor()
    {
        return $this->hasOne(CurrencyCor::class, 'cm_id', 'cm_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function updatedby()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    public static function _getHTML($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        return curl_exec($curl);
    }

    public static function parseUrl($url)
    {
        $url = explode("/", $url);
        return $url[2];
    }

    public static function importCurrencyVal($url)
    {
        $page = self::_getHTML($url);
        $page_url = self::parseUrl($url);
        switch ($page_url) {
            case "www.moneycontrol.com":
                preg_match("/<span class=\"rd_30\">[^0-9]*([0-9.,]*)[^0-9]*<\/span>/i", $page, $match);
                if (isset($match[1])) {
                    return round(floatval(preg_replace("/[^0-9.]/", "", $match[1])), 2);
                    // return round(floatval($match[2]),2);
                } else {
                    return '';
                }
                break;
            case "profit.ndtv.com":
                preg_match("/<td class=\"txt-right\">[^0-9]*([0-9.,]*)[^0-9]*<\/td>/i", $page, $match);
                if (isset($match[1])) {
                    return round(floatval(preg_replace("/[^0-9.]/", "", $match[1])), 2);
                } else {
                    return '';
                }
                break;
            case "in.investing.com":
                preg_match("/<span class=\"arial_26 inlineblock pid-[^0-9]*([0-9.,]*)[^0-9]*-last\" id=\"last_last\" dir=\"ltr\">[^0-9]*([0-9.,]*)[^0-9]*<\/span>/i", $page, $match);
                if (isset($match[2])) {
                    // $match = round(floatval(preg_replace("/[^0-9.]/", "",$match[2] )), 2); 
                    return round(floatval($match[2]), 2);
                } else {
                    return '';
                }
                break;
            case "www.exchangerates.org.uk":
                preg_match("/<span id=\"shd2b;\">[^0-9]*([0-9.,]*)[^0-9]*<\/span>/i", $page, $match);
                if (isset($match[1])) {
                    $match2 = round(floatval(preg_replace("/[^0-9.]/", "", $match[1])), 2);
                    return round(floatval($match2), 2);
                } else {
                    return '';
                }
                break;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */
}
