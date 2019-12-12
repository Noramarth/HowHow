<?php

/*
 * This file is part of the DriftPHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace App\Service;

use App\Exception\VisibilityBreach;
use App\Interfaces\Endpoint;
use App\Interfaces\Exception\Collectible;
use App\lib\ErrorCollector;
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

    private Endpoint $endpoint;

    private LoggerInterface $logger;

    public function __construct(Endpoint $endpoint, LoggerInterface $logger)
    {
        $this->endpoint = $endpoint;
        $this->logger = $logger;
    }

    /**
     * Default path.
     * @param Request $request
     * @return FulfilledPromise|JsonResponse
     * @throws VisibilityBreach
     */
    public function __invoke(Request $request)
    {
        try {
            return new FulfilledPromise(
                new JsonResponse($this->endpoint->handle(), Response::HTTP_OK)
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
