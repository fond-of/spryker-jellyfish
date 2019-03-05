<?php

namespace FondOfSpryker\Zed\Jellyfish;

use FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class JellyfishDependencyProvider extends AbstractBundleDependencyProvider
{
    public const UTIL_ENCODING_SERVICE = 'UTIL_ENCODING_SERVICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addUtilEncodingService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::UTIL_ENCODING_SERVICE] = function (Container $container) {
            return new JellyfishToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service()
            );
        };

        return $container;
    }
}
