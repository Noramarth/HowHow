<?php

declare(strict_types=1);

namespace App\Exception;

use App\lib\Interfaces\Exception\Breaking;

class InvalidPropertyProvided extends \Exception implements Breaking
{
}
