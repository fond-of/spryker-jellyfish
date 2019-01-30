<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Plugin;

use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * Class JellyfishCompanyBusinessUnitDataExpanderPlugin
 * @package FondOfSpryker\Zed\Jellyfish\Dependency\Plugin
 */
class JellyfishCompanyBusinessUnitDataExpanderPlugin extends AbstractPlugin implements JellyfishCompanyBusinessUnitExpanderPluginInterface
{
    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface
     */
    protected $companyUnitAddressFacade;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade
     */
    public function __construct(
        JellyfishToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade
    ) {
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUnitAddressFacade = $companyUnitAddressFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    public function expand(
        JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer {
        if ($jellyfishCompanyBusinessUnitTransfer->getId()) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        if ($jellyfishCompanyBusinessUnitTransfer->getCompany() !== null) {
            return $this->expandByCompany($jellyfishCompanyBusinessUnitTransfer);
        }

        if ($jellyfishCompanyBusinessUnitTransfer->getBillingAddress() !== null) {
            return $this->expandByBillingAddress($jellyfishCompanyBusinessUnitTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    protected function expandByBillingAddress(
        JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer {

        $id = $jellyfishCompanyBusinessUnitTransfer->getBillingAddress()->getId();
        $companyUnitAddressTransfer = $this->companyUnitAddressFacade->getCompanyUnitAddressById($id);

        $companyBusinessUnitCollectionTransfer = $companyUnitAddressTransfer->getCompanyBusinessUnits();

        if ($companyBusinessUnitCollectionTransfer === null || !$companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits()->offsetExists(0)) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        $companyBusinessUnitTransfer = $companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits()
            ->offsetGet(0);

        return $this->expandByCompanyBusinessUnit($jellyfishCompanyBusinessUnitTransfer, $companyBusinessUnitTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    protected function expandByCompany(JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer {
        $companyBusinessUnitTransfer = $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId(
            $jellyfishCompanyBusinessUnitTransfer->getCompany()->getId()
        );

        if ($companyBusinessUnitTransfer !== null) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        return $this->expandByCompanyBusinessUnit($jellyfishCompanyBusinessUnitTransfer, $companyBusinessUnitTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    protected function expandByCompanyBusinessUnit(
        JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer {
        $jellyfishCompanyBusinessUnitTransfer->setId($companyBusinessUnitTransfer->getIdCompanyBusinessUnit())
            ->setExternalReference($companyBusinessUnitTransfer->getExternalReference())
            ->setEmail($companyBusinessUnitTransfer->getEmail());

        return $jellyfishCompanyBusinessUnitTransfer;
    }
}
