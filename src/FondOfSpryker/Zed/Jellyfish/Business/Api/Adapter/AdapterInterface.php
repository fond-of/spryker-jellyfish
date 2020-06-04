<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter;

use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface AdapterInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $request
     *
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function sendRequest(AbstractTransfer $request): ?StreamInterface;
}
