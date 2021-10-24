<?php

namespace App\Controllers;

use App\App;
use App\Entity\UserEntity;
use App\Models\UserModel;
use Core\Controllers\Controller;

/**
 * Class ProfileController
 * @package App\Controllers
 */
class ProfileController extends Controller
{

    public $userId;

    /**
     * @var UserModel
     */
    public $userModel;

    /**
     * @var UserEntity
     */
    public $user;

    /**
     * ProfileController constructor.
     * @param $path
     * @param null $params
     */
    public function __construct($path, $params = null)
    {
        if ($params) $this->userId = isset($params[0]) ? $params[0] : null;
        $this->userModel = App::getModel('user');
        parent::__construct($path, $params);
    }

    /**
     * Before renders
     */
    public function beforeRender()
    {
        $user = $this->userModel->load($this->userId);
        if ($user) {
            $this->user = $user;
            $this->setStylesheetPath('profile.css');
            $this->meta->setTitle($this->user->getName());
            parent::beforeRender();
        } else {
            App::redirect('/');
        }
    }

}