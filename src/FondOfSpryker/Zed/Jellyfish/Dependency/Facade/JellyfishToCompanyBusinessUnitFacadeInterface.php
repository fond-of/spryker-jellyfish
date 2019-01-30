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
    public function findDefaultBusinessUnitByCompanyId(int $companyId): ?CompanyBusinessUnitTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function getCompanyBusinessUnitById(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitTransfer;
}
