<?php
namespace frontend\controllers;

use common\library\HTTPRequest;
use common\library\Input;
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
//        $book_id = Input::getParam('book_id');
        $book_id = '53855a750ac0b3a41e00c7e6';

        $info = $this->getBookInfo($book_id);
        if(!empty($info)) {
            Output::normal(200, '获取成功', $info);
        } else {
            Output::normal(400, '获取失败');
        }
    }

    private function getBookInfo($book_id)
    {
        $result = HTTPRequest::request('http://api.zhuishushenqi.com/book/' . $book_id);
        if($result['status'] == 'OK') {
            return json_decode($result['content'], 471);
        } else {
            return [];
        }
    }

    private function getChapters($book_id)
    {
        $result = HTTPRequest::request('http://api.zhuishushenqi.com/mix-atoc/'. $book_id.'?view=chapters');
        if($result['status'] == 'OK') {
            $content = json_decode($result['content'], 471);
            if($content['ok']) {
                return $content['mixToc']['chapters'];
            }
        }
        return [];
    }

    public function actionChapter()
    {
        $book_id = Input::getParam('book_id');
        $info = $this->getBookInfo($book_id);
        $chapters = $this->getChapters($book_id);
        $result['title'] = $info['title'];
        $result['chapters'] = array_reverse($chapters);
        Output::normal(200, '获取成功', $result);
    }

    public function actionReader()
    {
        $book_id = Input::post('book_id');
        $chap_index = Input::post('chap_index');

    }


}
