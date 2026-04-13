<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminModel;
use App\Models\MediaModel;
use App\Models\User;
use App\Models\AskExpertQuestion;

class AskExpertTopic extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ask_expert_topic';

    protected $primaryKey = 'aet_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'media_id',
        'c_order',
        'parent',
        'status',
        'created_medium',
        'created_by',
        'created_id',
        'updated_id'
    ];

    protected $guarded = [
        'aet_id',
    ];


    public function media()
    {
        return $this->hasOne(MediaModel::class, 'media_id', 'media_id');
    }

    public function questions()
    {
        return $this->hasMany(AskExpertQuestion::class, 'aet_id', 'aet_id');
    }

    public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = AskExpertTopic::select($fields);

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if (isset($filterArr['parent'])) {
            $query->where('parent', '=', $filterArr['parent']);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'aet_id';
            $order = 'DESC';
        }
        $query->orderBy($orderBy, $order);
        $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();
        return $dtListArr;
    }

    public static function getData($dataId = 0, $status = 0, $fields = false, $slug = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }
        $query = AskExpertTopic::with(['media', 'questions'])->select($fields);

        if ($status > 0) {
            $where = ['status' => $status];
            $query->where($where);
        }
        if ($dataId > 0) {
            $where = ['aet_id' => $dataId];
        }
        if ($slug != false) {
            $where = ['slug' => $slug];
        }
        return $query->where($where)->first();
    }

    public static function getTopicList($filterArr = false, $orderBy = false, $order = false)
    {
        $query = new AskExpertTopic;

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 1;

        $parent = 0;
        if (isset($filterArr['parent'])) {
            $parent = $filterArr['parent'];
        }
        if ($orderBy == false && $order == false) {
            $orderBy = 'aet_id';
            $order = 'DESC';
        }
        return $query->where('parent', '=', $parent)->where('status', '=', $status)->orderBy($orderBy, $order)->pluck('title', 'aet_id')->toArray();
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

    public function updatedbyadmin()
    {
        return $this->belongsTo(AdminModel::class, 'updated_id');
    }

    public function addedby()
    {
        return $this->belongsTo(AdminModel::class, 'created_id');
    }

    public function addedbyuser()
    {
        return $this->belongsTo(User::class, 'created_id');
    }

    public function parentdata()
    {
        return $this->hasOne(AskExpertTopic::class, 'aet_id', 'parent');
    }

    public static function getParentDataList()
    {
        return AskExpertTopic::pluck('title', 'aet_id')->toArray();
    }

    public function medium()
    {
        return $this->created_medium != '' ? Config('commonconstants.medium.text.' . $this->created_medium) : '';
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
