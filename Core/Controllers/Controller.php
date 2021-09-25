<?php
namespace Core\Controllers;

use Core\Utils\Render;

/**
 * Class Controller
 * @package Controllers\Core
 */
class Controller
{
    /**
     * Blocks
     */
    const HEADER_BLOCK = 'header';
    const FOOTER_BLOCK = 'footer';

    /**
     * Variables
     * @var $vars array
     */
    public $vars = [];

    /**
     * Params in request
     * @var array
     */
    public $params = [];

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
     * @var array
     */
    protected $_stylesheetsPaths = [];

    /**
     * @var array
     */
    protected $_scriptsPaths = [];

    /**
     * Controller constructor.
     * @param $path
     * @param null $params
     */
    public function __construct($path, $params = null)
    {
        $this->path = $path;
        $this->params = $params;
        $this->index();
    }

    /**
     * Index
     */
    public function index()
    {
        if (!isset($this->path)) new ErrorController(Render::ERROR_404_PATH);
        $this->beforeRender();
        new Render($this->path, $this->vars);
        $this->afterRender();
    }

    /**
     * Before render
     */
    protected function beforeRender()
    {
        $this->setBlock(self::HEADER_BLOCK);
    }

    /**
     * Before render
     */
    protected function afterRender()
    {
        $this->setBlock(self::FOOTER_BLOCK);
    }

    /**
     * Set block
     *
     * @param $block
     * @return $this
     */
    public function setBlock($block)
    {
        $blockFile = ROOT . '/App/Views/Blocks/' . str_replace('.', '/', $block) . '.phtml';
        if (file_exists($blockFile)) {
            require $blockFile;
        }
        return $this;
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

    /**
     * Set stylesheet path
     *
     * @param $path
     * @param bool $isAssets
     * @return Controller
     */
    public function setStylesheetPath($path, $isAssets = true)
    {
        if ($isAssets) {
            $this->_stylesheetsPaths[] = '/assets/css/' . $path;
        } else {
            $this->_stylesheetsPaths[] = '/' . $path;
        }
        return $this;
    }

    /**
     * Set scripts path
     *
     * @param $path
     * @param bool $isFonction
     * @param bool $isAsset
     * @return Controller
     */
    public function setScriptPath($path, $isFonction = false, $isAsset = true)
    {
        if ($isAsset) {
            if ($isFonction) {
                $this->_scriptsPaths[] = '/assets/js/functions/' . $path;
            } else {
                $this->_scriptsPaths[] = '/assets/js/' . $path;
            }
        } else {
            $this->_scriptsPaths[] = '/' . $path;
        }
        return $this;
    }

    /**
     * Get stylesheet paths
     *
     * @return array
     */
    public function getStylesheetsPaths()
    {
        return $this->_stylesheetsPaths;
    }

    /**
     * Get scripts paths
     *
     * @return array
     */
    public function getScriptsPaths()
    {
        return $this->_scriptsPaths;
    }

}