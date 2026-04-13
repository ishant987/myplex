<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use App\Lib\Core\Core;
use App\Lib\Admin\App;
use App\Lib\Core\MailPS;

use App\Models\UserGroupModel;
use App\Models\UserGroupRelModel;
use App\Models\AdminModel;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'u_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_code',
        'acc_type',
        's_acc_medium',
        's_account',
        'f_name',
        'l_name',
        'email',
        'password',
        'forget_code',
        'mobile',
        'birthday',
        'p_picture',
        'pincode',
        'address',
        'about',
        'profile',
        'company',
        'status',
        'is_approved',
        'note',
        'created_by',
        'created_id',
        'updated_by',
        'updated_id',
        'contact_person',
        'city',
        'state',
        'gst',
        'arn',
        'pan',
        'subscription_expiry_date',
    ];

    protected $guarded = [
        'u_id',
    ];


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (!isset($model->u_id) && $model->u_id == 0) {
                $model->u_code = IdGenerator::generate(['table' => env('DB_PREFIX') . $model->table, 'field' => 'u_code', 'length' => 8, 'prefix' => 'U']);
            }
        });
    }

    public static function days()
    {
        $dataArr =  [];
        for ($i = 1; $i <= 31; $i++) {
            $dataArr[$i] = $i;
        }
        return $dataArr;
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

    public static function getUserData($whrData, $fields = false, $whrKey = false)
    {
        if ($fields == false) {
            $fields = addcslashes('CONCAT_WS(" ", f_name, l_name) AS fullname', "'") . ", f_name l_name, email, mobile, birthday, p_picture, pincode";
        }
        if ($whrKey == false) {
            $whrKey = "u_id";
        }

        return User::selectRaw($fields)->where($whrKey, '=', $whrData)->first();
    }

    public function usergrouprel()
    {
        return $this->hasMany(UserGroupRelModel::class, 'u_id', 'u_id');
    }

    public function groups()
    {
        return $this->belongsToMany(UserGroupModel::class, 'user_group_rel', 'u_id', 'u_g_id');
    }

    public static function usersListByGroup($usrGrpId, $fields = false)
    {
        $commonconstants = Config('commonconstants');

        $query = User::with('usergrouprel')->whereHas('usergrouprel', function ($query) use ($usrGrpId) {
            if ($usrGrpId > 0) {
                $query->where('u_g_id', '=', $usrGrpId);
            }
        });

        if ($fields != false) {
            $query->select($fields);
        } else {
            $query->selectRaw("u_id, CONCAT(" . addcslashes('CONCAT_WS(" ", f_name, l_name)', "'") . ", ' (', email, ')') AS fullinfo");
        }

        $query->where(['status' => $commonconstants['status_val'][1], 'is_approved' => $commonconstants['y_n_val'][1]]);

        return $query->get();
    }

    public static function usersList($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
    {
        if ($fields == false) {
            $fields = ['*'];
        }

        $query = User::select($fields);

        if (isset($filterArr['group_ids']) && !empty($filterArr['group_ids'])) {
            $query->where(function ($query) use ($filterArr) {
                $query->whereHas('groups', function ($query) use ($filterArr) {
                    return $query->whereIn('user_group.u_g_id', $filterArr['group_ids'])->where('user_group_rel.deleted_at', '=', Config('commonconstants.null'));
                });
                return $query;
            });
        }

        $search = isset($filterArr['search']) ? $filterArr['search'] : '';
        if ($search != '') {
            $query->where(function ($query) use ($search) {
                $query->whereRaw("concat(f_name, ' ', l_name) like '%" . $search . "%' ");
                return $query;
            });
        }

        $u_id_in = isset($filterArr['u_id_in']) ? $filterArr['u_id_in'] : "";
        if ($u_id_in) {
            $query->whereIn('u_id', $u_id_in);
        }

        $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;

        if ($status > 0) {
            $query->where('status', '=', $status);
        }

        if ($orderBy == false && $order == false) {
            $orderBy = 'f_name';
            $order = 'ASC';
        }
        $query->orderBy($orderBy, $order);
        $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();
        //dd(\DB::getQueryLog()); // Show results of log

        return $dtListArr;
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

    public function addedby()
    {
        return $this->belongsTo(AdminModel::class, 'created_id');
    }

    public function updatedbyuser()
    {
        return $this->belongsTo(User::class, 'updated_id');
    }

    public function addedbyuser()
    {
        return $this->belongsTo(User::class, 'created_id');
    }

    public function getUserClassAttribute()
    {
        $userClassArr = Config('commonconstants.user_class_type.text');
        if ($this->class) {
            return $userClassArr[$this->class];
        }
        return '';
    }

    public function getFullName()
    {
        return $this->f_name . " " . $this->l_name;
    }

    public static function getUserGroupList()
    {
        return UserGroupModel::getUserGroupList()->toArray();
    }

    public static function getModuleVars()
    {
        $commonconstants = Config('commonconstants');
        $authConfig = Config('auth');

        $commonLang = __('common');

        return ["cu_by_val" => $commonconstants['cu_by_val'], "cu_by_txt" => $commonLang['cu_by_txt'], "view_txt" => __('admin.view_txt'), "target" => $commonconstants['target_opt1'], "media_folder" => Core::getUploadedURL($commonconstants['user_dir_name']), "img_width" => Config('adminconstants.image_width'), "y_n_val" => $commonconstants['y_n_val'], "yes_no_txt" => $commonLang['yes_no_txt'], "status" => App::getStatusLblTyp1Atr(), "acc_type" => $authConfig['acc_type'], "s_acc_medium" => $authConfig['s_acc_medium']];
    }

    public function scopeSearch($query, $fltrDataArr)
    {
        if (empty($fltrDataArr)) {
            return $query;
        } else {
            $uCode = $fltrDataArr['u_code'] ?? '';
            if ($uCode) {
                $query->where('u_code', '=', $uCode);
            }
            $fName = $fltrDataArr['f_name'] ?? '';
            if ($fName) {
                $query->where('f_name', 'LIKE', "%{$fName}%");
            }
            $lName = $fltrDataArr['l_name'] ?? '';
            if ($lName) {
                $query->where('l_name', 'LIKE', "%{$lName}%");
            }
            $loginPin = $fltrDataArr['login_pin'] ?? '';
            if ($loginPin) {
                $query->where('login_pin', 'LIKE', "%{$loginPin}%");
            }
            $email = $fltrDataArr['email'] ?? '';
            if ($email) {
                $query->where('email', 'LIKE', "%{$email}%");
            }
            $mobile = $fltrDataArr['mobile'] ?? '';
            if ($mobile) {
                $query->where('mobile', 'LIKE', "%{$mobile}%");
            }
            $status = $fltrDataArr['status'] ?? 0;
            if ($status > 0) {
                $query->where('status', '=', $status);
            }
            $accType = $fltrDataArr['acc_type'] ?? '';
            if ($accType) {
                $query->where('acc_type', '=', $accType);
            }
            $sAccMedium = $fltrDataArr['s_acc_medium'] ?? '';
            if ($sAccMedium) {
                $query->where('s_acc_medium', '=', $sAccMedium);
            }

            $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

            $createdAt = $fltrDataArr['created_at'] ?? '';
            if ($createdAt) {
                $createdAtArr = explode(" - ", $createdAt);
                if (!empty($createdAtArr)) {
                    $caStartDate = date($dbDtFrmt, strtotime($createdAtArr[0])) . ' 00:00:00';
                    $caEndDate = date($dbDtFrmt, strtotime($createdAtArr[1])) . ' 23:59:59';
                }
                $query->whereBetween('created_at', [$caStartDate, $caEndDate]);
            }
            $createdBy = $fltrDataArr['created_by'] ?? '';
            if ($createdBy) {
                $query->where('created_by', '=', $createdBy);
            }
            $updatedAt = $fltrDataArr['updated_at'] ?? '';
            if ($updatedAt) {
                $updatedAtArr = explode(" - ", $updatedAt);
                if (!empty($updatedAtArr)) {
                    $uaStartDate = date($dbDtFrmt, strtotime($updatedAtArr[0])) . ' 00:00:00';
                    $uaEndDate = date($dbDtFrmt, strtotime($updatedAtArr[1])) . ' 23:59:59';
                }
                $query->whereBetween('updated_at', [$uaStartDate, $uaEndDate]);
            }
            $updatedBy = $fltrDataArr['updated_by'] ?? '';
            if ($updatedBy) {
                $query->where('updated_by', '=', $updatedBy);
            }
        }
        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Frontent (API / Website) & CronJob Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for api panel.
    |
    */

    public static function sendResetPasswordCode($user)
    {
        $response = [];
        $authLang = __('auth');

        $mailPSObj = new MailPS();
        $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

        $email = $user->email;
        $fullname = $user->f_name . " " . $user->l_name;
        $mailArr = ["fullname" => rtrim($fullname), "forget_code" => $user->forget_code];

        $subject    = $authLang['su_f_pswd_mail_sbjct'];
        $content    = view('emails.web.to-user-forgot-password', compact('mailArr', 'mailCssAtr'));
        $fromName   = $authLang['su_f_pswd_mail_f_name'];

        $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
        $response['mailResp'] = $mailResp;

        return $response;
    }
}
