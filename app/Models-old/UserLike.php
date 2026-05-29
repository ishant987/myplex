<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

use App\Models\User;

class UserLike extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_like';

    protected $primaryKey = 'u_lk_id';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'data_id',
        'u_id',
        'created_at',
    ];

    protected $guarded = [
        'u_lk_id',
    ];


    public function likeUsers()
    {
        return $this->hasOne(User::class, 'u_id', 'u_id')->select(['u_id', 'f_name', 'l_name']);
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public static function listAdmin($filterArr = false, $orderBy = false, $order = false, $perPage = false)
    {
        $dbPrfx = DB::getTablePrefix();

        $query = UserLike::select('user_like.u_lk_id', 'user_like.data_id', 'user_like.u_id', 'user_like.type', 'user_like.medium', 'user_like.created_at', DB::raw('(CASE WHEN ' . $dbPrfx . 'user_like.type=\'ae\' THEN ' . $dbPrfx . 'ask_expert_question.question WHEN ' . $dbPrfx . 'user_like.type=\'aea\' THEN ' . $dbPrfx . 'ask_expert_question_answer.answer END) AS title'), DB::raw('(CASE WHEN ' . $dbPrfx . 'user_like.type=\'ae\' THEN \'admin.question.edit\' WHEN ' . $dbPrfx . 'user_like.type=\'aea\' THEN \'admin.answer.edit\' END) AS data_url'))
            ->leftJoin('ask_expert_question', function ($join) {
                $join->on('ask_expert_question.aeq_id', '=', 'user_like.data_id');
                $join->where('user_like.type', '=', 'ae');
            })
            ->leftJoin('ask_expert_question_answer', function ($join) {
                $join->on('ask_expert_question_answer.aeqa_id', '=', 'user_like.data_id');
                $join->where('user_like.type', '=', 'aea');
            });

        $title = $filterArr['title'] ?? '';
        if ($title) {
            $query->orWhere('ask_expert_question.question', 'LIKE', '%' . $title . '%');
            $query->orWhere('ask_expert_question_answer.answer', 'LIKE', '%' . $title . '%');
        }

        $fName = $filterArr['f_name'] ?? '';
        if ($fName) {
            $query->whereHas('likeUsers', function ($q) use ($fName) {
                $q->where('f_name', 'LIKE', '%' . $fName . '%');
            });
        }

        $lName = $filterArr['l_name'] ?? '';
        if ($lName) {
            $query->whereHas('likeUsers', function ($q) use ($lName) {
                $q->where('l_name', 'LIKE', '%' . $lName . '%');
            });
        }

        $type = $filterArr['type'] ?? '';
        if ($type) {
            $query->where('type', '=', $type);
        }

        $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

        $createdAt = $filterArr['created_at'] ?? '';
        if ($createdAt) {
            $createdAtArr = explode(" - ", $createdAt);
            if (!empty($createdAtArr)) {
                $caStartDate = date($dbDtFrmt, strtotime($createdAtArr[0])) . ' 00:00:00';
                $caEndDate = date($dbDtFrmt, strtotime($createdAtArr[1])) . ' 23:59:59';
            }
            $query->whereBetween('user_like.created_at', [$caStartDate, $caEndDate]);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'user_like.created_at';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public static function getTypeAtr()
    {
        $type = Config('commonconstants.like_type');
        $value = $type['value'];
        $text = $type['text'];

        $opt0 = $value['0'];
        $opt1 = $value['1'];
        return [$opt0 => $text[$opt0], $opt1 => $text[$opt1]];
    }


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

    public static function getLikeCount($type = false, $dataId = 0, $userId = 0)
    {
        $query = UserLike::select('u_lk_id');
        if ($type != '') {
            $query->where('type', '=', $type);
        }
        if ($dataId > 0) {
            $query->where('data_id', '=', $dataId);
        }
        if ($userId > 0) {
            $query->where('u_id', '=', $userId);
        }
        return $query->count();
    }

    public static function listFront($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = UserLike::select($fields);

        $u_id = isset($filterArr['u_id']) ? intval($filterArr['u_id']) : 0;
        if ($u_id > 0) {
            $query->where('u_id', '=', $u_id);
        }

        $dataId = isset($filterArr['data_id']) ? intval($filterArr['data_id']) : 0;
        if ($dataId > 0) {
            $query->where('data_id', '=', $dataId);
        }

        if (isset($filterArr['type'])) {
            $query->where('type', '=', $filterArr['type']);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'created_at';
            $order = 'DESC';
        }

        $query->orderBy($orderBy, $order);
        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public static function getUserLikeIds($userId, $type = false)
    {
        $results = [];
        if ($type) {
            $where = ['u_id' => $userId, 'type' => $type];
        } else {
            $where = ['u_id' => $userId];
        }
        $dataObj = UserLike::select('data_id')->where($where)->get();

        if ($dataObj) {
            $results = $dataObj->toArray();
        }

        return $results;
    }
}
