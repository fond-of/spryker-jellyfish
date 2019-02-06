<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\JellyfishCompanyTransfer;

class JellyfishCompanyMapper implements JellyfishCompanyMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyTransfer
     */
    public function fromCompany(CompanyTransfer $companyTransfer): JellyfishCompanyTransfer
    {
        $jellyfishCompany = new JellyfishCompanyTransfer();
        $jellyfishCompany->setId($companyTransfer->getUuid());
        $jellyfishCompany->setExternalReference($companyTransfer->getExternalReference());
        $jellyfishCompany->setName($companyTransfer->getName());

        return $jellyfishCompany;
    }
}
