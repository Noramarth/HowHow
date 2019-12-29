<?php

declare(strict_types=1);

namespace App\Exception\Database;

use App\lib\Interfaces\Exception\Breaking;
use Exception;
use Throwable;

class RepositoryNotAvailable extends Exception implements Breaking
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = 'Asking for repositories in a writer class is bad juju,' .
            ' please make sure you are using a reader for this instead';
        parent::__construct($message, $code, $previous);
    }
}
