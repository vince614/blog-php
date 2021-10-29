<?php

// Require
use App\App;
use App\Entity\UserEntity;
use App\Models\CommentModel;
use App\Models\PostModel;
use App\Models\UserModel;

require '../../vendor/autoload.php';
require '../../app/App.php';
require '../../Core/Exception/Exception.php';

/**
 * Class Load
 */
class Load
{

    /**
     * Const
     */
    const USERS_COUNT = 20;
    const POST_COUNT = 30;
    const COMMENT_COUNT = 10;


    /**
     * @var \Faker\Generator
     */
    public $faker;

    /**
     * @var UserModel
     */
    public $userModel;

    /**
     * @var CommentModel
     */
    public $commentModel;

    /**
     * @var PostModel
     */
    public $postModel;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $this->userModel = App::getModel('user');
        $this->commentModel = App::getModel('comment');
        $this->postModel = App::getModel('post');
    }

    public function run()
    {
        for ($i = 0; $i < self::USERS_COUNT; $i++) {
            /** @var UserEntity $user */
            $user = $this->userModel->getEntity($this->userModel->_entityName, [
                'name'          => $this->faker->userName(),
                'email'         => $this->faker->email(),
                'password'      => sha1('password'),
                'created_at'    => $this->faker->time()
            ]);
            if ($this->userModel->load($user->getEmail(), 'email')) continue;
            $this->userModel->create($user, $this->userModel->_tableName);
        }
    }

}
$load = new Load();
$load->run();