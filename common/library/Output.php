<?php

namespace common\library;

use Yii;
use yii\web\Response;

class Output
{
    public static function normal($code = 200, $msg = 'OK', $data = array())
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($data)) {
            echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>[]]);
        }else{
            echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>$data]);
        }
    }

    public static function result($result, $with_data = false)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($with_data) {
            echo json_encode($result);
        }else{
            echo json_encode($result);
        }
    }

}