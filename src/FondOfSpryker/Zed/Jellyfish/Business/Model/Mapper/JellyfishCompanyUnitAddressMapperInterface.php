<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\JellyfishCompanyUnitAddressTransfer;

interface JellyfishCompanyUnitAddressMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyUnitAddressTransfer
     */
    public function fromCompanyUnitAddress(CompanyUnitAddressTransfer $companyUnitAddressTransfer): JellyfishCompanyUnitAddressTransfer;
}
