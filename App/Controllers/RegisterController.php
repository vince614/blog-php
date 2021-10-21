<?php
namespace App\Controllers;

use App\App;
use App\Entity\UserEntity;
use App\Models\UserModel;
use App_Core_Exception;
use Core\Controllers\Controller;
use Core\Utils\Ajax;
use Core\Utils\Request;

/**
 * Class RegisterController
 * @package App\Controller
 */
class RegisterController extends Controller
{

    const REGISTER_REQUEST_TYPE = "register";

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var UserModel
     */
    protected $userModel;

    public function __construct($path, $params = null)
    {
        $this->request = new Request();
        $this->userModel = App::getModel('user');
        parent::__construct($path, $params);
    }

    /**
     * @throws App_Core_Exception
     */
    public function beforeRender()
    {
        $this->checkPostRequest();
        $this->setStylesheetPath('register.css');
        $this->setScriptPath('register.js', true);
        parent::beforeRender(); // TODO: Change the autogenerated stubs
    }

    /**
     * Check post request
     * @throws App_Core_Exception
     */
    public function checkPostRequest()
    {
        if (!$this->request->isPost()) return;
        $ajaxObject = new Ajax($this->request->getPost());
        switch ($ajaxObject->getRequestType()) {
            case self::REGISTER_REQUEST_TYPE:
                $datas = $ajaxObject->getRequestDatas();
                /** @var UserEntity $user */
                $user = $this->userModel->getEntity($this->userModel->_entityName, [
                    'name'          => $datas['username'],
                    'email'         => $datas['email'],
                    'password'      => $datas['password'],
                    'created_at'    => time()
                ]);

                // Check if email exist email
                if ($this->userModel->load($user->getEmail(), 'email')) {
                    $ajaxObject->error("Cet adresse mail est déjà relié à un compte, veuillez en choisir une autre");
                    break;
                }

                $created = $this->userModel->create($user, $this->userModel->_tableName);
                $created ?
                    $ajaxObject->success("Vous êtes bien inscrit !") :
                    $ajaxObject->error("Une erreur c'est produite, veuillez réessayer");
        }
        $ajaxObject->sendResponse();
    }

}