<?php
namespace application\controllers;

use application\models\Articles;

/**
 * Можно использовать для обработки ajax-запросов.
 */
class AjaxController extends \ItForFree\SimpleMVC\MVC\Controller 
{
    /**
     * Подгрузка "лайков" статей или товаров
     */
    public function likeAction()
    {
       echo 'привет!';
    } 
    
        public function postAction()
    {

    }

    public function getAction()
    {
        if (isset($_GET['id'])) {
            $article = new Articles();
            $article->getById($_GET['id']);
            echo json_encode($article->content);
        }
    }

    public function newPostAction()
    {

    }

    public function newGetAction()
    {

    }
}

