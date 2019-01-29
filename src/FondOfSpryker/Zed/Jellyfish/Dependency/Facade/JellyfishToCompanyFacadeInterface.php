<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Facade;

use Generated\Shared\Transfer\CompanyTransfer;

interface JellyfishToCompanyFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function getCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer;
}
