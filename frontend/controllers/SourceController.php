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

    public $enableCsrfValidation = false;

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

    public function actionBookList()
    {
        $data = Input::post();
        $ids = $data['ids'];
        $info_list = [];
        foreach ($ids as $id) {
            $info = $this->getBookInfo($id);
            if(!empty($info)) {
                $info_list[] = $info;
            }
        }
        Output::simple($info_list);
    }

    public function actionChapter()
    {
        $data = Input::post();
        $book_id = $data['book_id'];
        $chapter_index = $data['chapter_index'];
        $content_url = $data['content_url'];
        if (empty($content_url)) {
            $chapters = $this->getChapters($book_id);
            if(!empty($chapters)){
                $chapter = $chapters[$chapter_index];
                $content_url = $chapter['link'];
            }
        }
        $content = $this->getContent($content_url);
        Output::simple($content);
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
        $result = HTTPRequest::request('http://api.zhuishushenqi.com/mix-ctoc/'. $book_id.'?view=chapters');
        if($result['status'] == 'OK') {
            $content = json_decode($result['content'], 471);
            if($content['ok']) {
                return $content['mixToc']['chapters'];
            }
        }
        return [];
    }

    private function getContent($content_url)
    {
        $result = HTTPRequest::request('http://api.zhuishushenqi.com/chapter/'. urlencode($content_url));
        if($result['status'] == 'OK') {
            $content = json_decode($result['content'], 471);
            if($content['ok']) {
                return $content['chapter'];
            }
        }
        return [];
    }

//    public function actionChapter()
//    {
//        $book_id = Input::getParam('book_id');
//        $info = $this->getBookInfo($book_id);
//        $chapters = $this->getChapters($book_id);
//        $result['title'] = $info['title'];
//        $result['chapters'] = array_reverse($chapters);
//        Output::normal(200, '获取成功', $result);
//    }

    public function actionReader()
    {
        $book_id = Input::post('book_id');
        $chap_index = Input::post('chap_index');

    }


}
