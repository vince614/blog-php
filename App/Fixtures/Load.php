<?php

// Require
use App\App;
use App\Entity\CommentEntity;
use App\Entity\PostEntity;
use App\Entity\UserEntity;
use App\Models\CommentModel;
use App\Models\PostModel;
use App\Models\UserModel;

define('ROOT', __DIR__ .  '/../..');

require ROOT . '/vendor/autoload.php';
require ROOT . '/App/App.php';
require ROOT . '/Core/Exception/Exception.php';

/**
 * Class Load
 */
class Load
{

    /**
     * Const
     */
    const USERS_COUNT               = 20;
    const POST_PER_USER_COUNT       = 5;
    const COMMENT_PER_POST_COUNT    = 10;


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

    /**
     * @throws Exception
     */
    public function run()
    {
        // Generate users
        for ($i = 0; $i < self::USERS_COUNT; $i++) {
            /** @var UserEntity $user */
            $user = $this->userModel->getEntity($this->userModel->_entityName, [
                'name'          => $this->faker->userName(),
                'avatar'        => $this->faker->imageUrl(500, 500),
                'email'         => $this->faker->email(),
                'password'      => sha1('password'),
                'created_at'    => $this->faker->unixTime()
            ]);
            // Check if email is already use
            if (!$this->userModel->load($user->getEmail(), 'email')) {
                echo "Utilisateur généré : " . $user->getEmail() . PHP_EOL;
                $this->userModel->create($user, $this->userModel->_tableName);
                $_user = $this->userModel->load($user->getEmail(), 'email');
                // Generate articles
                for ($x = 0; $x < random_int(0, self::POST_PER_USER_COUNT); $x++) {
                    $time = $this->faker->unixTime();
                    /** @var PostEntity $article */
                    $article = $this->postModel->getEntity($this->postModel->_entityName, [
                        'title'         => $this->faker->sentence(),
                        'url_key'       => $this->faker->randomNumber(),
                        'resume'        => $this->faker->paragraph(),
                        'content'       => htmlspecialchars($this->faker->paragraph(10)),
                        'author_id'     => $_user->getId(),
                        'updated_at'    => $time,
                        'created_at'    => $time
                    ]);
                    // Check if url key is already use
                    if (!$this->postModel->load($article->getUrlKey(), 'url_key')) {
                        echo "Article généré : " . $article->getTitle() . PHP_EOL;
                        $this->postModel->create($article, $this->postModel->_tableName);
                        $_article = $this->postModel->load($article->getUrlKey(), 'url_key');
                        // Generate comments
                        for ($y = 0; $y < random_int(0, self::COMMENT_PER_POST_COUNT); $y++) {
                            $time = $this->faker->unixTime();
                            /** @var CommentEntity $comment */
                            $comment = $this->commentModel->getEntity($this->commentModel->_entityName, [
                                'content'       => htmlspecialchars($this->faker->paragraph()),
                                'author_id'     => $_user->getId(),
                                'post_id'       => $_article->getId(),
                                'is_verified'   => 1,
                                'created_at'    => $time
                            ]);
                            echo "Commentaire généré : " . $comment->getAuthorId() . PHP_EOL;
                            $this->commentModel->create($comment, $this->commentModel->_tableName);
                        }
                    }
                }
            }
        }
    }

}
$load = new Load();
$load->run();