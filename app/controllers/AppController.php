<?php declare(strict_types=1);

namespace app\controllers;

use engine\base\Controller;
use app\models\AppModel;

/**
 * Description of AppController
 *
 * @author Sergey
 */
class AppController extends Controller
{

    public function __construct($route) 
    {
        parent::__construct($route);
        new AppModel();
    }

}
