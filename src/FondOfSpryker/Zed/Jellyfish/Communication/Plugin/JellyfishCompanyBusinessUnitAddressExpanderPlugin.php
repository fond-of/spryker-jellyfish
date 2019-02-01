<?php

namespace FondOfSpryker\Zed\Jellyfish\Communication\Plugin;

use FondOfSpryker\Zed\Jellyfish\Business\Model\Checker\CompanyUnitAddressCheckerInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyUnitAddressCriteriaFilterTransfer;
use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\Business\JellyfishFacadeInterface getFacade()
 */
class JellyfishCompanyBusinessUnitAddressExpanderPlugin extends AbstractPlugin implements JellyfishCompanyBusinessUnitExpanderPluginInterface
{
    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface
     */
    protected $companyUnitAddressFacade;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapperInterface
     */
    protected $jellyfishCompanyUnitAddressMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Checker\CompanyUnitAddressCheckerInterface
     */
    protected $companyUnitAddressChecker;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapperInterface $jellyfishCompanyUnitAddressMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Checker\CompanyUnitAddressCheckerInterface $companyUnitAddressChecker
     */
    public function __construct(
        JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade,
        JellyfishCompanyUnitAddressMapperInterface $jellyfishCompanyUnitAddressMapper,
        CompanyUnitAddressCheckerInterface $companyUnitAddressChecker
    ) {
        $this->companyUnitAddressFacade = $companyUnitAddressFacade;
        $this->jellyfishCompanyUnitAddressMapper = $jellyfishCompanyUnitAddressMapper;
        $this->companyUnitAddressChecker = $companyUnitAddressChecker;
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    public function expand(
        JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer {
        if ($jellyfishCompanyBusinessUnitTransfer->getId() === null) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        $companyUnitAddressCriteriaFilterTransfer = new CompanyUnitAddressCriteriaFilterTransfer();

        $companyUnitAddressCriteriaFilterTransfer->setIdCompanyBusinessUnit($jellyfishCompanyBusinessUnitTransfer->getId());

        $companyUnitAddressCollectionTransfer = $this->companyUnitAddressFacade
            ->getCompanyUnitAddressCollection($companyUnitAddressCriteriaFilterTransfer);

        if ($companyUnitAddressCollectionTransfer === null) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        foreach ($companyUnitAddressCollectionTransfer->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
            $jellyfishCompanyUnitAddressTransfer = $this->jellyfishCompanyUnitAddressMapper
                ->fromCompanyUnitAddress($companyUnitAddressTransfer);

            if ($jellyfishCompanyBusinessUnitTransfer->getBillingAddress() === null
                && !$this->companyUnitAddressChecker->isDefaultBilling($companyUnitAddressTransfer)
            ) {
                $jellyfishCompanyBusinessUnitTransfer->addAddress($jellyfishCompanyUnitAddressTransfer);
                continue;
            }

            $jellyfishCompanyBusinessUnitTransfer->setBillingAddress($jellyfishCompanyUnitAddressTransfer);
        }

        return $jellyfishCompanyBusinessUnitTransfer;
    }
}
