<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter;

use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Shared\Log\LoggerTrait;

class CompanyUnitAddressExporter implements ExporterInterface
{
    use LoggerTrait;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade
     */
    protected $companyUnitAddressFacade;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface[]
     */
    protected $jellyfishCompanyBusinessUnitExpanderPlugins;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapperInterface
     */
    protected $jellyfishCompanyBusinessUnitMapper;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapperInterface $jellyfishCompanyBusinessUnitMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface[] $jellyfishCompanyBusinessUnitExpanderPlugins
     */
    public function __construct(
        JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade,
        JellyfishCompanyBusinessUnitMapperInterface $jellyfishCompanyBusinessUnitMapper,
        array $jellyfishCompanyBusinessUnitExpanderPlugins
    ) {
        $this->jellyfishCompanyBusinessUnitExpanderPlugins = $jellyfishCompanyBusinessUnitExpanderPlugins;
        $this->companyUnitAddressFacade = $companyUnitAddressFacade;
        $this->jellyfishCompanyBusinessUnitMapper = $jellyfishCompanyBusinessUnitMapper;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportBulk(array $transfers): void
    {
        foreach ($transfers as $transfer) {
            if (!$this->canExport($transfer)) {
                continue;
            }

            $this->exportById($transfer->getId());
        }
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return bool
     */
    protected function canExport(TransferInterface $transfer): bool
    {
        return $transfer instanceof EventEntityTransfer &&
            count($transfer->getModifiedColumns()) > 0 &&
            $transfer->getName() === 'spy_company_unit_address';
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    protected function map(CompanyUnitAddressTransfer $companyUnitAddressTransfer): JellyfishCompanyBusinessUnitTransfer
    {
        return $this->jellyfishCompanyBusinessUnitMapper->fromCompanyUnitAddress($companyUnitAddressTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    protected function expand(
        JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer {
        foreach ($this->jellyfishCompanyBusinessUnitExpanderPlugins as $jellyfishCompanyBusinessUnitExpanderPlugin) {
            $jellyfishCompanyBusinessUnitTransfer = $jellyfishCompanyBusinessUnitExpanderPlugin
                ->expand($jellyfishCompanyBusinessUnitTransfer);
        }

        return $jellyfishCompanyBusinessUnitTransfer;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function exportById(int $id): void
    {
        $companyUnitAddressTransfer = new CompanyUnitAddressTransfer();
        $companyUnitAddressTransfer->setIdCompanyUnitAddress($id);

        $companyUnitAddressTransfer = $this->companyUnitAddressFacade
            ->getCompanyUnitAddressById($companyUnitAddressTransfer);

        if ($companyUnitAddressTransfer === null || $companyUnitAddressTransfer->getIdCompanyUnitAddress() === null) {
            return;
        }

        $jellyfishCompanyBusinessUnitTransfer = $this->map($companyUnitAddressTransfer);
        $jellyfishCompanyBusinessUnitTransfer = $this->expand($jellyfishCompanyBusinessUnitTransfer);

        $this->getLogger()->error($jellyfishCompanyBusinessUnitTransfer->serialize());
    }
}
