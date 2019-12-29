<?php

declare(strict_types=1);

namespace App\Exception;

use App\lib\Interfaces\Exception\Breaking;
use Exception;
use Throwable;

class UnexpectedPayloadForEndpoint extends Exception implements Breaking
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = 'Unexpected payload for endpoint';
        $code = 301;
        parent::__construct($message, $code, $previous);
    }
}
