<?php

namespace common\library;

use Yii;

class Output
{
    public static function normal($code = 200, $msg = 'OK', $data = array())
    {
        if (empty($data)) {
            echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>[]]);
        }else{
            echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>$data],271);
        }
    }

    public static function result($result, $with_data = false)
    {
        if ($with_data) {
            echo json_encode($result);
        }else{
            echo json_encode($result);
        }
    }

}