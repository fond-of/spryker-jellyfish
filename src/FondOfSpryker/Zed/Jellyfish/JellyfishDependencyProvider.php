<?php

namespace FondOfSpryker\Zed\Jellyfish;

use FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class JellyfishDependencyProvider extends AbstractBundleDependencyProvider
{
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';
    public const PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP = 'PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP';
    public const PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP = 'PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP';
    public const PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP = 'PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addUtilEncodingService($container);
        $container = $this->addJellyfishOrderAddressExpanderPostMapPlugins($container);
        $container = $this->addJellyfishOrderExpanderPostMapPlugins($container);
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
        $container[static::SERVICE_UTIL_ENCODING] = static function (Container $container) {
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
    protected function addJellyfishOrderExpanderPostMapPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP] = static function () use ($self) {
            return $self->getJellyfishOrderExpanderPostMapPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderExpanderPostMapPluginInterface[]
     */
    protected function getJellyfishOrderExpanderPostMapPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addJellyfishOrderItemExpanderPostMapPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP] = static function () use ($self) {
            return $self->getJellyfishOrderItemExpanderPostMapPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface[]
     */
    protected function getJellyfishOrderItemExpanderPostMapPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addJellyfishOrderAddressExpanderPostMapPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP] = static function () use ($self) {
            return $self->getJellyfishOrderAddressExpanderPostMapPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[]
     */
    protected function getJellyfishOrderAddressExpanderPostMapPlugins(): array
    {
        return [];
    }
}
