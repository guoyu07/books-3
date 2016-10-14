<?php

namespace common\library;

use Yii;

class Input
{
    public static function post($name = '', $defaultValue = '')
    {
        $data = Yii::$app->request->post();
        if(empty($data)) {
            if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
                $data = json_decode(file_get_contents("php://input"), true);
            }
        }
        if (!empty($name)) {
            return empty($data[$name]) ? $defaultValue : $data[$name];
        }
        return $data;
    }

    public static function getParam($name, $defaultValue = null)
    {
        $result = Yii::$app->request->getQueryParam($name, $defaultValue);

        return $result;
    }
}