<?php

namespace app\controllers;
use \RedBeanPHP\R as R;
/**
 * Description of MainController
 *
 * @author Sergey
 */
class MainController extends AppController
{

    public function indexAction() 
    {
        $posts = R::findAll('test');
        //debug($posts);
        $this->setMeta('Индекс пейдж', "Это описание индекс пейдж", "Это кейвордс");
        $this->setData(compact('posts'));
    }

}