<?php

namespace FondOfSpryker\Zed\Jellyfish\Communication;

use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToEventBehaviorFacadeInterface;
use FondOfSpryker\Zed\Jellyfish\JellyfishDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\JellyfishConfig getConfig()
 */
class JellyfishCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToEventBehaviorFacadeInterface
     */
    public function getEventBehaviorFacade(): JellyfishToEventBehaviorFacadeInterface
    {
        return $this->getProvidedDependency(JellyfishDependencyProvider::FACADE_EVENT_BEHAVIOR);
    }
}
