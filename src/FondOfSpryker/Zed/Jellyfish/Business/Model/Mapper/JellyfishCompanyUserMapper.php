<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\JellyfishCompanyUserTransfer;

class JellyfishCompanyUserMapper implements JellyfishCompanyUserMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapperInterface
     */
    protected $jellyfishCompanyBusinessUnitMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCustomerMapperInterface
     */
    protected $jellyfishCustomerMapper;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyBusinessUnitMapperInterface $jellyfishCompanyBusinessUnitMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCustomerMapperInterface $jellyfishCustomerMapper
     */
    public function __construct(
        JellyfishCompanyBusinessUnitMapperInterface $jellyfishCompanyBusinessUnitMapper,
        JellyfishCustomerMapperInterface $jellyfishCustomerMapper
    ) {
        $this->jellyfishCompanyBusinessUnitMapper = $jellyfishCompanyBusinessUnitMapper;
        $this->jellyfishCustomerMapper = $jellyfishCustomerMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyUserTransfer
     */
    public function fromCompanyUser(CompanyUserTransfer $companyUserTransfer): JellyfishCompanyUserTransfer
    {
        $jellyfishCompanyUser = new JellyfishCompanyUserTransfer();
        $jellyfishCompanyUser->setExternalReference($companyUserTransfer->getExternalReference());
        $jellyfishCompanyUser->setActive($companyUserTransfer->getIsActive());
        $jellyfishCompanyUser->setCustomer($this->jellyfishCustomerMapper->fromCustomer($companyUserTransfer->getCustomer()));
        $jellyfishCompanyUser->setCompanyBusinessUnit($this->jellyfishCompanyBusinessUnitMapper->fromCompanyBusinessUnit($companyUserTransfer->getCompanyBusinessUnit()));

        return $jellyfishCompanyUser;
    }
}
