<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController;
use App\Models\CorpusEntry;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FundMaster;
use App\Models\FundType;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Lib\Core\Useful;
use App\Models\FundComposition;

class CorrelationCornCpntroller extends Controller
{
  public function __construct()
  {
    $this->Useful = new Useful;
  }

  public function index(Request $request){

    dd("ok");

  }

  
}
