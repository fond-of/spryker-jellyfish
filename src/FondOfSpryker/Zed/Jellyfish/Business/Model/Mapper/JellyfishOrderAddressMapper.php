<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\JellyfishOrderAddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;

class JellyfishOrderAddressMapper implements JellyfishOrderAddressMapperInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddress
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderAddressTransfer
     */
    public function fromSalesOrderAddress(SpySalesOrderAddress $salesOrderAddress): JellyfishOrderAddressTransfer
    {
        $jellyfishOrderAddress = new JellyfishOrderAddressTransfer();

        $jellyfishOrderAddress->setId($salesOrderAddress->getIdSalesOrderAddress())
            ->setName1($salesOrderAddress->getFirstName())
            ->setName2($salesOrderAddress->getLastName())
            ->setAddress1($salesOrderAddress->getAddress1())
            ->setAddress2($salesOrderAddress->getAddress2())
            ->setAddress3($salesOrderAddress->getAddress3())
            ->setCity($salesOrderAddress->getCity())
            ->setZipCode($salesOrderAddress->getZipCode())
            ->setCountry($salesOrderAddress->getCountry()->getIso2Code())
            ->setPhone($salesOrderAddress->getPhone());

        return $jellyfishOrderAddress;
    }
}
