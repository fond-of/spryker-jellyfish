<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface JellyfishToCompanyBusinessUnitFacadeInterface
{
    /**
     * @param int $companyId
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function getCompanyBusinessUnitById(int $companyId): ?CompanyBusinessUnitTransfer;
}
