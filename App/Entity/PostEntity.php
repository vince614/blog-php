<?php
namespace App\Entity;

use Core\Entity\Entity;

/**
 * Class PostEntity
 * @package App\Entity
 */
class PostEntity extends Entity
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $resume;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $url_key;

    /**
     * @var int
     */
    private $author_id;

    /**
     * @var int
     */
    private $updated_at;

    /**
     * @var int
     */
    private $created_at;

    /**
     * @var int
     */
    private $is_public;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getIsPublic()
    {
        return (int) $this->is_public;
    }

    /**
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return (int) $this->updated_at;
    }

    /**
     * @return string
     */
    public function getUrlKey()
    {
        return $this->url_key;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param int $author_id
     * @return PostEntity
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @param string $content
     * @return PostEntity
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param int $created_at
     * @return PostEntity
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @param int $id
     * @return PostEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $url_key
     * @return PostEntity
     */
    public function setUrlKey($url_key)
    {
        $this->url_key = $url_key;
        return $this;
    }

    /**
     * @param int $is_public
     * @return PostEntity
     */
    public function setIsPublic($is_public)
    {
        $this->is_public = $is_public;
        return $this;
    }

    /**
     * @param string $resume
     * @return PostEntity
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
        return $this;
    }

    /**
     * @param string $title
     * @return PostEntity
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param int $updated_at
     * @return PostEntity
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

}