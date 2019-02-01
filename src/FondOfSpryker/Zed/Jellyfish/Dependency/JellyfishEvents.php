<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency;

interface JellyfishEvents
{
    public const ENTITY_SPY_CUSTOMER_CREATE = 'Entity.spy_customer.create';
    public const ENTITY_SPY_CUSTOMER_UPDATE = 'Entity.spy_customer.update';

    public const ENTITY_SPY_COMPANY_UPDATE = 'Entity.spy_company.update';

    public const ENTITY_SPY_COMPANY_BUSINESS_UNIT_UPDATE = 'Entity.spy_company_business_unit.update';

    public const ENTITY_SPY_COMPANY_UNIT_ADDRESS_CREATE = 'Entity.spy_company_unit_address.create';
    public const ENTITY_SPY_COMPANY_UNIT_ADDRESS_UPDATE = 'Entity.spy_company_unit_address.update';
}
