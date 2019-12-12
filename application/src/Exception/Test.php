<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use App\Interfaces\Exception\Collectible;

class Test extends Exception implements Collectible
{
}