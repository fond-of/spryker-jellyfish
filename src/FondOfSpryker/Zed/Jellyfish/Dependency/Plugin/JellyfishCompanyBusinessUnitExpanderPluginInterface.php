<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Plugin;

use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;

interface JellyfishCompanyBusinessUnitExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    public function expand(
        JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer;
}
