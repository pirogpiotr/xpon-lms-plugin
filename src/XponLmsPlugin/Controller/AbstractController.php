<?php

namespace XponLmsPlugin\Controller;

use InvalidArgumentException;
use LMS;
use XponLmsPlugin\Lib\Config;
use XponLmsPlugin\Lib\XponApiHelper;
use XponLmsPlugin\XponLmsPlugin;

abstract class AbstractController
{
    /** @var Config */
    protected $config;

    /** @var XponApiHelper */
    protected $xponApiHelper;

    /** @var LMS */
    protected $lms;

    /**
     * AbstractController constructor.
     * @param XponLmsPlugin $xponLmsPlugin
     * @throws InvalidArgumentException
     */
    public function __construct(XponLmsPlugin $xponLmsPlugin)
    {
        $this
            ->setConfig($xponLmsPlugin->getConfig())
            ->setXponApiHelper($xponLmsPlugin->getXponApiHelper())
            ->setLms($xponLmsPlugin->getLms());
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     * @return static
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return XponApiHelper
     */
    public function getXponApiHelper()
    {
        return $this->xponApiHelper;
    }

    /**
     * @param XponApiHelper $xponApiHelper
     * @return static
     */
    public function setXponApiHelper($xponApiHelper)
    {
        $this->xponApiHelper = $xponApiHelper;
        return $this;
    }

    /**
     * @return LMS
     */
    public function getLms()
    {
        return $this->lms;
    }

    /**
     * @param LMS $lms
     * @return static
     */
    public function setLms(LMS $lms)
    {
        $this->lms = $lms;
        return $this;
    }

}
