<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\CompanyBusinessUnitAdapter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\CompanyExporter;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter\ExporterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapper;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyFacadeInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitAddressExpanderPlugin;
use FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitCompanyExpanderPlugin;
use FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitDataExpanderPlugin;
use FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface;
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
            $this->getCompanyFacade(),
            $this->createCompanyBusinessUnitMapper(),
            $this->createCompanyExporterExpanderPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapperInterface
     */
    protected function createCompanyBusinessUnitMapper(): JellyfishCompanyBusinessUnitMapperInterface
    {
        return new JellyfishCompanyBusinessUnitMapper(
            $this->createCompanyMapper()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapperInterface
     */
    protected function createCompanyMapper(): JellyfishCompanyMapperInterface
    {
        return new JellyfishCompanyMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapperInterface
     */
    protected function createCompanyUnitAddressMapper(): JellyfishCompanyUnitAddressMapperInterface
    {
        return new JellyfishCompanyUnitAddressMapper();
    }

    /**
     * @return array
     */
    protected function createCompanyExporterExpanderPlugins(): array
    {
        return [
            $this->createCompanyBusinessUnitDataExpanderPlugin(),
            $this->createCompanyBusinessUnitAddressExpanderPlugin(),
            $this->createCompanyBusinessUnitCompanyExpanderPlugin(),
        ];
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface
     */
    protected function createCompanyBusinessUnitDataExpanderPlugin(): JellyfishCompanyBusinessUnitExpanderPluginInterface
    {
        return new JellyfishCompanyBusinessUnitDataExpanderPlugin(
            $this->getCompanyBusinessUnitFacade(),
            $this->getCompanyUnitAddressFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface
     */
    protected function createCompanyBusinessUnitAddressExpanderPlugin(): JellyfishCompanyBusinessUnitExpanderPluginInterface
    {
        return new JellyfishCompanyBusinessUnitAddressExpanderPlugin(
            $this->getCompanyUnitAddressFacade(),
            $this->createCompanyUnitAddressMapper()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface
     */
    protected function createCompanyBusinessUnitCompanyExpanderPlugin(): JellyfishCompanyBusinessUnitExpanderPluginInterface
    {
        return new JellyfishCompanyBusinessUnitCompanyExpanderPlugin(
            $this->getCompanyBusinessUnitFacade(),
            $this->createCompanyMapper()
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
     * @throws
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): JellyfishToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::UTIL_ENCODING_SERVICE);
    }

    /**
     * @throws
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyFacadeInterface
     */
    public function getCompanyFacade(): JellyfishToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::COMPANY_FACADE);
    }

    /**
     * @throws
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface
     */
    public function getCompanyBusinessUnitFacade(): JellyfishToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::COMPANY_BUSINESS_UNIT_FACADE);
    }

    /**
     * @throws
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface
     */
    public function getCompanyUnitAddressFacade(): JellyfishToCompanyUnitAddressFacadeInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::COMPANY_UNIT_ADDRESS_FACADE);
    }
}
