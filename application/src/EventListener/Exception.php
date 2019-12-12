<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Interfaces\Exception\Breaking;
use App\Interfaces\Exception\Collectible;
use App\lib\ErrorCollector;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class Exception
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof Breaking) {
            $this->logger->log(
                LogLevel::ERROR,
                var_export(
                    [
                        'errors' => [
                            'last' => [
                                'message' => $exception->getMessage(),
                                'file' => $exception->getFile(),
                                'line' => $exception->getLine(),
                                'trace' => $exception->getTraceAsString()
                            ],
                            'previous' => ErrorCollector::getCollectedExceptions()
                        ]
                    ]
                )
            );
            $event->setResponse(
                JsonResponse::create(
                    [
                        'status' => 'error',
                        'code' => $event->getThrowable()->getCode(),
                    ]
                )
            );
        }
    }


}