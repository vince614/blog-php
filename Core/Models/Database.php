<?php
namespace Core\Models;

use PDO;

/**
 * Class Database
 * @package Core
 */
abstract class Database
{
    /**
     * @var PDO
     */
    protected $_pdo;

    /**
     * Params to connect with PDO to database
     *
     * @var string
     */
    protected $_hostname  = "localhost";
    protected $_database  = "blog-php";
    protected $_charset   = "utf8mb4";
    protected $_user      = "root";
    protected $_password  = "";

    /**
     * Core_Mysql constructor.
     */
    public function __construct()
    {
        $this->initPDO();
    }

    /**
     * Init pdo
     */
    private function initPDO()
    {
        if (!$this->_pdo) {
            $this->_pdo = new PDO(
                "mysql:host={$this->_hostname};dbname={$this->_database};charset={$this->_charset}",
                $this->_user,
                $this->_password
            );
        }
    }

    /**
     * Get PDO
     *
     * @return PDO
     */
    public function getPDO()
    {
        return $this->_pdo;
    }
}