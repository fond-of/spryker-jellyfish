<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Plugin;

use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitAddressTransfer;
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
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     */
    public function __construct(JellyfishToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade)
    {
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    public function expand(
        JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer
    {
        if ($jellyfishCompanyBusinessUnitTransfer->getId()) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        if ($jellyfishCompanyBusinessUnitTransfer->getCompany() !== null) {
            return $this->expandByCompany($jellyfishCompanyBusinessUnitTransfer);
        }

        if (count($jellyfishCompanyBusinessUnitTransfer->getAddresses()) !== 0) {
            return $this->expandByAddress($jellyfishCompanyBusinessUnitTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    protected function expandByAddress(JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer): JellyfishCompanyBusinessUnitTransfer
    {

        $jellyfishCompanyBusinessUnitAddressTransfer = $jellyfishCompanyBusinessUnitTransfer->getAddresses()[0];
        $jellyfishCompanyBusinessUnitAddressTransfer->getCompanyBusinessUnitId();



        $companyBusinessUnit = $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId(
            $jellyfishCompanyBusinessUnitTransfer->getCompany()->getId()
        );

        if ($companyBusinessUnit !== null) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        $jellyfishAddresses = [];
        foreach ($companyBusinessUnit->getAddressCollection()->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
            $jellyfishCompanyBusinessUnitAddressTransfer = new JellyfishCompanyBusinessUnitAddressTransfer();
            $jellyfishCompanyBusinessUnitAddressTransfer->setId($companyUnitAddressTransfer->getIdCompanyUnitAddress());

            $jellyfishAddresses[] = $jellyfishCompanyBusinessUnitAddressTransfer;
        }


        $jellyfishCompanyBusinessUnitTransfer->setId($companyBusinessUnit->getIdCompanyBusinessUnit());
        $jellyfishCompanyBusinessUnitTransfer->setAddresses($jellyfishAddresses);

        return $jellyfishCompanyBusinessUnitTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    protected function expandByCompany(JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer): JellyfishCompanyBusinessUnitTransfer
    {
        $companyBusinessUnit = $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId(
            $jellyfishCompanyBusinessUnitTransfer->getCompany()->getId()
        );

        if ($companyBusinessUnit !== null) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }


        $jellyfishCompanyBusinessUnitTransfer->setId($companyBusinessUnit->getIdCompanyBusinessUnit());


        $jellyfishAddresses = [];
        foreach ($companyBusinessUnit->getAddressCollection()->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
            $jellyfishCompanyBusinessUnitAddressTransfer = new JellyfishCompanyBusinessUnitAddressTransfer();
            $jellyfishCompanyBusinessUnitAddressTransfer->setId($companyUnitAddressTransfer->getIdCompanyUnitAddress());
            $jellyfishCompanyBusinessUnitAddressTransfer->setCompanyBusinessUnitId($companyBusinessUnit->getIdCompanyBusinessUnit());

            $jellyfishCompanyBusinessUnitTransfer->addAddress($jellyfishCompanyBusinessUnitAddressTransfer);
        }

        return $jellyfishCompanyBusinessUnitTransfer;
    }


}
