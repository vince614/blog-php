<?php
namespace Core\Controllers;

use App\Controllers\ErrorController;

/**
 * Class Controller
 * @package Controllers\Core
 */
class Controller
{

    /**
     * Variables
     * @var $vars array
     */
    public $vars = [];

    /**
     * View
     * @var string
     */
    private $_view;

    /**
     * @var string
     */
    public $path;

    /**
     * Controller constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->index();
    }

    /**
     * Index
     */
    public function index()
    {
        if (!isset($this->path)) new ErrorController('Errors.404');
        if (method_exists($this, 'beforeRender')) $this->beforeRender();
        $this->render($this->path);
        if (method_exists($this, 'afterRender')) $this->afterRender();
    }

    /**
     * Display HTML content on the view
     *
     * @param $view
     * @return mixed|void
     */
    protected function render($view)
    {
        $this->_view = $view;
        extract($this->vars);
        $viewFile = ROOT . '/App/Views/' . str_replace('.', '/', $view) . '.phtml';
        return file_exists($viewFile) ?
            require $viewFile :
            new ErrorController('Errors.404');
    }

    /**
     * Set variables
     *
     * @param $index
     * @param $value
     * @return Controller
     */
    public function setVar($index, $value)
    {
        $this->vars[$index] = $value;
        return $this;
    }

    /**
     * Redirect if page not found
     */
    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    /**
     * Redirect if don't have accès
     */
    public function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        exit;
    }

}