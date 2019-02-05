<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\JellyfishCompanyUserTransfer;

interface JellyfishCompanyUserMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyUserTransfer
     */
    public function fromCompanyUser(CompanyUserTransfer $companyUserTransfer): JellyfishCompanyUserTransfer;
}
