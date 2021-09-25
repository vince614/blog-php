<?php
namespace App\Controllers;

use Core\Controllers\Controller;

/**
 * Class IndexController
 * @package App\Controllers
 */
class IndexController extends Controller
{

    public function beforeRender()
    {
        $this->setStylesheetPath('theme.css');
        parent::beforeRender();
    }

    public function afterRender()
    {

    }

}