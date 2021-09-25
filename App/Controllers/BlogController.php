<?php
namespace App\Controllers;

use Core\Controllers\Controller;

/**
 * Class BlogController
 * @package App\Controllers
 */
class BlogController extends Controller
{

    protected function beforeRender()
    {
        var_dump($this->params);
    }

}