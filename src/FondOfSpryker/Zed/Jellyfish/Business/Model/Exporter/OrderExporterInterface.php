<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter;

use Orm\Zed\Sales\Persistence\SpySalesOrder;

interface OrderExporterInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function export(SpySalesOrder $orderEntity, array $orderItems): void;
}
