<?php

declare(strict_types=1);

namespace App\Exception;

use App\lib\Interfaces\Exception\Breaking;
use Exception;
use Throwable;

class Writing extends Exception implements Breaking
{
    public function __construct(Throwable $exception)
    {
        parent::__construct($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
    }
}
