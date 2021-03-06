<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter;

use ArrayObject;
use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapperInterface;
use Generated\Shared\Transfer\JellyfishOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Shared\Log\LoggerTrait;

class OrderExporter implements OrderExporterInterface
{
    use LoggerTrait;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapperInterface
     */
    protected $jellyfishOrderMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapperInterface
     */
    protected $jellyfishOrderItemMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderMapperInterface $jellyfishOrderMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderItemMapperInterface $jellyfishOrderItemMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface $adapter
     */
    public function __construct(
        JellyfishOrderMapperInterface $jellyfishOrderMapper,
        JellyfishOrderItemMapperInterface $jellyfishOrderItemMapper,
        AdapterInterface $adapter
    )
    {
        $this->jellyfishOrderMapper = $jellyfishOrderMapper;
        $this->jellyfishOrderItemMapper = $jellyfishOrderItemMapper;
        $this->adapter = $adapter;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function export(SpySalesOrder $orderEntity, array $orderItems): void
    {
        try {
            $jellyfishOrder = $this->map($orderEntity, $orderItems);
            $this->adapter->sendRequest($jellyfishOrder);
        } catch (\Exception $exception) {
            $this->getLogger()->error(sprintf('Order %s could not expoted to JellyFish! Message: %s', $orderEntity->getIdSalesOrder(), $exception->getMessage()), $exception->getTrace());
            throw $exception;
        }
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderTransfer
     */
    protected function map(SpySalesOrder $orderEntity, array $orderItems): JellyfishOrderTransfer
    {
        $jellyfishOrder = $this->jellyfishOrderMapper->fromSalesOrder($orderEntity);
        $jellyfishOrderItems = $this->mapOrderItems($orderItems);

        $jellyfishOrder->setItems($jellyfishOrderItems);

        return $jellyfishOrder;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \ArrayObject
     */
    protected function mapOrderItems(array $orderItems): ArrayObject
    {
        $jellyfishOrderItems = new ArrayObject();
        $groupKeyIndexMapping = new ArrayObject();

        foreach ($orderItems as $orderItem) {
            $groupKey = $orderItem->getGroupKey();
            $jellyfishOrderItem = $this->jellyfishOrderItemMapper->fromSalesOrderItem($orderItem);

            if ($groupKey === null) {
                $jellyfishOrderItems->append($jellyfishOrderItem);

                continue;
            }

            if ($groupKey !== null && !$groupKeyIndexMapping->offsetExists($groupKey)) {
                $jellyfishOrderItems->append($jellyfishOrderItem);
                $groupKeyIndexMapping->offsetSet($groupKey, $jellyfishOrderItems->count() - 1);

                continue;
            }

            $index = $groupKeyIndexMapping->offsetGet($groupKey);
            $currentJellyfishOrderItem = $jellyfishOrderItems->offsetGet($index);

            $currentJellyfishOrderItem->setQuantity($currentJellyfishOrderItem->getQuantity() + $jellyfishOrderItem->getQuantity())
                ->setSumTaxAmount($currentJellyfishOrderItem->getSumTaxAmount() + $jellyfishOrderItem->getSumTaxAmount())
                ->setSumPrice($currentJellyfishOrderItem->getSumPrice() + $jellyfishOrderItem->getSumPrice())
                ->setSumPriceToPayAggregation($currentJellyfishOrderItem->getSumPriceToPayAggregation() + $jellyfishOrderItem->getSumPriceToPayAggregation())
                ->setSumDiscountAmountAggregation($currentJellyfishOrderItem->getSumDiscountAmountAggregation() + $jellyfishOrderItem->getSumDiscountAmountAggregation())
                ->setSumDiscountAmountFullAggregation($currentJellyfishOrderItem->getSumDiscountAmountFullAggregation() + $jellyfishOrderItem->getSumDiscountAmountFullAggregation());
        }

        return $jellyfishOrderItems;
    }
}
