<?php

namespace FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\Jellyfish\Communication\Plugin\Event\Listener\CompanyExportListener;
use FondOfSpryker\Zed\Jellyfish\Dependency\JellyfishEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

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
            JellyfishEvents::ENTITY_SPY_COMPANY_CREATE,
            new CompanyExportListener()
        );

        $eventCollection->addListenerQueued(
            JellyfishEvents::ENTITY_SPY_COMPANY_UPDATE,
            new CompanyExportListener()
        );

        return $eventCollection;
    }
}
