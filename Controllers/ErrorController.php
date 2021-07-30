<?php
namespace Controllers;

use Controllers\Core\Controller;

/**
 * Class ErrorController
 * @package Controllers
 */
class ErrorController extends Controller
{

    public function __construct($path)
    {
        $this->render($path);
    }

    /**
     * Index
     *
     * @param $path
     */
    public function render($path)
    {
        if (!isset($path)) {
            $this->notFound();
            return;
        }
        $viewFile = 'Views/Errors/' . $path . '.phtml';
        require $viewFile;
    }

}