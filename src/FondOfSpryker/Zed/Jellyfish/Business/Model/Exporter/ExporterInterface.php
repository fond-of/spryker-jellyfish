<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter;

interface ExporterInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportBulk(array $transfers): void;

    /**
     * @param int $id
     *
     * @return void
     */
    public function exportById(int $id): void;
}
