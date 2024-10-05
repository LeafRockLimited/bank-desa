<?php

namespace App\Exceptions;

use Exception;

class RedirectException extends Exception
{
    protected $redirectUrl;

    public function __construct($message, $redirectUrl)
    {
        parent::__construct($message);
        $this->redirectUrl = $redirectUrl;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
}
