<?php

namespace FondOfSpryker\Zed\Jellyfish;

use FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class JellyfishDependencyProvider extends AbstractBundleDependencyProvider
{
    public const UTIL_ENCODING_SERVICE = 'UTIL_ENCODING_SERVICE';
    public const JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP_PLUGINS = 'JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP_PLUGINS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addUtilEncodingService($container);
        $container = $this->addJellyfishOrderItemExpanderPostMapPlugins($container);

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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addJellyfishOrderItemExpanderPostMapPlugins(Container $container): Container
    {
        $container[static::JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP_PLUGINS] = function (Container $container) {
            return $this->getJellyfishOrderItemExpanderPostMapPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface[]
     */
    protected function getJellyfishOrderItemExpanderPostMapPlugins(): array
    {
        return [];
    }
}
