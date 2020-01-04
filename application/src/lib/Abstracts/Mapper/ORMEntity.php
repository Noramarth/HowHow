<?php

declare(strict_types=1);

namespace App\lib\Abstracts\Mapper;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;

abstract class ORMEntity extends Base
{
}