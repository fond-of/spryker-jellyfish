<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\Business\JellyfishBusinessFactory getFactory()
 */
class JellyfishFacade extends AbstractFacade implements JellyfishFacadeInterface
{
    use LoggerTrait;

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportCompanyBulk(array $transfers): void
    {
        $this->getFactory()->createCompanyExporter()->exportBulk($transfers);
    }
}
