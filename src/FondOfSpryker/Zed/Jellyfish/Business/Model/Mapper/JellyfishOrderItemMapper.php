<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\JellyfishOrderItemTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

class JellyfishOrderItemMapper implements JellyfishOrderItemMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface[]
     */
    protected $jellyfishOrderItemExpanderPostMapPlugins;

    /**
     * @param \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface[] $jellyfishOrderItemExpanderPostMapPlugins
     */
    public function __construct(array $jellyfishOrderItemExpanderPostMapPlugins)
    {
        $this->jellyfishOrderItemExpanderPostMapPlugins = $jellyfishOrderItemExpanderPostMapPlugins;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderItemTransfer
     */
    public function fromSalesOrderItem(SpySalesOrderItem $orderItem): JellyfishOrderItemTransfer
    {
        $jellyfishOrderItemTransfer = new JellyfishOrderItemTransfer();

        $quantity = $orderItem->getQuantity();

        $jellyfishOrderItemTransfer->setSku($orderItem->getSku())
            ->setId($orderItem->getIdSalesOrderItem())
            ->setName($orderItem->getName())
            ->setQuantity($orderItem->getQuantity())
            ->setTaxRate((float)$orderItem->getTaxRate())
            ->setUnitPrice((int)round($orderItem->getPrice() / $quantity))
            ->setUnitPriceToPayAggregation((int)round($orderItem->getPriceToPayAggregation() / $quantity))
            ->setUnitTaxAmount((int)round($orderItem->getTaxAmount() / $quantity))
            ->setUnitDiscountAmountAggregation((int)round($orderItem->getDiscountAmountAggregation() / $quantity))
            ->setUnitDiscountAmountFullAggregation((int)round($orderItem->getDiscountAmountFullAggregation() / $quantity))
            ->setSumTaxAmount($orderItem->getTaxAmount())
            ->setSumPrice($orderItem->getPrice())
            ->setSumPriceToPayAggregation($orderItem->getPriceToPayAggregation())
            ->setSumDiscountAmountAggregation($orderItem->getDiscountAmountAggregation())
            ->setSumDiscountAmountFullAggregation($orderItem->getDiscountAmountFullAggregation());

        foreach ($this->jellyfishOrderItemExpanderPostMapPlugins as $jellyfishOrderItemExpanderPostMapPlugin) {
            $jellyfishOrderItemExpanderPostMapPlugin->expand($jellyfishOrderItemTransfer, $orderItem);
        }

        return $jellyfishOrderItemTransfer;
    }
}
