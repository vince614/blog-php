<?php
namespace App\Entity;

use App\App;
use App\Models\UserModel;
use Core\Entity\Entity;

/**
 * Class CommentEntity
 * @package App\Entity
 */
class CommentEntity extends Entity
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $author_id;

    /**
     * @var int
     */
    private $post_id;

    /**
     * @var int
     */
    private $created_at;

    /**
     * @var int
     */
    private $is_verified;


    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @return int
     */
    public function getAuthorId()
    {
        return (int) $this->author_id;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return (int) $this->created_at;
    }

    /**
     * @return int
     */
    public function getIsVerified()
    {
        return (int) $this->is_verified;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return (int) $this->post_id;
    }

    /**
     * @param int $author_id
     * @return CommentEntity
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @param string $content
     * @return CommentEntity
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param int $created_at
     * @return CommentEntity
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @param int $id
     * @return CommentEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int $is_verified
     * @return CommentEntity
     */
    public function setIsVerified($is_verified)
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    /**
     * @param int $post_id
     * @return CommentEntity
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
        return $this;
    }

    /**
     * Get authore of comment
     *
     * @return bool|UserEntity
     */
    public function getAuthor()
    {
        /** @var UserModel $userModel */
        $userModel = App::getModel('user');
        return $userModel->load($this->getAuthorId());
    }

}