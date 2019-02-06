<?php

namespace FondOfSpryker\Zed\Jellyfish;

use FondOfSpryker\Shared\Jellyfish\JellyfishConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class JellyfishConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->get(JellyfishConstants::BASE_URI, 'http://localhost');
    }

    /**
     * @return float
     */
    public function getTimeout(): float
    {
        return $this->get(JellyfishConstants::TIMEOUT, 2.0);
    }

    /**
     * @return bool
     */
    public function dryRun(): bool
    {
        return $this->get(JellyfishConstants::DRY_RUN, true);
    }
}
