<?php
namespace Core\Utils;

/**
 * Class Request
 */
class Request
{

    /**
     * @param null $key
     * @return mixed
     */
    public function getPost($key = null)
    {
        if ($this->isPost()) {
            if ($key) return $_POST[$key];
            return $_POST;
        }
        return false;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getGet($key = null)
    {
        if ($this->isGet()) {
            if ($key) return $_GET[$key];
            return $_GET;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return isset($_POST);
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return isset($_GET);
    }

    /**
     * @return mixed
     */
    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        return rtrim(substr($_SERVER["REQUEST_URI"], 1), '/');
    }

    /**
     * Get session
     *
     * @return mixed
     */
    public function getSession()
    {
        return $_SESSION;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getCookies($key = null)
    {
        if ($key) return $_COOKIE[$key];
        return $_COOKIE;
    }

    /**
     * Set cookie
     *
     * @param $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return $this
     */
    public function setCookie($name, $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httponly = false)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        return $this;
    }

    /**
     * Set session datas
     *
     * @param $key
     * @param $data
     * @return $this
     */
    public function setSessionData($key, $data)
    {
        $_SESSION[$key] = $data;
        return $this;
    }

    /**
     * @param null $key
     * @return $this
     */
    public function unsetSession($key = null)
    {
        if ($key) {
            unset($_SESSION[$key]);
        } else {
            unset($_SESSION);
        }
        return $this;
    }



}