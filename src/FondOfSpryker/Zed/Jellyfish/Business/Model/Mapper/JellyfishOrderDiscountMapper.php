<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\JellyfishOrderDiscountTransfer;
use Orm\Zed\Sales\Persistence\SpySalesDiscount;

class JellyfishOrderDiscountMapper implements JellyfishOrderDiscountMapperInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesDiscount $discount
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderDiscountTransfer
     */
    public function fromSalesDiscount(SpySalesDiscount $discount): JellyfishOrderDiscountTransfer
    {
        $jellyfishOrderDiscount = new JellyfishOrderDiscountTransfer();

        $jellyfishOrderDiscount->setName($discount->getName())
            ->setDescription($discount->getDescription())
            //->setQuantity($discount->get)
        ->setCode($discount-)
    }
}
