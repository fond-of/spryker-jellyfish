<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;

class JellyfishCompanyBusinessUnitMapper implements JellyfishCompanyBusinessUnitMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapperInterface
     */
    protected $jellyfishCompanyMapper;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapperInterface $jellyfishCompanyMapper
     */
    public function __construct(JellyfishCompanyMapperInterface $jellyfishCompanyMapper)
    {
        $this->jellyfishCompanyMapper = $jellyfishCompanyMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    public function fromCompany(CompanyTransfer $companyTransfer): JellyfishCompanyBusinessUnitTransfer
    {
        $jellyfishCompany = $this->jellyfishCompanyMapper->fromCompanyTransfer($companyTransfer);
        $jellyfishCompanyBusinessUnitTransfer = new JellyfishCompanyBusinessUnitTransfer();

        $jellyfishCompanyBusinessUnitTransfer->setCompany($jellyfishCompany);

        return $jellyfishCompanyBusinessUnitTransfer;
    }
}
