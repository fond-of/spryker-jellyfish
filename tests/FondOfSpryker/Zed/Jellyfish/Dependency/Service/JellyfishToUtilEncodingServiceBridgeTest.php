<?php

namespace FondOfSpryker\Zed\Jellyfish\Dependency\Service;

use stdClass;
use Codeception\Test\Unit;
use Spryker\Service\UtilEncoding\UtilEncodingService;
use Spryker\Service\UtilEncoding\UtilEncodingServiceFactory;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;

class JellyfishToUtilEncodingServiceBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceBridge
     */
    protected $jellyfishToUtilEncodingServiceBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    protected $utilEncodingServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\UtilEncoding\UtilEncodingServiceFactory
     */
    protected $utilEncodingServiceFactoryMock;


    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->utilEncodingServiceMock = $this->getMockBuilder(UtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->jellyfishToUtilEncodingServiceBridge = new JellyfishToUtilEncodingServiceBridge(
            $this->utilEncodingServiceMock
        );
    }

    /**
     * @return void
     */
    public function testEncodeJson(): void
    {
        $jsonData = [
            "attribute" => "value"
        ];
        $expectedEncodedJson = json_encode($jsonData);

        $this->utilEncodingServiceMock->expects($this->atLeastOnce())
            ->method('encodeJson')
            ->willReturn($expectedEncodedJson);

        $actualEncodedJson = $this->jellyfishToUtilEncodingServiceBridge->encodeJson($jsonData);

        $this->assertTrue(is_string($actualEncodedJson));
        $this->assertEquals($expectedEncodedJson, $actualEncodedJson);
    }

    /**
     * @return void
     */
    public function testDecodeJson(): void
    {
        $jsonString = '{"attribute":"value"}';
        $expectedDecodedJson = json_decode($jsonString);

        $this->utilEncodingServiceMock->expects($this->atLeastOnce())
            ->method('decodeJson')
            ->willReturn($expectedDecodedJson);

        $actualDecodedJson = $this->jellyfishToUtilEncodingServiceBridge->decodeJson($jsonString);

        $this->assertInstanceOf(
            stdClass::class,
            $actualDecodedJson
        );

        $this->assertEquals($expectedDecodedJson, $actualDecodedJson);
    }
}
