<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Auth;

use App\ModuleClassModel;

class BaseController extends Controller
{
    public $statusSuccess       = 200;
    public $statusCreate        = 201;
    public $statusNocontent     = 204;
    public $statusBadrequest    = 400;
    public $statusUnauthorized  = 401;
    public $statusForbidden     = 403;
    public $statusNotFound      = 404;
    public $statusInternalError = 500;
    public $statusUnavailable   = 503;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if(!empty($result)){
            $response['data'] = $result;
        }

        return response()->json($response, $this->statusSuccess);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public static function getClassIdByname($class_name){
        return ModuleClassModel::getClassIdByname($class_name);
    }

    public static function getClassIdBymodel($model_name){
        return ModuleClassModel::getClassIdBymodel($model_name);
    }
    
    public static function getLoggedInUserId(){
        return (Auth::check()) ? Auth::user()->u_id : 0;
    }

    public static function getLoggedInUserProfileInfo(){
        return (Auth::check()) ? Auth::user() : [];
    }
}
