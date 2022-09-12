<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Lib\Core\Core;
use App\Lib\Core\Useful;

use App\Models\AdminModel;
use App\Models\User;
use App\Models\UserLike;
use App\Models\AskExpertTopic;
use App\Models\AskExpertQuestionAnswer;

class AskExpertQuestion extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'ask_expert_question';

  protected $primaryKey = 'aeq_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'aet_id',
    'question',
    'image1',
    'image2',
    'image3',
    'video_from',
    'video_data',
    'status',
    'u_id',
    'updated_id'
  ];

  protected $guarded = [
    'aeq_id',
  ];


  public function topic()
  {
    return $this->belongsTo(AskExpertTopic::class, 'aet_id', 'aet_id')->select(['aet_id', 'title', 'slug']);
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'u_id', 'u_id')->select('u_id', 'f_name', 'l_name', 'email', 'p_picture');
  }

  public function answers()
  {
    return $this->hasMany(AskExpertQuestionAnswer::class, 'aeq_id', 'aeq_id')->with(['user' => function ($query) {
      $query->select('u_id', 'f_name', 'l_name', 'p_picture');
    }]);
  }

  public static function list($filterArr = false, $fields = false, $orderBy = false, $order = false, $perPage = false)
  {
    // \DB::enableQueryLog(); // Enable query log

    if ($fields == false) {
      $fields = ['*'];
    }
    $commonconstants = Config('commonconstants');

    $query = AskExpertQuestion::with(['topic', 'user'])->select($fields);

    $userId = isset($filterArr['u_id']) && $filterArr['u_id'] != '' ? intval($filterArr['u_id']) : 0;
    if ($userId > 0) {
      $query->where('u_id', '=', $userId);
    }

    $like_user_id = isset($filterArr['like_u_id']) ? intval($filterArr['like_u_id']) : 0;
    if (isset($filterArr['liked']) && $filterArr['liked'] && $like_user_id > 0) {
      $query->whereHas('likes', function ($query) use ($like_user_id) {
        $query->where('u_id', '=', $like_user_id);
      });
    }

    $like_answer_user_id = isset($filterArr['like_answer_u_id']) ? intval($filterArr['like_answer_u_id']) : 0;
    if (isset($filterArr['liked_answer']) && $filterArr['liked_answer'] && $like_answer_user_id > 0) {

      $query->whereHas('answers', function ($query) use ($like_answer_user_id, $commonconstants) {
        $query->whereHas('likes', function ($query) use ($like_answer_user_id, $commonconstants) {
          $query->where('u_id', '=', $like_answer_user_id);
        });
      });
    }

    $answer_user_id = isset($filterArr['answer_u_id']) ? intval($filterArr['answer_u_id']) : 0;
    if (isset($filterArr['answered']) && $filterArr['answered'] && $answer_user_id > 0) {

      $query->whereHas('answers', function ($query) use ($answer_user_id, $commonconstants) {
        $query->where('u_id', '=', $answer_user_id);
        $query->where('status', '=', $commonconstants['status_val'][1]);
      });
    }

    $year = isset($filterArr['year']) ? $filterArr['year'] : 0;

    if ($year) {
      $query->where(function ($query) use ($year) {
        $query->whereYear('created_at', $year);
        return $query;
      });
    }

    $aetId = isset($filterArr['aet_id']) && $filterArr['aet_id'] != '' ? intval($filterArr['aet_id']) : 0;
    if ($aetId > 0) {
      $query->where('aet_id', '=', $aetId);
    }

    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    $parentTopicId = isset($filterArr['parent_topic_id']) ? intval($filterArr['parent_topic_id']) : 0;
    if ($parentTopicId > 0) {
      $query->whereHas('topic', function ($query) use ($parentTopicId) {
        $query->where('parent', '=', $parentTopicId);
      });
    }

    $search = isset($filterArr['search']) ? $filterArr['search'] : '';
    if ($search != '') {
      $query->where(function ($query) use ($search) {
        $query
          ->where('question', 'LIKE', '%' . $search . '%');
        return $query;
      });
    }

    if ($orderBy == false && $order == false) {
      $orderBy = 'aeq_id';
      $order = 'DESC';
    }
    if ($order && strtolower($order) == 'rand') {
      $query->inRandomOrder();
    } else {
      $query->orderBy($orderBy, $order);
    }

    $dtListArr = $perPage ? $query->paginate($perPage) : $query->get();

    $dtListArr->setAppends([
      'is_liked',
      'total_answers',
      'like_count',
      'human_time',
      'date',
      'question_sort'
    ]);

    $random = isset($filterArr['random']) ? intval($filterArr['random']) : 0;
    if ($random > 0) {
      $dtListArr = $dtListArr->random($random);
    }

    $take = isset($filterArr['take']) ? intval($filterArr['take']) : 0;
    if ($take > 0) {
      $dtListArr = $dtListArr->take($take);
    }

    // dd(\DB::getQueryLog()); // Show results of log

    return $dtListArr;
  }

  public static function getData($filterArr = [], $fields = false)
  {
    if ($fields == false) {
      $fields = ['*'];
    }

    $query = AskExpertQuestion::select($fields)->with(['topic', 'user' => function ($query) {
      $query->select('u_id', 'f_name', 'l_name', 'p_picture');
    }]);

    $status = isset($filterArr['status']) ? intval($filterArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }

    $dataId = isset($filterArr['aeq_id']) ? intval($filterArr['aeq_id']) : 0;
    if ($dataId > 0) {
      $query->where('aeq_id', '=', $dataId);
    }

    $dataObj = $query->first();
    $dataObj->setAppends([
      'is_liked',
      'total_answers',
      'like_count',
      'human_time'
    ]);
    return $dataObj;
  }

  public static function listCount($filterArr = false)
  {
    $dtListArr = self::list($filterArr);

    $normal_answer_count = 0;
    $expert_answer_count = 0;
    $total_likes_count = 0;
    foreach ($dtListArr as $key => $question) {
      $dataArr = $question->totalAnswers();
      $answer_likes_count = $dataArr['total_answer_likes'];
      $question_like_count = $question->likes->count();
      $expert_answer_count = $expert_answer_count + $dataArr['expert'];
      $normal_answer_count = $normal_answer_count + $dataArr['normal'];
      $total_likes_count = $total_likes_count + $question_like_count + $answer_likes_count;
    }
    $countArr['normal_answer_count'] = $normal_answer_count;
    $countArr['expert_answer_count'] = $expert_answer_count;
    $countArr['total_likes_count'] = $total_likes_count;

    return $countArr;
  }

  /*
    |--------------------------------------------------------------------------
    | Admin Methods / Functions
    |--------------------------------------------------------------------------
    |
    | The following functions are used for admin panel.
    |
    */

  public static function getModuleVars()
  {
    $commonconstants = Config('commonconstants');

    return ["view_txt" => __('admin.view_txt'), "target" => $commonconstants['target_opt1'], "descp_char_lngth" => Config('adminconstants.descp_char_lngth'), "answer_list_txt" => __('askexpert.answer_list_txt'), "media_folder" => Core::getUploadedURL($commonconstants['aeq_dir_name']), "video_type" => $commonconstants['video_type']['value']];
  }

  public function updatedbyadmin()
  {
    return $this->belongsTo(AdminModel::class, 'updated_id');
  }

  public function addedbyuser()
  {
    return $this->belongsTo(User::class, 'u_id', 'u_id');
  }

  public function scopeSearch($query, $fltrDataArr)
  {
    if (empty($fltrDataArr)) {
      return $query;
    } else {

      $query->leftJoin("ask_expert_topic", "ask_expert_topic.aet_id", "=", "ask_expert_question.aet_id")->select("ask_expert_question.*", "ask_expert_topic.title as topic");

      $question = $fltrDataArr['question'] ?? '';
      if ($question) {
        $query->where('ask_expert_question.question', 'LIKE', "%{$question}%");
      }

      $status = $fltrDataArr['status'] ?? '';
      if ($status) {
        $query->where('ask_expert_question.status', '=', $status);
      }

      $dbDtFrmt = Config('commonconstants.y_m_d_frmt');

      $createdAt = $fltrDataArr['created_at'] ?? '';
      if ($createdAt) {
        $createdAtArr = explode(" - ", $createdAt);
        if (!empty($createdAtArr)) {
          $uaStartDate = date($dbDtFrmt, strtotime($createdAtArr[0])) . ' 00:00:00';
          $uaEndDate = date($dbDtFrmt, strtotime($createdAtArr[1])) . ' 23:59:59';
        }
        $query->whereBetween('ask_expert_question.created_at', [$uaStartDate, $uaEndDate]);
      }

      $updatedAt = $fltrDataArr['updated_at'] ?? '';
      if ($updatedAt) {
        $updatedAtArr = explode(" - ", $updatedAt);
        if (!empty($updatedAtArr)) {
          $uaStartDate = date($dbDtFrmt, strtotime($updatedAtArr[0])) . ' 00:00:00';
          $uaEndDate = date($dbDtFrmt, strtotime($updatedAtArr[1])) . ' 23:59:59';
        }
        $query->whereBetween('ask_expert_question.updated_at', [$uaStartDate, $uaEndDate]);
      }

      $topic = $fltrDataArr['topic'] ?? '';
      if ($topic) {
        $query->whereHas('topic', function ($q) use ($topic) {
          $q->where('title', 'LIKE', '%' . $topic . '%');
        });
      }

      $createdUser = $fltrDataArr['created_user'] ?? '';
      if ($createdUser) {
        $query->whereHas('addedbyuser', function ($q) use ($createdUser) {
          $q->where('f_name', 'LIKE', '%' . $createdUser . '%')->orWhere('l_name', 'LIKE', '%' . $createdUser . '%');
        });
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

  public function answersFront()
  {
    return $this->hasMany(AskExpertQuestionAnswer::class, 'aeq_id', 'aeq_id')->where('status', 1)->orderBy('created_at', 'DESC')->with(['user' => function ($query) {
      $query->select('u_id', 'f_name', 'l_name', 'p_picture');
    }]);
  }

  public function likes()
  {
    $commonconstants = Config('commonconstants');
    return $this->hasMany(UserLike::class, 'data_id', 'aeq_id')->where('type', $commonconstants['like_type']['value'][0]);
  }

  public function totalAnswers()
  {
    $response = array('total' => 0, 'expert' => 0, 'normal' => 0, 'total_answer_likes' => 0);
    foreach ($this->answersFront as $key => $answer) {
      if ($answer->isExpertUser()) {
        $response['expert']++;
      } else {
        $response['normal']++;
      }
      $response['total']++;
      $response['total_answer_likes'] = $response['total_answer_likes'] + $answer->likes->count();
    }
    return $response;
  }

  public function getQuestionSortAttribute()
  {
    return Useful::getShortContent(strip_tags($this->question), __('askexpert.title_char_limit'));
  }

  public function getHumanTimeAttribute()
  {
    return \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
  }
  public function gettotalAnswersAttribute()
  {
    $response = array('total' => 0, 'expert' => 0, 'normal' => 0);
    $question = AskExpertQuestion::find($this->aeq_id);
    foreach ($question->answersFront as $key => $answer) {
      if ($answer->isExpertUser()) {
        $response['expert']++;
      } else {
        $response['normal']++;
      }
      $response['total']++;
    }
    return $response;
  }

  public function totalExpertAnswers()
  {
    $total = 0;
    foreach ($this->answersFront as $key => $answer) {
      if ($answer->isExpertUser()) {
        $total++;
      }
    }
    return $total;
  }

  public function getLikes()
  {
    $commonconstants = Config('commonconstants');

    return UserLike::getLikeCount($commonconstants['like_type']['value'][0], $this->aeq_id);
  }

  public function getLikeCountAttribute()
  {
    $commonconstants = Config('commonconstants');

    return UserLike::getLikeCount($commonconstants['like_type']['value'][0], $this->aeq_id);
  }

  public function isLike()
  {
    $commonconstants = Config('commonconstants');

    return (\Auth::user() && UserLike::getLikeCount($commonconstants['like_type']['value'][0], $this->aeq_id, \Auth::user()->u_id)) ? true : false;
  }

  public function getIsLikedAttribute()
  {
    $commonconstants = Config('commonconstants');

    return (\Auth::user() && UserLike::getLikeCount($commonconstants['like_type']['value'][0], $this->aeq_id, \Auth::user()->u_id)) ? true : false;
  }

  public static function getQuestionCount($fltrArr = [])
  {
    $query = AskExpertQuestion::select('aeq_id');
    $userId = isset($fltrArr['u_id']) ? intval($fltrArr['u_id']) : 0;
    if ($userId > 0) {
      $query->where('u_id', '=', $userId);
    }
    $status = isset($fltrArr['status']) ? intval($fltrArr['status']) : 0;
    if ($status > 0) {
      $query->where('status', '=', $status);
    }
    $tot = $query->count();

    return $tot;
  }

  public static function getArchive($filterArr, $type = "year")
  {
    if ($type == 'year') {
      $groupBy2 = 'archive_year';
      $fields = " DATE_FORMAT(created_at,'%Y') AS archive_year ";

      $orderBy = 'archive_year';
      $order = 'DESC';

      $groupBy = 'archive_year';
    } else {
      $fields = "DATE_FORMAT(created_at,'%b') AS data_name, DATE_FORMAT(created_at,'%m') AS data_value";

      $orderBy = 'data_value';
      $order = 'DESC';

      $groupBy = 'created_at';
    }

    // \DB::enableQueryLog(); // Enable query log

    $commonconstants = Config('commonconstants');

    $query = AskExpertQuestion::selectRaw($fields)->where(['status' => $commonconstants['status_val'][1]]);

    if ($type == 'month') {
      $year = isset($filterArr['year']) ? $filterArr['year'] : date("Y");
      $query->whereRaw("(DATE_FORMAT(created_at, '%Y') = ?)", [$year]);
    }

    $dataObj = $query->where('created_at', '<', date($commonconstants['db_dt_tm_frmt']))->groupBy($groupBy)->orderBy($orderBy, $order)->distinct()->get();

    // dd(\DB::getQueryLog()); // Show results of log

    return $dataObj;
  }

  public function getDateAttribute()
  {
    $commonconstants = Config('commonconstants');
    return \Carbon\Carbon::parse($this->created_at)->format($commonconstants['dt_frmt']);
  }
}
