<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\JellyfishOrderAddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;

class JellyfishOrderAddressMapper implements JellyfishOrderAddressMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[]
     */
    protected $jellyfishOrderAddressExpanderPostMapPlugins;

    /**
     * @param \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[] $jellyfishOrderAddressExpanderPostMapPlugins
     */
    public function __construct(array $jellyfishOrderAddressExpanderPostMapPlugins)
    {
        $this->jellyfishOrderAddressExpanderPostMapPlugins = $jellyfishOrderAddressExpanderPostMapPlugins;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddress
     *
     * @throws
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

        foreach ($this->jellyfishOrderAddressExpanderPostMapPlugins as $jellyfishOrderAddressExpanderPostMapPlugin) {
            $jellyfishOrderAddress = $jellyfishOrderAddressExpanderPostMapPlugin->expand(
                $jellyfishOrderAddress,
                $salesOrderAddress
            );
        }

        return $jellyfishOrderAddress;
    }
}
