<?php
/**
 * This file is part of Core_Database for DiscordInvites.
 *
 * @license All rights reserved
 * @author <support@dinvites.net> <support-discordinvites>
 * @category Core
 * @package Core
 * @copyright Copyright (c) 2020 DiscordInvites (https://discordinvites.net/)
 */

namespace Models\Core;
use PDO;
use PDOStatement;

/**
 * Class Database
 * @package Core
 */
class Database
{
    /**
     * PDO instancie
     * @var PDO
     */
    public $_pdo;

    /**
     * Params to connect with PDO to database
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
            $this->_pdo = new PDO("mysql:host={$this->_hostname};dbname={$this->_database};charset={$this->_charset}", $this->_user, $this->_password);
        }
    }

    /**
     * Check if request is a success
     *
     * @param PDOStatement $req
     * @return bool
     */
    public function isSuccess(PDOStatement $req)
    {
        return $req->rowCount() > 0;
    }

    /**
     * Get config
     *
     * @param $code
     * @return bool
     */
    public function getConfig($code)
    {
        $this->initPDO();
        $req = $this->_pdo->prepare('SELECT * FROM config WHERE code = ?');
        $req->execute([$code]);
        if ($this->isSuccess($req)) {
            $config = $req->fetch();
            return $config['value'];
        }
        return false;
    }

    /**
     * Set config
     *
     * @param $code
     * @param $value
     * @return bool
     */
    public function setConfig($code, $value)
    {
        $this->initPDO();
        $req = $this->_pdo->prepare('UPDATE config SET value = ? WHERE code = ?');
        $req->execute([
            $value,
            $code
        ]);
        return $this->isSuccess($req);
    }
}