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

namespace Drift;

use Drift\HttpKernel\AsyncKernel;
use Exception;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\RouteCollectionBuilder;

use function dirname;

/**
 * Class Kernel.
 */
class Kernel extends AsyncKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        $contents = require $this->getApplicationLayerDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class($this);
            }
        }
    }

    private function getApplicationLayerDir(): string
    {
        return $this->getProjectDir() . '/Drift';
    }

    public function getProjectDir(): string
    {
        return dirname(__DIR__);
    }

    /**
     * @throws Exception
     */
    protected function configureContainer(
        ContainerBuilder $container,
        LoaderInterface $loader
    ): void
    {
        $confDir = $this->getApplicationLayerDir() . '/config';
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || $this->debug);
        $container->setParameter('container.dumper.inline_factories', true);
        $loader->load($confDir . '/services.yml');
    }

    /**
     * @throws LoaderLoadException
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getApplicationLayerDir() . '/config';
        $routes->import($confDir . '/routes.yml');
    }
}
