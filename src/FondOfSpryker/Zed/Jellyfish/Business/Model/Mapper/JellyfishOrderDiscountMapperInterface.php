<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\JellyfishOrderDiscountTransfer;
use Orm\Zed\Sales\Persistence\SpySalesDiscount;

interface JellyfishOrderDiscountMapperInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesDiscount $discount
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderDiscountTransfer
     */
    public function fromSalesDiscount(SpySalesDiscount $discount): JellyfishOrderDiscountTransfer;
}
