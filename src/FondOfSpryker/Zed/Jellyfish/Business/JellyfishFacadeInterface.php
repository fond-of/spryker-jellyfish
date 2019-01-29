<?php

namespace FondOfSpryker\Zed\Jellyfish\Business;

interface JellyfishFacadeInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportCompanyBulk(array $transfers): void;
}
