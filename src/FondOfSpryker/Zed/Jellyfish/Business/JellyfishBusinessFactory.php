<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\OrderAdapter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\OrderExporter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\OrderExporterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderAddressMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderAddressMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderDiscountMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderDiscountMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderExpenseMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderExpenseMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderPaymentMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderPaymentMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderTotalsMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderTotalsMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface;
use FondOfSpryker\Zed\Jellyfish\JellyfishDependencyProvider;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\JellyfishConfig getConfig()
 */
class JellyfishBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\OrderExporterInterface
     */
    public function createOrderExporter(): OrderExporterInterface
    {
        return new OrderExporter(
            $this->createJellyfishOrderMapper(),
            $this->createJellyfishOrderItemMapper(),
            $this->createOrderAdapter()
        );
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function createHttpClient(): HttpClientInterface
    {
        return new HttpClient([
            'base_uri' => $this->getConfig()->getBaseUri(),
            'timeout' => $this->getConfig()->getTimeout(),
        ]);
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapperInterface
     */
    protected function createJellyfishOrderMapper(): JellyfishOrderMapperInterface
    {
        return new JellyfishOrderMapper(
            $this->createJellyfishOrderAddressMapper(),
            $this->createJellyfishOrderExpenseMapper(),
            $this->createJellyfishOrderDiscountMapper(),
            $this->createJellyfishOrderPaymentMapper(),
            $this->createJellyfishOrderTotalsMapper(),
            $this->getOrderExpanderPostMapPlugins(),
            $this->getConfig()->getSystemCode()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderAddressMapperInterface
     */
    protected function createJellyfishOrderAddressMapper(): JellyfishOrderAddressMapperInterface
    {
        return new JellyfishOrderAddressMapper(
            $this->getOrderAddressExpanderPostMapPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderExpenseMapperInterface
     */
    protected function createJellyfishOrderExpenseMapper(): JellyfishOrderExpenseMapperInterface
    {
        return new JellyfishOrderExpenseMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderDiscountMapperInterface
     */
    protected function createJellyfishOrderDiscountMapper(): JellyfishOrderDiscountMapperInterface
    {
        return new JellyfishOrderDiscountMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderPaymentMapperInterface
     */
    protected function createJellyfishOrderPaymentMapper(): JellyfishOrderPaymentMapperInterface
    {
        return new JellyfishOrderPaymentMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderTotalsMapperInterface
     */
    protected function createJellyfishOrderTotalsMapper(): JellyfishOrderTotalsMapperInterface
    {
        return new JellyfishOrderTotalsMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapperInterface
     */
    protected function createJellyfishOrderItemMapper(): JellyfishOrderItemMapperInterface
    {
        return new JellyfishOrderItemMapper(
            $this->getOrderItemExpanderPostMapPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface
     */
    protected function createOrderAdapter(): AdapterInterface
    {
        return new OrderAdapter(
            $this->getUtilEncodingService(),
            $this->createHttpClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface
     */
    protected function getUtilEncodingService(): JellyfishToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderExpanderPostMapPluginInterface[]
     */
    protected function getOrderExpanderPostMapPlugins(): array
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP);
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface[]
     */
    protected function getOrderItemExpanderPostMapPlugins(): array
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP);
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[]
     */
    protected function getOrderAddressExpanderPostMapPlugins(): array
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP);
    }
}
