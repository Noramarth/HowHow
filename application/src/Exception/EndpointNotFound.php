<?php

declare(strict_types=1);

namespace App\Exception;

use App\Interfaces\Exception\Breaking;
use Exception;
use Throwable;

class EndpointNotFound extends Exception implements Breaking
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $code = 0 === $code ? 300 : $code;
        parent::__construct($message, $code, $previous);
    }
}
