<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\JellyfishOrderItemTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

class JellyfishOrderItemMapper implements JellyfishOrderItemMapperInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderItemTransfer
     */
    public function fromSalesOrderItem(SpySalesOrderItem $orderItem): JellyfishOrderItemTransfer
    {
        $jellyfishOrderItemTransfer = new JellyfishOrderItemTransfer();

        $jellyfishOrderItemTransfer->setSku($orderItem->getSku())
            ->setName($orderItem->getName())
            ->setQuantity($orderItem->getQuantity())
            ->setTaxRate($orderItem->getTaxRate())
            ->setUnitPrice((int)round($orderItem->getPrice() / $orderItem->getQuantity()))
            ->setUnitTaxAmount((int)round($orderItem->getTaxAmount() / $orderItem->getQuantity()))
            ->setSumTaxAmount($orderItem->getTaxAmount())
            ->setSumPrice($orderItem->getPrice());

        return $jellyfishOrderItemTransfer;
    }
}
