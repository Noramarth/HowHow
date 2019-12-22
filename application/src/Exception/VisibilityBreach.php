<?php

namespace App\Exception;

use App\lib\Interfaces\Exception\Breaking;
use Exception;

class VisibilityBreach extends Exception implements Breaking
{
}
