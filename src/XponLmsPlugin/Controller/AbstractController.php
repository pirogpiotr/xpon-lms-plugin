<?php

namespace XponLmsPlugin\Controller;

use InvalidArgumentException;
use LMS;
use Smarty;
use xajax;
use xajaxResponse;
use XponLmsPlugin\Controller\Page\AbstractPageController;
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

    /** @var SMARTY */
    protected $smarty;

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
            ->setLms($xponLmsPlugin->getLms())
            ->setSmarty($xponLmsPlugin->getSmarty());
    }

    public function getSmarty()
    {
        return $this->smarty;
    }

    public function setSmarty(Smarty $smarty): void
    {
        $this->smarty = $smarty;
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

    /**
     * @return xajaxResponse
     */
    public function factoryXajaxResponse()
    {
        return new xajaxResponse();
    }

    /**
     * @param array|string $names
     * @return AbstractController
     */
    protected function registerXajaxSimple($names)
    {
        if (!is_array($names)) {
            $names = [$names];
        }

        foreach ($names as $name) {
            $this->registerXajaxFunction([$name, $this, "xajax_$name"]);
        }

        return $this;
    }

    /**
     * @param array $arg
     * @return AbstractController
     */
    protected function registerXajaxFunction(array $arg)
    {
        $lms = $this->getLms();

        assert($lms instanceof LMS);

        if (!$lms->xajax) {
            $lms->InitXajax();
        }

        /** @var xajax $xajax */
        $xajax = $lms->xajax;

        $xajax->register(XAJAX_FUNCTION, $arg);

        return $this;
    }

}
