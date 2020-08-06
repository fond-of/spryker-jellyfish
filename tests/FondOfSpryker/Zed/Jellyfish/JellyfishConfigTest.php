<?php

namespace FondOfSpryker\Zed\Jellyfish;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\Jellyfish\JellyfishConstants;
use Spryker\Shared\Kernel\AbstractSharedConfig;

class JellyfishConfigTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\AbstractSharedConfig
     */
    protected $abstractSharedConfigMock;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\JellyfishConfig
     */
    protected $jellyfishConfig;

    /**
     * @var array
     */
    protected $data;

    /**
     * @return void
     */
    protected function _before()
    {
        parent::_before();

        $this->data = [
            'base_uri' => 'http://jellyfish.localhost',
            'timeout' => 2.0,
            'username' => 'username',
            'password' => 'pw',
            'system_code' => 'default',
            'dry_run' => true
        ];

        $this->jellyfishConfig = new class($this->data)
            extends JellyfishConfig {

            /**
             * @var array
             */
            protected $data;

            /**
             *  constructor.
             *
             * @param array $data
             */
            public function __construct(array $data)
            {
                $this->data = $data;
            }

            /**
             * @param string $key
             * @param mixed|null $default
             *
             * @return mixed
             */
            protected function get($key, $default = null)
            {
                switch ($key) {
                    case JellyfishConstants::BASE_URI:
                            return $this->data['base_uri'];
                        break;
                    case JellyfishConstants::TIMEOUT:
                            return $this->data['timeout'];
                        break;
                    case JellyfishConstants::USERNAME:
                            return $this->data['username'];
                        break;
                    case JellyfishConstants::PASSWORD:
                            return $this->data['password'];
                        break;
                    case JellyfishConstants::SYSTEM_CODE:
                            return $this->data['system_code'];
                        break;
                    case JellyfishConstants::DRY_RUN:
                            return $this->data['dry_run'];
                        break;
                    default:
                            return $default;
                        break;
                }

                return parent::get($key, $default);
            }
        };

    }

    /**
     * @return void
     */
    public function testGetBaseUri()
    {
        $this->assertEquals($this->data['base_uri'], $this->jellyfishConfig->getBaseUri());
    }

    /**
     * @return void
     */
    public function testGetTimeout()
    {
        $this->assertEquals($this->data['timeout'], $this->jellyfishConfig->getTimeout());
    }

    /**
     * @return void
     */
    public function testGetUsername()
    {
        $this->assertEquals($this->data['username'], $this->jellyfishConfig->getUsername());
    }

    /**
     * @return void
     */
    public function testGetPassword()
    {
        $this->assertEquals($this->data['password'], $this->jellyfishConfig->getPassword());
    }

    /**
     * @return void
     */
    public function testGetSystemCode()
    {
        $this->assertEquals($this->data['system_code'], $this->jellyfishConfig->getSystemCode());
    }

    /**
     * @return void
     */
    public function testDryRun()
    {
        $this->assertEquals($this->data['dry_run'], $this->jellyfishConfig->dryRun());
    }
}
