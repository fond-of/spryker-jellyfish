<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\JellyfishCustomerTransfer;

class JellyfishCustomerMapper implements JellyfishCustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCustomerTransfer
     */
    public function fromCustomer(CustomerTransfer $customerTransfer): JellyfishCustomerTransfer
    {
        $jellyfishCustomerTransfer = new JellyfishCustomerTransfer();

        $jellyfishCustomerTransfer->setId($customerTransfer->getCustomerReference());
        $jellyfishCustomerTransfer->setExternalReference($customerTransfer->getExternalReference());
        $jellyfishCustomerTransfer->setPassword($customerTransfer->getPassword());
        $jellyfishCustomerTransfer->setEmail($customerTransfer->getEmail());
        $jellyfishCustomerTransfer->setAcceptedTerms(true);
        $jellyfishCustomerTransfer->setName1($customerTransfer->getFirstName());
        $jellyfishCustomerTransfer->setName2($customerTransfer->getLastName());
        $jellyfishCustomerTransfer->setConfirmPassword($customerTransfer->getPassword());

        return $jellyfishCustomerTransfer;
    }
}
