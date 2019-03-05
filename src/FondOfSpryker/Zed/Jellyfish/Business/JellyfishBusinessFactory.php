<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\OrderAdapter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\OrderExporter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\OrderExporterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapperInterface;
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
        return new JellyfishOrderMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapperInterface
     */
    protected function createJellyfishOrderItemMapper(): JellyfishOrderItemMapperInterface
    {
        return new JellyfishOrderItemMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface
     */
    protected function createOrderAdapter(): AdapterInterface
    {
        return new OrderAdapter(
            $this->getUtilEncodingService(),
            $this->createHttpClient(),
            $this->getConfig()->dryRun()
        );
    }

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
     * @throws
     *
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface
     */
    protected function getUtilEncodingService(): JellyfishToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::UTIL_ENCODING_SERVICE);
    }
}
