<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\Business\JellyfishBusinessFactory getFactory()
 */
class JellyfishFacade extends AbstractFacade implements JellyfishFacadeInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function exportOrder(SpySalesOrder $orderEntity, array $orderItems): void
    {
        $this->getFactory()->createOrderExporter()->export($orderEntity, $orderItems);
    }
}
