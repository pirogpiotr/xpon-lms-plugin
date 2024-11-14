<?php

namespace XponLmsPlugin\Tests\Core;

use XponLmsPlugin\Lib\ApiClient;
use PHPUnit\Framework\TestCase;

class ApiClientTest extends TestCase
{

    /** @var ApiClient  */
    private $apiClient;

    protected function setUp()
    {

        $this->apiClient = new ApiClient([]);
    }

    protected function tearDown()
    {
        $this->apiClient = null;
    }


    public function testRequest()
    {
        static::assertInstanceOf(ApiClient::class, $this->apiClient);
    }
}
