<?php

namespace App\Exception;

use App\Interfaces\Exception\Breaking;
use Exception;

class VisibilityBreach extends Exception implements Breaking
{
}
