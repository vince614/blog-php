<?php
namespace Core\Utils;

use Core\Models\Database;

require_once 'Request.php';

/**
 * Class GoogleRecaptcha
 * @package Core\Utils
 */
class GoogleRecaptcha extends Database
{
    const GOOGLE_RECAPTCHA_API_URL = "https://www.google.com/recaptcha/api/siteverify";

    private $_publicKey;
    private $_secretKey;

    /**
     * @var Request
     */
    protected $_request;

    public function __construct($publicKey, $secretKey)
    {
        parent::__construct();
        $this->_publicKey = $publicKey;
        $this->_secretKey = $secretKey;
        $this->_request = new Request();
    }

    /**
     * Google Recaptcha
     *
     * @return bool
     */
    public function googleRecaptchaVerification()
    {
        if ($this->_request->isPost()) {
            $gRecaptchaResponse = $this->_request->getPost('g-recaptcha-response');
            if ($gRecaptchaResponse) {
                return $this->validateCaptcha(
                    $gRecaptchaResponse,
                    $this->_secretKey
                );
            }
        }
        return false;
    }

    /**
     * Validate captcha
     *
     * @param $response
     * @param $secretKey
     * @return bool
     */
    public function validateCaptcha($response, $secretKey)
    {
        $verifyResponse = file_get_contents(self::GOOGLE_RECAPTCHA_API_URL . '?secret=' . $secretKey . '&response=' . $response);
        $responseData = json_decode($verifyResponse);
        if ($responseData->success) return true;
        return false;
    }
}