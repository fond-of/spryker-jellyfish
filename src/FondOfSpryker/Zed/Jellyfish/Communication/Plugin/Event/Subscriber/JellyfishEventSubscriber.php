<?php

namespace FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Listener\CompanyBusinessUnitExportListener;
use FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Listener\CompanyExportListener;
use FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Listener\CompanyUnitAddressExportListener;
use FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Listener\CompanyUserExportListener;
use FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Listener\CustomerExportListener;
use FondOfSpryker\Zed\Jellyfish\Dependency\JellyfishEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\Business\JellyfishFacadeInterface getFacade()
 */
class JellyfishEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            JellyfishEvents::ENTITY_SPY_COMPANY_UPDATE,
            new CompanyExportListener()
        );

        $eventCollection->addListenerQueued(
            JellyfishEvents::ENTITY_SPY_COMPANY_BUSINESS_UNIT_UPDATE,
            new CompanyBusinessUnitExportListener()
        );

        $eventCollection->addListenerQueued(
            JellyfishEvents::ENTITY_SPY_COMPANY_UNIT_ADDRESS_CREATE,
            new CompanyUnitAddressExportListener()
        );

        $eventCollection->addListenerQueued(
            JellyfishEvents::ENTITY_SPY_COMPANY_UNIT_ADDRESS_UPDATE,
            new CompanyUnitAddressExportListener()
        );

        // Company User
        $eventCollection->addListenerQueued(
            JellyfishEvents::ENTITY_SPY_COMPANY_USER_CREATE,
            new CompanyUserExportListener()
        );

        $eventCollection->addListenerQueued(
            JellyfishEvents::ENTITY_SPY_COMPANY_USER_UPDATE,
            new CompanyUserExportListener()
        );

        return $eventCollection;
    }
}
