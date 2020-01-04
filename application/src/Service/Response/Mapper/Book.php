<?php

declare(strict_types=1);

namespace App\Service\Response\Mapper;

use App\Constant\Common;
use App\lib\Abstracts\Mapper\ORMEntity;
use App\lib\Interfaces\SerializableResponse;
use Psr\Cache\InvalidArgumentException;
use ReflectionException;
use Symfony\Contracts\Cache\ItemInterface;

class Book extends ORMEntity implements SerializableResponse
{
    /** @var mixed */
    public $data;

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function mapMultiple(array $items, ?int $depth = 2): Book
    {
        if ($this->useCache) {
            $this->data = $this->cache->get(
                'all_books_depth_' . $depth,
                function (ItemInterface $cachedItem) use ($items, $depth) {
                    $result = $this->setRecursive()->recursionsDepth($depth)-> parseMultiple($items);
                    $cachedItem->set($result);
                    $cachedItem->expiresAfter(Common::CACHE_EXPIRATION_TIME);
                    return $result;
                }
            );
        } else {
            $this->data = $this->setRecursive()->recursionsDepth($depth)->parseMultiple($items);
        }
        return $this;
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function mapOne(object $item): Book
    {
        $this->data = $this->parseOne($item);
    }
}
