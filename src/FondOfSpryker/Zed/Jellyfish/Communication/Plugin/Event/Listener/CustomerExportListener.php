<?php

namespace FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Listener;

use FondOfSpryker\Zed\Jellyfish\Dependency\JellyfishEvents;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\Business\JellyfishFacadeInterface getFacade()
 */
class CustomerExportListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use LoggerTrait;

    /**
     * Specification
     *  - Listeners needs to implement this interface to execute the codes for more
     *  than one event at same time (Bulk Operation)
     *
     * @api
     *
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $transfers, $eventName): void
    {
        if ($eventName === JellyfishEvents::ENTITY_SPY_CUSTOMER_CREATE
            || $eventName === JellyfishEvents::ENTITY_SPY_CUSTOMER_UPDATE
        ) {
            $this->getFacade()->exportCustomerBulk($transfers);
        }
    }
}
