<?php
namespace Core\Models;

use PDO;

/**
 * Class User
 * @package Core\Models
 */
class User
{
    /**
     * @var PDO
     */
    private $db;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getPDO();
    }



}