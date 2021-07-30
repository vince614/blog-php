<?php
use Models\Core\Database;

/**
 * Require class Database
 */
require_once __DIR__ . '/Models/Core/Database.php';

/**
 * Class General
 * @package General
 */
class General extends Database
{

    /**
     * Secure & Unsecure base URL
     * Configuration in database
     */
    const UNSECURE_URL_CODE = 'unsecure_url';
    const SECURE_URL_CODE = 'secure_url';

    /**
     * Maintenance code
     * Configuration in database
     */
    const MAINTENANCE_CODE = "maintenance_mode";

    /**
     * Host (domain)
     * @var string
     */
    public $_host;

    /**
     * Local mode
     * @var bool
     */
    public $localMode;

    /**
     * Get url with GET_METHOD
     *
     * @return string
     */
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            return $_GET['url'];
        }
        return '/';
    }

    /**
     * Set host with config table
     */
    private function _initHost()
    {
        parent::__construct();
        $req = $this->_pdo->prepare("SELECT * FROM config");
        $req->execute();
        $config = $req->fetchAll();
        foreach ($config as $item) {
            $code = $item['code'];
            if ($code === self::SECURE_URL_CODE && $item['value']) {
                $this->_host = $item['value'];
            } else if ($code === self::UNSECURE_URL_CODE) {
                $this->_host = $item['value'];
            }
        }
        $this->localMode = $this->getConfig('local_mode') == 1;
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        if (!$this->_host) {
            $this->_initHost();
        }
    }

    /**
     * Get current path
     *
     * @return string
     */
    public function getCurrentPath()
    {
        $currentUrl = $this->getCurrentDomain() . $_SERVER['REQUEST_URI'];
        return str_replace($this->getHost() . '/', "", $currentUrl);
    }

    /**
     * Get current domain
     *
     * @return string
     */
    public function getCurrentDomain()
    {
        return "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'];
    }

    /**
     * Start
     *
     * @param $currentPage
     */
    public function start($currentPage)
    {

    }

    /**
     * Check for maintenance
     */
    private function _checkForMaintenance()
    {
        $req = $this->_pdo->prepare('SELECT * FROM config WHERE code = ?');
        $req->execute([self::MAINTENANCE_CODE]);
        $config = $req->fetch();
        if ($config['value'] == 1 && !$this->_isAdmin()) {
            require 'Views/Blocks/Error/maintenance.phtml';
            exit;
        }
    }

    /**
     * Check if user is banned
     */
    private function _checkForBanned()
    {

    }

    /**
     * Check admin
     */
    private function _isAdmin() {

    }

}