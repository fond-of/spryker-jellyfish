<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Plugin;

use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * Class JellyfishCompanyBusinessUnitDataExpanderPlugin
 * @package FondOfSpryker\Zed\Jellyfish\Dependency\Plugin
 */
class JellyfishCompanyBusinessUnitDataExpanderPlugin extends AbstractPlugin implements JellyfishCompanyBusinessUnitExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    public function expand(JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer
    {
        if ($jellyfishCompanyBusinessUnitTransfer->getId()) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        if ($jellyfishCompanyBusinessUnitTransfer->getCompany() !== null) {
            return $this->expandByCompany($jellyfishCompanyBusinessUnitTransfer->getCompany());
        }

        if ($jellyfishCompanyBusinessUnitTransfer->getAddress() !== null) {
            return $this->expandByAddress($jellyfishCompanyBusinessUnitTransfer->getAddress());
        }
    }
}
