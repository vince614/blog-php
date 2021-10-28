<?php
namespace App\Controllers;

use App\App;
use App\Entity\PostEntity;
use App\Models\PostModel;
use App\Models\UserModel;
use App_Core_Exception;
use Core\Controllers\Controller;
use Core\Form\FormValidation;
use Core\Utils\Ajax;
use Core\Utils\Request;

/**
 * Class BlogController
 * @package App\Controllers
 */
class BlogController extends Controller
{

    const ADD_NEW_POST_ROUTE        = "new";
    const NEW_POST_REQUEST_TYPE     = "create";
    const DELETE_POST_REQUEST_TYPE  = "delete";

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var PostModel
     */
    protected $postModel;

    /**
     * @var UserModel
     */
    protected $userModel;

    /**
     * @var PostEntity[]
     */
    public $articles;

    /**
     * @var PostEntity
     */
    public $article;

    /**
     * @var string
     */
    public $articleUrlKey;

    /**
     * @var bool
     */
    public $articleForm = false;

    /**
     * @var bool
     */
    public $editMode = false;

    /**
     * @var FormValidation
     */
    protected $formValidation;

    /**
     * BlogController constructor.
     *
     * @param $path
     * @param null $params
     */
    public function __construct($path, $params = null)
    {
        if ($params) {
            if ($params[0] === self::ADD_NEW_POST_ROUTE ||
                isset($params['edit'])) {
                $path .= '.new';
                $this->articleForm = true;
                $this->editMode = isset($params['edit']);
                $this->articleUrlKey = $params[0];
            } else {
                $path .= '.view';
                $this->articleUrlKey = $params[0];
            }
        }
        $this->request = new Request();
        $this->postModel = App::getModel('post');
        $this->userModel = App::getModel('user');
        $this->formValidation = new FormValidation();
        parent::__construct($path, $params);
    }

    /**
     * @throws App_Core_Exception
     */
    public function beforeRender()
    {
        $this->checkPostRequest();
        $this->setStylesheetPath('blog.css');

        if ($this->articleForm) {
            $this->setScript('post.js', Controller::FUNCTION_PATH, Controller::MODULE_TYPE);
            $this->meta->setTitle("Création d'un article");
            $this->formValidation
                ->generateToken()
                ->saveTokenInSession('blog')
                ->saveTokenInApp('blog');
            if ($this->editMode) {
                $this->article = $this->postModel->load($this->articleUrlKey, 'url_key');
                $this->meta->setTitle("Modification d'un article");
            }
        } else if ($this->articleUrlKey) {
            $this->article = $this->postModel->load($this->articleUrlKey, 'url_key');
            $this->setScript('post.js', Controller::ASSETS_PATH, Controller::JAVASCRIPT_TYPE);
            $this->meta->setTitle($this->article->getTitle());
        } else {
            $this->articles = $this->postModel->getCollection();
            $this->meta->setTitle('Liste des articles');
        }

        parent::beforeRender(); // TODO: Change the autogenerated stub
    }

    /**
     * Check post request
     * @throws App_Core_Exception
     */
    public function checkPostRequest()
    {
        if (!$this->request->isPost()) return;
        $ajaxObject = new Ajax($this->request->getPost());

        // Check if user is logged
        $userSession = $this->userModel->getUserSession();
        if (!$userSession) {
            $ajaxObject->error("Vous devez être connecté pour publier un article");
            $ajaxObject->sendResponse();
        }

        switch ($ajaxObject->getRequestType()) {
            case self::NEW_POST_REQUEST_TYPE:
                $datas = $ajaxObject->getRequestDatas();

                // Validate form
                $this->validateForm($datas);
                if ($error = $this->formValidation->getError()) {
                    $ajaxObject->error($error);
                    $ajaxObject->sendResponse();
                }

                if ($datas['editMode'] == "true") {
                    // Load article
                    /** @var PostEntity $article */
                    $article = $this->postModel->load($datas['urlKey'], 'url_key');

                    // Check if is author
                    if ($article->getAuthorId() !== $userSession->getId()) {
                        $ajaxObject->error("Vous n'avez pas les permissions d'éditer cet article");
                        break;
                    }

                    $article
                        ->setTitle($datas['title'])
                        ->setContent(htmlspecialchars($datas['content']))
                        ->setUpdatedAt(time());
                    $article->save();
                    $ajaxObject->success("Votre article à bien été miss à jour !");
                } else {

                    // Check if url key is already use
                    if ($this->postModel->load($datas['urlKey'], 'url_key')) {
                        $ajaxObject->error("Cette clé d'url est déjà utilisez, veuillez en choisir une autre");
                        $ajaxObject->sendResponse();
                    }

                    $article = $this->postModel->getEntity($this->postModel->_entityName, [
                        'title'         => $datas['title'],
                        'url_key'       => $datas['urlKey'],
                        'resume'        => $datas['resume'],
                        'content'       => htmlspecialchars($datas['content']),
                        'author_id'     => $userSession->getId(),
                        'updated_at'    => time(),
                        'created_at'    => time()
                    ]);
                    $created = $this->postModel->create($article, $this->postModel->_tableName);
                    $created ?
                        $ajaxObject->success("Votre article à bien été publier !") :
                        $ajaxObject->error("Une erreur c'est produite, veuillez réessayer");
                }
                break;
            case self::DELETE_POST_REQUEST_TYPE:
                $datas = $ajaxObject->getRequestDatas();
                /** Load article @var PostEntity $article */
                $article = $this->postModel->load($datas['articleId']);

                // Check if is author
                if ($article->getAuthorId() !== $userSession->getId()) {
                    $ajaxObject->error("Vous n'avez pas les permissions de supprimer cet article");
                    break;
                }
                $article->delete();
                $ajaxObject->error("L'article à bien été supprimer");
        }
        $ajaxObject->sendResponse();
    }

    /**
     * Validate form
     *
     * @param $datas
     */
    public function validateForm($datas)
    {
        $this->formValidation
            ->verifyFormToken('blog', $datas['formToken'])
            ->checkResume($datas['resume']);
    }

}