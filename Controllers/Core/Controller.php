<?php
/**
 * This file is part of Core_Controller for DiscordInvites.
 *
 * @license All rights reserved
 * @author <support@dinvites.net> <support-discordinvites>
 * @category Core
 * @package Core
 * @copyright Copyright (c) 2020 DiscordInvites (https://discordinvites.net/)
 */

namespace Controllers\Core;

use General;
use Helpers\Recaptcha\Data;

/**
 * Class Controller
 * @package Controllers\Core
 */
class Controller extends General
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
     * Locale
     * @var string
     */
    private $_locale = 'en';

    /**
     * Translate file
     * @var string
     */
    private $_tranlateFile;

    /**
     * Stylesheet paths
     * @var array
     */
    private $_stylesheetsPaths = [];

    /**
     * Scripts paths
     * @var array
     */
    private $_scriptsPaths = [];

    /**
     * Templates files path
     * @var array
     */
    private $_templatesFiles = [];

    /**
     * Css classe to add
     * @var array
     */
    private $_cssClasses = [];

    /**
     * Path
     * @var string
     */
    public $_controllerPath;

    /**
     * Loader enable flag
     * @var bool
     */
    private $_loaderEnable = true;

    /**
     * Result of ajax call
     * @var array
     */
    public $result = [];

    /**
     * Metas
     * @var array
     */
    public $metas = [];

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Icon
     * @var string
     */
    public $icon;

    /**
     * Canonical URL
     * @var string
     */
    public $canonicalUrl;

    /**
     * Display HTML content on the view
     *
     * @param $view
     * @return false|string
     */
    protected function render($view)
    {
        $this->_view = $view;
        $this->setSessionMessage();
        $this->setVar('view', $view);
        extract($this->vars);

        /**
         * Require header & navbar
         */
        require 'Views/Blocks/header.phtml';
        if ($this->_loaderEnable) {
            require 'Views/Blocks/Loader/loader.phtml';
        }
        require 'Views/Blocks/nav-bar.phtml';


        /**
         * Include template views
         */
        $viewFile = 'Views/' . str_replace('.', '/', $view) . '.phtml';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            $this->notFound();
        }

        // Set footer template
        foreach ($this->getTemplates() as $templateFiles) {
            require 'Views/' . str_replace('.', '/', $templateFiles) . '.phtml';
        }

        /**
         * Require Blocks
         */
        require 'Views/Blocks/footer.phtml';
        require 'Views/Blocks/Social/social.phtml';
        require 'Views/Blocks/Tracking/tracking.phtml';
        require 'Views/Blocks/Scripts/scripts.phtml';
        require 'Views/Blocks/Cookies/cookies.phtml';
    }

    /**
     * Set session message
     *
     * @return $this
     */
    public function setSessionMessage()
    {
        if ($message = $this->getSessionMessage()) {
            $this->setVar('sessionMessage', $message['msg']);
            $this->setVar('sessionMessageType', $message['type']);
            if ($redirect = $message['redirect']) {
                $this->setVar('sessionRedirect', $redirect);
            }
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
     * Ajax action
     *
     * @param $request
     */
    public function ajaxAction($request)
    {
        if (!isset($request['type'])
            OR empty($request['type'])) {
            return die('Undefined type of request');
        }
    }

    /**
     * Check if user is login
     */
    public function isLogin()
    {

    }

    /**
     * Get Post
     *
     * @return mixed
     */
    public function getPost()
    {
        return $_POST;
    }

    /**
     * Check if is POST method
     *
     * @return bool
     */
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Add session message & redirect
     *
     * @param $msg
     * @param bool $redirect
     * @param string $type
     */
    protected function _addSessionMessage($msg, $redirect = false, $type = "success")
    {
        $_SESSION['message'] = [
            'msg' => $msg,
            'redirect' => $redirect,
            'type' => $type
        ];
    }

    /**
     * Get session message
     *
     * @return bool|mixed
     */
    public function getSessionMessage()
    {
        if (isset($_SESSION['message'])
            && !empty($_SESSION['message'])) {

            $msg = $_SESSION['message'];
            unset($_SESSION['message']);

            return $msg;
        }
        return false;
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

    /**
     * Get css classes to add
     *
     * @return array
     */
    public function getCssClasses()
    {
        return $this->_cssClasses;
    }

    /**
     * Set css class
     *
     * @param $name
     * @param $element
     * @return $this
     */
    public function setCssClass($name, $element)
    {
        $this->_cssClasses[] = [
            'name'    => $name,
            'element' => $element
        ];
        return $this;
    }


    /**
     * Set template file
     *
     * @param $templateFile
     * @return Controller
     */
    public function setTemplate($templateFile)
    {
        $this->_templatesFiles[] = $templateFile;
        return $this;
    }

    /**
     * Reset templates
     */
    public function resetTemplates()
    {
        $this->_templatesFiles = [];
    }

    /**
     * Get all templates
     *
     * @return array
     */
    public function getTemplates()
    {
        return $this->_templatesFiles;
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

    /**
     * Redirect
     *
     * @param $url
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }

    /**
     * Disable loader
     * @return $this
     */
    public function disableLoader()
    {
        $this->_loaderEnable = false;
        return $this;
    }

    /**
     * Add meta
     *
     * @param $name
     * @param $content
     * @param bool $isProperty
     * @return Controller
     */
    public function addMeta($name, $content, $isProperty = false)
    {
        $this->metas[] = [
            'name'       => $name,
            'content'    => $content,
            'isProperty' => $isProperty
        ];
        return $this;
    }

    /**
     * Set title
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set icon
     *
     * @param $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Set canonical URL
     *
     * @param $url
     * @return $this
     */
    public function setCanonicalUrl($url)
    {
        $this->canonicalUrl = $url;
        return $this;
    }

    /**
     * Get canonical URL
     *
     * @return string
     */
    public function getCanonicalUrl()
    {
        return $this->canonicalUrl;
    }

    /**
     * Google Recaptcha
     *
     * @return bool
     */
    public function googleRecaptcha()
    {
        if (isset($_POST['g-recaptcha-response'])) {
            /** @var Data $recaptchaHelper */
            $recaptchaHelper = $this->getHelper('Recaptcha');
            return $recaptchaHelper->validateCaptcha(
                $_POST['g-recaptcha-response'],
                $this->getConfig('grecaptcha_secretkey')
            );
        }
        return false;
    }

}