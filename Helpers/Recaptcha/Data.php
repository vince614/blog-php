<?php
/**
 * This file is part of Helper_Recaptcha for DiscordInvites.
 *
 * @license All rights reserved
 * @author <support@dinvites.net> <support-discordinvites>
 * @category Recaptcha
 * @package Recaptcha
 * @copyright Copyright (c) 2021 DiscordInvites (https://discordinvites.net/)
 */

namespace Helpers\Recaptcha;

use Helpers\Core\Helper;

class Data extends Helper
{

    /**
     * Validate captcha
     *
     * @param $response
     * @param $secretKey
     * @return bool
     */
    public function validateCaptcha($response, $secretKey)
    {
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $response);
        $responseData = json_decode($verifyResponse);
        if ($responseData->success) {
            return true;
        }
        return false;
    }

}