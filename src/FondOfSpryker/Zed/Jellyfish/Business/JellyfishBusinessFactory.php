<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\CompanyBusinessUnitAdapter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\CompanyExporter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\ExporterInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToEventBehaviorFacadeInterface;
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
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\ExporterInterface
     */
    public function createCompanyExporter(): ExporterInterface
    {
        return new CompanyExporter(
            $this->getCompanyFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface
     */
    protected function createCompanyBusinessUnitAdapter(): AdapterInterface
    {
        return new CompanyBusinessUnitAdapter(
            $this->getUtilEncodingService(),
            $this->createHttpClient(),
            $this->getConfig()->dryRun()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface
     */
    protected function createCompanyUserAdapter(): AdapterInterface
    {
        return new CompanyBusinessUnitAdapter(
            $this->getUtilEncodingService(),
            $this->createHttpClient(),
            $this->getConfig()->dryRun()
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
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): JellyfishToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::UTIL_ENCODING_SERVICE);
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToEventBehaviorFacadeInterface
     */
    public function getCompanyFacade(): JellyfishToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::COMPANY_FACADE);
    }
}
