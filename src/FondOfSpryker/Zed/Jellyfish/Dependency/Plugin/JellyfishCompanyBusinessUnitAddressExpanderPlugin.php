<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Plugin;

use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface;
use Generated\Shared\Transfer\CompanyUnitAddressCriteriaFilterTransfer;
use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

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
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUnitAddressMapperInterface $jellyfishCompanyUnitAddressMapper
     */
    public function __construct(
        JellyfishToCompanyUnitAddressFacadeInterface $companyUnitAddressFacade,
        JellyfishCompanyUnitAddressMapperInterface $jellyfishCompanyUnitAddressMapper
    ) {
        $this->companyUnitAddressFacade = $companyUnitAddressFacade;
        $this->jellyfishCompanyUnitAddressMapper = $jellyfishCompanyUnitAddressMapper;
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

            if (!$companyUnitAddressTransfer->getIsDefaultBilling()) {
                $jellyfishCompanyBusinessUnitTransfer->addAddress($jellyfishCompanyUnitAddressTransfer);
                continue;
            }

            $jellyfishCompanyBusinessUnitTransfer->setBillingAddress($jellyfishCompanyUnitAddressTransfer);
        }

        return $jellyfishCompanyBusinessUnitTransfer;
    }
}
