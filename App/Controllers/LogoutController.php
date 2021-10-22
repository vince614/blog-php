<?php

namespace App\Controllers;

use App\App;
use App\Models\UserModel;
use Core\Utils\Request;

/**
 * Class LogoutController
 * @package App\Controllers
 */
class LogoutController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var UserModel
     */
    protected $userModel;

    /**
     * LogoutController constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->userModel = App::getModel('user');
        $this->logout();
    }

    /**
     * Logout
     */
    public function logout()
    {
        if ($this->userModel->getUserSession()) {
            $this->userModel->logout();
            App::redirect('/');
        }
    }

}