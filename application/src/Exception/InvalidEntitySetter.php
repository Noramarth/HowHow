<?php

declare(strict_types=1);

namespace App\Exception;

use App\Interfaces\Exception\Breaking;

class InvalidEntitySetter extends \Exception implements Breaking
{
}
