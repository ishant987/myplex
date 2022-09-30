<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Useful;
use App\Lib\Core\MailPS;

use App\Models\AdminModel;
use App\Models\User;
use App\Models\UserLike;
use App\Models\AskExpertTopic;
use App\Models\AskExpertQuestion;
use App\Models\UserGroupRelModel;

class AskExpertQuestionAnswer extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'ask_expert_question_answer';

  protected $primaryKey = 'aeqa_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'aeq_id',
    'aet_id',
    'u_id',
    'answer',
    'status',
    'updated_by',
    'updated_id'
  ];

  protected $guarded = [
    'aeqa_id',
  ];


  public function topic()
  {
    return $this->belongsTo(AskExpertTopic::class, 'aet_id', 'aet_id');
  }

  public function question()
  {
    return $this->hasOne(AskExpertQuestion::class, 'aeq_id', 'aeq_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'u_id');
  }

  public function likes()
  {
    $commonconstants = Config('commonconstants');
    return $this->hasMany(UserLike::class, 'data_id', 'aeqa_id')->where('type', $commonconstants['like_type']['value'][1]);
  }

  public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    // \DB::enableQueryLog(); // Enable query log

    $query = AskExpertQuestionAnswer::select($fields)->with(['question' => function ($query) {
      $query->select('aeq_id', 'question', 'u_id', 'aet_id');
    }]);

    $aeqId = isset($filterArr['aeq_id']) ? intval($filterArr['aeq_id']) : 0;
    if ($aeqId > 0) {
      $query->where('aeq_id', '=', $aeqId);
    }

    $aetId = isset($filterArr['aet_id']) ? intval($filterArr['aet_id']) : 0;
    if ($aetId > 0) {
      $query->where('aet_id', '=', $aetId);
    }

    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    $userId = isset($filterArr['u_id']) && $filterArr['u_id'] != '' ? intval($filterArr['u_id']) : 0;
    if ($userId > 0) {
      $query->where('u_id', '=', $userId);
      $query->whereHas('question', function ($query) {
        return $query->where('status', '=', Config('commonconstants.status_val.1'));
      });
    }

    $like_user_id = isset($filterArr['like_u_id']) ? intval($filterArr['like_u_id']) : 0;
    if (isset($filterArr['liked']) && $filterArr['liked'] && $like_user_id > 0) {
      $query->whereHas('likes', function ($query) use ($like_user_id) {
        $query->where('u_id', '=', $like_user_id);
      });
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'aeqa_id';
      $order = 'DESC';
    }

    if (isset($filterArr['group_by'])) {
      $query->groupBy($filterArr['group_by']);
    }

    $query->orderBy($orderBy, $order);
    $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();
    //dd(\DB::getQueryLog()); // Show results of log

    return $dtListArr;
  }

  public static function getData($filterArr = [], $fields = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }
    $query = AskExpertQuestionAnswer::select($fields);

    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    $dataId = isset($filterArr['aeqa_id']) ? intval($filterArr['aeqa_id']) : 0;
    if ($dataId > 0) {
      $query->where('aeqa_id', '=', $dataId);
    }

    $userId = isset($filterArr['u_id']) ? intval($filterArr['u_id']) : 0;
    if ($userId > 0) {
      $query->where('u_id', '=', $userId);
    }

    return $query->first();
  }

  public function sendMailToQuestionUser($question, $authUsr)
  {
    /*Send email to ask question user*/
    $mailPSObj = new MailPS();
    $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

    $email = $question->user->email;
    $mailArr = ["fullname" => rtrim($question->user->f_name . " " . $question->user->l_name), "email" => $email, "question" => Useful::getShortContent(strip_tags($question->question), 60), "ans_user_name" => rtrim($authUsr['f_name'] . " " . $authUsr['l_name'])];

    /*echo "<pre>";
        print_r($mailArr);
        echo "</pre>";
        die();*/

    $aeLang = __('askexpert');

    $subject    = $aeLang['mail']['answer']['subject'];
    $content    = view('emails.web.to-user-answer', compact('mailArr', 'mailCssAtr'));
    $fromName   = $aeLang['mail']['from_name'];

    $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);

    return $mailResp;
  }


  /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

  public static function statusArr()
  {
    return __('askexpert.answer.status');
  }

  public static function getModuleVars()
  {
    $commonconstants = Config('commonconstants');

    return ["cu_by_val" => $commonconstants['cu_by_val'], "cu_by_txt" => __('common.cu_by_txt'), "view_txt" => __('admin.view_txt'), "status" => self::statusArr(), "target" => $commonconstants['target_opt1'], "descp_char_lngth" => Config('adminconstants.descp_char_lngth')];
  }

  public function updatedby()
  {
    return $this->belongsTo(AdminModel::class, 'updated_id');
  }

  public function updatedbyuser()
  {
    return $this->belongsTo(User::class, 'updated_id');
  }

  public function addedbyuser()
  {
    return $this->belongsTo(User::class, 'u_id');
  }

  public function medium()
  {
    return $this->medium != '' ? Config('commonconstants.medium.text.' . $this->medium) : '';
  }

  public function scopeSearch($query, $fltrDataArr)
  {
    if (empty($fltrDataArr)) {
      return $query;
    } else {
      $aeq_id = $fltrDataArr['aeq_id'] ?? '';
      if ($aeq_id) {
        $query->where('ask_expert_question_answer.aeq_id', '=', $aeq_id);
      }

      $answer = $fltrDataArr['answer'] ?? '';
      if ($answer) {
        $query->where('ask_expert_question_answer.answer', 'LIKE', "%{$answer}%");
      }

      $medium = $fltrDataArr['medium'] ?? '';
      if ($medium) {
        $query->where('ask_expert_question_answer.medium', '=', $medium);
      }

      $status = $fltrDataArr['status'] ?? '';
      if ($status != "") {
        $query->where('ask_expert_question_answer.status', '=', $status);
      }

      $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

      $createdAt = $fltrDataArr['created_at'] ?? '';
      if ($createdAt) {
        $createdAtArr = explode(" - ", $createdAt);
        if (!empty($createdAtArr)) {
          $uaStartDate = date($dbDtFrmt, strtotime($createdAtArr[0])) . ' 00:00:00';
          $uaEndDate = date($dbDtFrmt, strtotime($createdAtArr[1])) . ' 23:59:59';
        }
        $query->whereBetween('ask_expert_question_answer.created_at', [$uaStartDate, $uaEndDate]);
      }

      $createdUser = $fltrDataArr['created_user'] ?? '';
      if ($createdUser) {
        $query->whereHas('addedbyuser', function ($q) use ($createdUser) {
          $q->where('f_name', 'LIKE', '%' . $createdUser . '%')->orWhere('l_name', 'LIKE', '%' . $createdUser . '%');
        });
      }

      $updatedAt = $fltrDataArr['updated_at'] ?? '';
      if ($updatedAt) {
        $updatedAtArr = explode(" - ", $updatedAt);
        if (!empty($updatedAtArr)) {
          $uaStartDate = date($dbDtFrmt, strtotime($updatedAtArr[0])) . ' 00:00:00';
          $uaEndDate = date($dbDtFrmt, strtotime($updatedAtArr[1])) . ' 23:59:59';
        }
        $query->whereBetween('ask_expert_question_answer.updated_at', [$uaStartDate, $uaEndDate]);
      }

      $updatedBy = $fltrDataArr['updated_by'] ?? '';
      if ($updatedBy) {
        $query->where('ask_expert_question_answer.updated_by', '=', $updatedBy);
      }
      //echo $query->toSql();exit;
      return $query;
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

  public function isExpertUser()
  {
    $res = false;
    $commonconstants = Config('commonconstants');
    if ($this->user->groups() != null) {
      if ($this->user->groups->where('u_g_id', $commonconstants['expert_group_id'])->count() > 0) {
        $res = true;
      }
    }
    return $res;
  }

  public function getIsExpertUserAttribute()
  {
    $res = false;
    $commonconstants = Config('commonconstants');
    $user = User::find($this->user->u_id);
    if ($user->groups->where('u_g_id', $commonconstants['expert_group_id'])->count() > 0) {
      $res = true;
    }
    return $res;
  }

  public function getLikes()
  {
    $commonconstants = Config('commonconstants');

    return UserLike::getLikeCount($commonconstants['like_type']['value'][1], $this->aeqa_id);
  }

  public function getLikeCountAttribute()
  {
    $commonconstants = Config('commonconstants');

    return UserLike::getLikeCount($commonconstants['like_type']['value'][1], $this->aeqa_id);
  }

  public function getHumanTimeAttribute()
  {
    return \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
  }

  public function isLike()
  {
    $commonconstants = Config('commonconstants');

    return (\Auth::user() && UserLike::getLikeCount($commonconstants['like_type']['value'][1], $this->aeqa_id, \Auth::user()->u_id)) ? true : false;
  }

  public function getIsLikedAttribute()
  {
    $commonconstants = Config('commonconstants');

    return (\Auth::user() && UserLike::getLikeCount($commonconstants['like_type']['value'][1], $this->aeqa_id, \Auth::user()->u_id)) ? true : false;
  }

  public function getDateAttribute()
  {
    $commonconstants = Config('commonconstants');
    return \Carbon\Carbon::parse($this->created_at)->format($commonconstants['dt_frmt']);
  }

  public function getQstnLikes()
  {
    $commonconstants = Config('commonconstants');

    return UserLike::getLikeCount($commonconstants['like_type']['value'][0], $this->aeq_id);
  }

  public function isQstnLike()
  {
    $commonconstants = Config('commonconstants');

    return (\Auth::user() && UserLike::getLikeCount($commonconstants['like_type']['value'][0], $this->aeq_id, \Auth::user()->u_id)) ? true : false;
  }

  public static function getAnswerCount($fltrArr = [])
  {
    $query = AskExpertQuestionAnswer::select('aeqa_id');
    $aeqId = isset($fltrArr['aeq_id']) ? intval($fltrArr['aeq_id']) : 0;
    if ($aeqId > 0) {
      $query->where('aeq_id', '=', $aeqId);
    }
    $userId = isset($fltrArr['u_id']) ? intval($fltrArr['u_id']) : 0;
    if ($userId > 0) {
      $query->where('u_id', '=', $userId);
    }
    $status = isset($fltrArr['status']) ? intval($fltrArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }
    return $query->count();
  }

  public static function isUserExpert($userId)
  {
    $dataArr = UserGroupRelModel::getUserGroupRelData2($userId, Config('commonconstants.expert_group_id'), 'u_g_r_id');
    if ($dataArr) {
      return true;
    }

    return false;
  }
}
