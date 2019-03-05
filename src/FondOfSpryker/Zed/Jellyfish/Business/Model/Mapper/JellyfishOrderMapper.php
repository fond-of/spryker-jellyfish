<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\JellyfishOrderAddressTransfer;
use Generated\Shared\Transfer\JellyfishOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

class JellyfishOrderMapper implements JellyfishOrderMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderAddressMapperInterface
     */
    protected $jellyfishOrderAddressMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderExpenseMapperInterface
     */
    protected $jellyfishOrderExpenseMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderDiscountMapperInterface
     */
    protected $jellyfishOrderDiscountMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderPaymentMapperInterface
     */
    protected $jellyfishOrderPaymentMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderTotalsMapperInterface
     */
    protected $jellyfishOrderTotalMapper;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderAddressMapperInterface $jellyfishOrderAddressMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderExpenseMapperInterface $jellyfishOrderExpenseMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderDiscountMapperInterface $jellyfishOrderDiscountMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderPaymentMapperInterface $jellyfishOrderPaymentMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishOrderTotalsMapperInterface $jellyfishOrderTotalMapper
     */
    public function __construct(
        JellyfishOrderAddressMapperInterface $jellyfishOrderAddressMapper,
        JellyfishOrderExpenseMapperInterface $jellyfishOrderExpenseMapper,
        JellyfishOrderDiscountMapperInterface $jellyfishOrderDiscountMapper,
        JellyfishOrderPaymentMapperInterface $jellyfishOrderPaymentMapper,
        JellyfishOrderTotalsMapperInterface $jellyfishOrderTotalMapper
    ) {
        $this->jellyfishOrderAddressMapper = $jellyfishOrderAddressMapper;
        $this->jellyfishOrderExpenseMapper = $jellyfishOrderExpenseMapper;
        $this->jellyfishOrderDiscountMapper = $jellyfishOrderDiscountMapper;
        $this->jellyfishOrderPaymentMapper = $jellyfishOrderPaymentMapper;
        $this->jellyfishOrderTotalMapper = $jellyfishOrderTotalMapper;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderTransfer
     */
    public function fromSalesOrder(SpySalesOrder $salesOrder): JellyfishOrderTransfer
    {
        $jellyfishOrder = new JellyfishOrderTransfer();

        $jellyfishOrder->setId($salesOrder->getIdSalesOrder())
            ->setReference($salesOrder->getOrderReference())
            ->setCustomerReference($salesOrder->getCustomerReference())
            ->setCurrency($salesOrder->getCurrencyIsoCode())
            ->setLocale($salesOrder->getLocale()->getLocaleName())
            ->setPriceMode($salesOrder->getPriceMode())
            ->setStore($salesOrder->setStore())
            ->setSystemCode('')
            ->setPayments($this->mapSalesOrderToPayments($salesOrder))
            ->setBillingAddress($this->mapSalesOrderToBillingAddress($salesOrder))
            ->setShippingAddress($this->mapSalesOrderToShippingAddress($salesOrder))
            ->setExpenses($this->mapSalesOrderToExpenses($salesOrder))
            ->setDiscounts($this->mapSalesOrderToDiscounts($salesOrder))
            ->setCreatedAt($salesOrder->getCreatedAt());

        return $jellyfishOrder;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return \ArrayObject
     */
    protected function mapSalesOrderToPayments(SpySalesOrder $salesOrder): ArrayObject
    {
        $jellyfishOrderPayments = new ArrayObject();

        foreach ($salesOrder->getOrdersJoinSalesPaymentMethodType() as $salesPayment) {
            $jellyfishOrderPayment = $this->jellyfishOrderPaymentMapper->fromSalesPayment($salesPayment);

            $jellyfishOrderPayments->append($jellyfishOrderPayment);
        }

        return $jellyfishOrderPayments;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return \ArrayObject
     */
    protected function mapSalesOrderToExpenses(SpySalesOrder $salesOrder): ArrayObject
    {
        $jellyfishOrderExpenses = new ArrayObject();

        foreach ($salesOrder->getExpenses() as $salesExpense) {
            $jellyfishOrderExpense = $this->jellyfishOrderExpenseMapper->fromSalesExpense($salesExpense);

            $jellyfishOrderExpenses->append($jellyfishOrderExpense);
        }

        return $jellyfishOrderExpenses;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderAddressTransfer
     */
    protected function mapSalesOrderToBillingAddress(SpySalesOrder $salesOrder): JellyfishOrderAddressTransfer
    {
        return $this->jellyfishOrderAddressMapper->fromSalesOrderAddress($salesOrder->getBillingAddress());
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderAddressTransfer
     */
    protected function mapSalesOrderToShippingAddress(SpySalesOrder $salesOrder): JellyfishOrderAddressTransfer
    {
        return $this->jellyfishOrderAddressMapper->fromSalesOrderAddress($salesOrder->getShippingAddress());
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return \ArrayObject
     */
    protected function mapSalesOrderToDiscounts(SpySalesOrder $salesOrder): ArrayObject
    {
        $jellyfishOrderDiscounts = new ArrayObject();

        foreach ($salesOrder->getDiscounts() as $salesDiscount) {
            $salesDiscount->get
            $jellyfishOrderDiscount = $this->jellyfishOrderDiscountMapper->fromSalesDiscount($salesDiscount);

            $jellyfishOrderDiscounts->append($jellyfishOrderDiscount);
        }

        return $jellyfishOrderDiscounts;
    }
}
