<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BadHeaders;
use App\Exception\EndpointNotFound;
use App\Exception\VisibilityBreach;
use App\lib\ErrorCollector;
use App\lib\Interfaces\Exception\Collectible;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use React\Promise\FulfilledPromise;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Main.
 */
class Main
{
    private EndpointManager $endpoint;

    private LoggerInterface $logger;

    public function __construct(EndpointManager $endpoint, LoggerInterface $logger)
    {
        $this->endpoint = $endpoint;
        $this->logger = $logger;
    }

    /**
     * Default path.
     *
     * @return FulfilledPromise|JsonResponse
     *
     * @throws VisibilityBreach
     * @throws BadHeaders
     * @throws EndpointNotFound
     */
    public function __invoke(Request $request)
    {
        try {
            $response = $this->endpoint->get()->handle();

            return new FulfilledPromise(
                new JsonResponse($response, Response::HTTP_OK)
            );
        } catch (Collectible $exception) {
            ErrorCollector::getInstance()->add($exception);
            $this->logger->log(
                LogLevel::ERROR,
                var_export(
                    ErrorCollector::getCollectedExceptions()
                )
            );

            return new JsonResponse(
                'Errors occurred, please check logs for more details',
                Response::HTTP_I_AM_A_TEAPOT
            );
        }
    }
}
