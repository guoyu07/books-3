<?php
namespace frontend\controllers;

use common\library\HTTPRequest;
use common\library\Output;
use Yii;
use yii\web\Controller;

/**
 * Source controller
 */
class SourceController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionCover()
    {
        $result = HTTPRequest::request('http://api.zhuishushenqi.com/book/53855a750ac0b3a41e00c7e6');
        if($result['status'] == 'OK') {
            Output::normal(200, '获取');
//            Output::normal(200, '获取', json_decode($result['content']));
        }
    }


}
