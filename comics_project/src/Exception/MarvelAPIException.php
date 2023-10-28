<?php

namespace App\Exception;

use Exception;

class MarvelAPIException extends Exception
{
    public function __construct($message, $code = 400)
    {
        parent::__construct($message, $code);
    }
}
