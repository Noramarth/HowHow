<?php

declare(strict_types=1);

namespace App\lib;

use App\EventListener\Exception;
use App\Exception\VisibilityBreach;
use App\Interfaces\Exception\Collectible;
use App\Service\Main;

class ErrorCollector
{
    private const ALLOWED_CALLERS = [
        Main::class,
        self::class,
        Exception::class,
    ];
    private static ?ErrorCollector $instance = null;
    private array $exceptions = [];

    private function __construct()
    {
    }

    public static function getCollectedExceptions(): array
    {
        $collection = [];
        $exceptions = self::getInstance()->flush();
        foreach ($exceptions as $exception) {
            $collection[] = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
        }

        return $collection;
    }

    public function flush(): array
    {
        $exceptions = $this->exceptions;
        $this->reset();

        return $exceptions;
    }

    public function reset(): void
    {
        $this->exceptions = [];
        self::$instance = null;
    }

    public static function getInstance(): self
    {
        if (false === array_search(self::getCallingClass(), self::ALLOWED_CALLERS)) {
            throw new VisibilityBreach();
        }

        if (null === self::$instance) {
            self::$instance = new ErrorCollector();
        }

        return self::$instance;
    }

    private static function getCallingClass(): string
    {
        $trace = debug_backtrace();
        $class = $trace[1]['class'];
        for ($i = 1; $i < count($trace); ++$i) {
            if (isset($trace[$i])) {
                if ($class != $trace[$i]['class']) {
                    return $trace[$i]['class'];
                }
            }
        }
    }

    public function add(Collectible $exception): void
    {
        $this->exceptions[] = $exception;
    }

    private function __clone()
    {
    }
}
