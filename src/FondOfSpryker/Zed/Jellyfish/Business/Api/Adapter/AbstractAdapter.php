<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter;

use FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface;
use FondOfSpryker\Zed\Jellyfish\JellyfishConfig;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Shared\Log\LoggerTrait;

abstract class AbstractAdapter implements AdapterInterface
{
    use LoggerTrait;

    protected const DEFAULT_HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\JellyfishConfig
     */
    protected $config;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var bool
     */
    protected $dryRun;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceInterface $utilEncodingService
     * @param \GuzzleHttp\ClientInterface $client
     * @param \FondOfSpryker\Zed\Jellyfish\JellyfishConfig $config
     */
    public function __construct(
        JellyfishToUtilEncodingServiceInterface $utilEncodingService,
        ClientInterface $client,
        JellyfishConfig $config
    ) {
        $this->utilEncodingService = $utilEncodingService;
        $this->client = $client;

        $this->config = $config;
        $this->username = $config->getUsername();
        $this->password = $config->getPassword();
        $this->dryRun = $config->dryRun();
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function sendRequest(AbstractTransfer $transfer): ?StreamInterface
    {
        if ($this->dryRun === true) {
            $this->getLogger()->error($this->utilEncodingService->encodeJson($transfer->toArray(true, true)));

            return null;
        }

        $options = $this->createOptions($transfer);
        $response = $this->send($options);

        $this->handleResponse($response, $transfer);

        return $response->getBody();
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return array
     */
    protected function createOptions(AbstractTransfer $transfer): array
    {
        $options = [];

        $options[RequestOptions::HEADERS] = static::DEFAULT_HEADERS;
        if (!empty($this->username) && !empty($this->password)) {
            $options[RequestOptions::AUTH] = [
                $this->username,
                $this->password,
            ];
        }
        $options['timeout'] = 4;
        $options[RequestOptions::BODY] = $this->utilEncodingService->encodeJson($transfer->toArray(true, true));

        return $options;
    }

    /**
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function send(array $options = []): ResponseInterface
    {
        $uri = $this->getUri();
        $optionsAsJson = $this->utilEncodingService->encodeJson($options);
        $logMessage = sprintf('API request [%s]: %s', $uri, $optionsAsJson);

        $this->getLogger()->info($logMessage);

        return $this->client->request('POST', $uri, $options);
    }

    /**
     * @return string
     */
    abstract protected function getUri(): string;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return void
     */
    abstract protected function handleResponse(ResponseInterface $response, AbstractTransfer $transfer): void;
}
