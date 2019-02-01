<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\Business\JellyfishBusinessFactory getFactory()
 */
class JellyfishFacade extends AbstractFacade implements JellyfishFacadeInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportCompanyBulk(array $transfers): void
    {
        $this->getFactory()->createCompanyExporter()->exportBulk($transfers);
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportCompanyBusinessUnitBulk(array $transfers): void
    {
        $this->getFactory()->createCompanyBusinessUnitExporter()->exportBulk($transfers);
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportCompanyUnitAddressBulk(array $transfers): void
    {
        $this->getFactory()->createCompanyUnitAddressExporter()->exportBulk($transfers);
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportCustomerBulk(array $transfers): void
    {
        $this->getFactory()->createCustomerExporter()->exportBulk($transfers);
    }
}
