<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter;

use FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface;
use FondOfSpryker\Zed\Jellyfish\JellyfishConfig;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class OrderAdapter extends AbstractAdapter
{
    protected const ORDERS_URI = 'standard/orders';

    /**
     * OrderAdapter constructor.
     *
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface $utilEncodingService
     * @param \GuzzleHttp\ClientInterface $client
     * @param \FondOfSpryker\Zed\Jellyfish\JellyfishConfig $config
     */
    public function __construct(
        JellyfishToUtilEncodingServiceInterface $utilEncodingService,
        ClientInterface $client,
        JellyfishConfig $config
    ) {
        parent::__construct($utilEncodingService, $client, $config->getUsername(), $config->getPassword(), $config->dryRun());
        $this->config = $config;
    }

    /**
     * @return string
     */
    protected function getUri(): string
    {
        return sprintf('%s/%s', rtrim($this->config->getBaseUri(), '/'), ltrim(static::ORDERS_URI, '/'));
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return void
     */
    protected function handleResponse(ResponseInterface $response, AbstractTransfer $transfer): void
    {
    }
}
