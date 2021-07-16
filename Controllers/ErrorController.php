<?php
/**
 * This file is part of Controllers_Error for DiscordInvites.
 *
 * @license All rights reserved
 * @author <support@dinvites.net> <support-discordinvites>
 * @category Controllers
 * @package Controllers
 * @copyright Copyright (c) 2020 DiscordInvites (https://discordinvites.net/)
 */

namespace Controllers;

use Controllers\Core\Controller;

/**
 * Class ErrorController
 * @package Controllers
 */
class ErrorController extends Controller
{

    public function __construct($path)
    {
        $this->render($path);
    }

    /**
     * Index
     *
     * @param $path
     */
    public function render($path)
    {
        if (!isset($path)) {
            $this->notFound();
            return;
        }
        $viewFile = 'Views/Errors/' . $path . '.phtml';
        require $viewFile;
    }

}