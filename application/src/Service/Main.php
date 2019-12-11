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

use App\Constant\Connection;
use App\Interfaces\Service;
use React\Promise\FulfilledPromise;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Main.
 *
 * You can run this action by making `curl` to /
 */
class Main
{
    /**
     * Default path.
     * @param Request $request
     * @return FulfilledPromise
     */
    public function __invoke(Request $request)
    {
        $endpoint = "App\\Endpoint\\" . ucfirst($request->headers->get(Connection::ENDPOINT_HEADER));
        /** @var  Service $service */
        $service = (new $endpoint);
        if ($service->supports($request)) {
            return new FulfilledPromise(
                new JsonResponse($service->handle($request), 200)
            );
        }
        return new JsonResponse('Endpoint not supported', 500);
    }
}
