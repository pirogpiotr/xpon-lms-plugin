<?php

namespace XponLmsPlugin\Tests;

use ConfigHelper;
use InvalidArgumentException;
use RuntimeException;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Lib\Config;
use XponLmsPlugin\XponLmsPlugin;
use PHPUnit\Framework\TestCase;

class XponLmsPluginTest extends TestCase
{

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ApiException
     */
    public function test__construct()
    {
        $config = new Config(ConfigHelper::class);
        $xponLmsPlugin = new XponLmsPlugin($config);

        $olts = $xponLmsPlugin->getXponApiHelper()->getOltList();

        static::assertInternalType('array', $olts);

    }
}
