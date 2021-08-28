<?php
namespace Core\Controllers;

use Core\Utils\Flash;
use General;
use Helpers\Recaptcha\Data;

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
     * Display HTML content on the view
     *
     * @param $view
     * @return false|string
     */
    protected function render($view)
    {
        $this->_view = $view;
        extract($this->vars);

        /**
         * Include template views
         */
        $viewFile = 'Views/' . str_replace('.', '/', $view) . '.phtml';
        file_exists($viewFile) ?
            require $viewFile :
            $this->notFound();
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
        return die('La page est introuvable');
    }

    /**
     * Redirect if don't have accès
     */
    public function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die('Accès interdit');
    }

    /**
     * Init model
     *
     * @param $modelName
     * @return mixed
     */
    public function initModel($modelName)
    {
        require_once ROOT . '/Models/' . $modelName . '.php';
        $className = "Models\\" . $modelName;
        return new $className;
    }

    /**
     * Get helper
     *
     * @param $helperName
     * @return mixed
     */
    public function getHelper($helperName)
    {
        require_once ROOT . '/Helpers/' . $helperName . '/Data.php';
        $className = "Helpers\\" . $helperName . "\\Data";
        return new $className;
    }

}