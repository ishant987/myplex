<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Exception;

use App\Models\UserLike;

class LikeUnlikeController extends Controller
{
    public function captureLUData(Request $request)
    {
        $message = __('message');

        $response = [];
        $response["redirect"] = "";
        $response["type"] = "error";
        $response["msg"] = $message["error"]["something_wrong"];

        if ($input = $request->all()) {
            try {
                $type = $input['type'];
                $dataId = intval($input['data_id']);

                if ($type == '' || $dataId == 0) {
                    $response["msg"] = $message["error"]["req_data_not_found"];
                } else {
                    if (!\Auth::check()) {
                        $response["redirect"] = route('web.login');
                    } else {
                        $frontLang = __('front');

                        $userId = \Auth::user()->u_id;

                        $model = new UserLike;

                        $row = $model->where(["type" => $type, "data_id" => $dataId, "u_id" => $userId])->first();
                        if ($row) {
                            $totDel = $row->delete();
                            if ($totDel > 0) {
                                $response["type"] = "success";
                                $response["msg"] = $frontLang["success"]["unlike"];
                                $response["data_id"] = $dataId;

                                $total = $model->getLikeCount($type, $dataId);
                                $response["total"] = $total;
                            } else {
                                $response["msg"] = $message["error"]["delete"];
                            }
                        } else {
                            $model->type = $type;
                            $model->data_id = $dataId;
                            $model->u_id = $userId;
                            $model->save();

                            $response["type"] = "success";
                            $response["msg"] = $frontLang["success"]["like"];
                            $response["data_id"] = $dataId;

                            $total = $model->getLikeCount($type, $dataId);
                            $response["total"] = $total;
                        }
                    }
                }
            } catch (Exception $e) {
                $response["msg"] = $e;
            }
        } else {
            $response["msg"] = $message["error"]["req_data_not_found"];
        }

        return json_encode($response);
    }
}
