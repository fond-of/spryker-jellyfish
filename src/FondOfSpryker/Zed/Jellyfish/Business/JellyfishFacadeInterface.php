<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

use Orm\Zed\Sales\Persistence\SpySalesOrder;

interface JellyfishFacadeInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function exportOrder(SpySalesOrder $orderEntity, array $orderItems): void;
}
