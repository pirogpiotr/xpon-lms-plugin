<?php

namespace XponLmsPlugin;

use Exception;
use InvalidArgumentException;
use LMS;
use RuntimeException;
use Smarty;
use XponLms;
use XponLmsPlugin\Controller\Page\AbstractPageController;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\ApiClient;
use XponLmsPlugin\Lib\Config;
use XponLmsPlugin\Lib\Page;
use XponLmsPlugin\Lib\XponApiHelper;

class XponLmsPlugin
{
    /** @var Config */
    protected $config;

    /** @var Smarty */
    protected $smarty;

    /** @var LMS */
    protected $lms;

    /** @var XponApiHelper */
    protected $xponApiHelper;

    /** @var ApiClient */
    protected $apiClient;

    public function __construct(Config $config)
    {
        $this->setConfig($config);

        if (XponLms::ENABLE_WARNINGS) {
            ini_set('display_startup_errors', 1);
            ini_set('display_errors', 1);
            error_reporting(E_ALL & ~E_NOTICE);
        }

        assert_options(ASSERT_BAIL, false);
        assert_options(ASSERT_WARNING, false);
        assert_options(ASSERT_CALLBACK, function($filename, $line, $code, $assertMessage = null) {
            if ($assertMessage === null) {
                $assertMessage = 'no message';
            }
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new RuntimeException("Assert failed\n file: $filename\n line: $line\n code: $code\n message: $assertMessage\n");
        });

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
    public function setConfig($config)
    {
        $this->config = $config;
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
     * @return XponLmsPlugin
     */
    public function setLms($lms)
    {
        $this->lms = $lms;
        return $this;
    }

    /**
     * @return Smarty
     */
    public function getSmarty()
    {
        return $this->smarty;
    }

    /**
     * @param Smarty $smarty
     * @return self
     */
    public function setSmarty(Smarty $smarty)
    {
        $this->smarty = $smarty;
        return $this;
    }

    /**
     * @return ApiClient
     * @throws InvalidArgumentException
     */
    public function getApiClient()
    {
        if ($this->apiClient === null) {
            if (!$apiUrl = $this->config->get(Config::CONFIG_API_URL)) {
                throw new InvalidArgumentException(__METHOD__ . ': Ustaw xpon.api_url!');
            }
            if (!$login = $this->config->get(Config::CONFIG_API_LOGIN)) {
                throw new InvalidArgumentException(__METHOD__ . ': Ustaw xpon.api_login!');
            }
            if (!$password = $this->config->get(Config::CONFIG_API_PASSWORD)) {
                throw new InvalidArgumentException(__METHOD__ . ': Ustaw xpon.api_password!');
            }

            $apiData = [
                ApiClient::KEY_BASEURL => $apiUrl,
                ApiClient::KEY_LOGIN => $login,
                ApiClient::KEY_PASSWORD => $password,
            ];

            $this->apiClient = new ApiClient($apiData);
        }

        return $this->apiClient;
    }

    /**
     * @return XponApiHelper
     * @throws InvalidArgumentException
     */
    public function getXponApiHelper()
    {
        if ($this->xponApiHelper === null) {
            $this->xponApiHelper = new XponApiHelper($this->getApiClient());
        }

        return $this->xponApiHelper;
    }

    /**
     * @param AbstractPageController|class-string $pageControllerOrClassName
     * @return bool
     * @throws InvalidArgumentException
     * @throws KeyNotSetException
     */
    public function runPageController($pageControllerOrClassName)
    {
        if (is_string($pageControllerOrClassName)) {
            try {
                if (!class_exists($pageControllerOrClassName)) {
                    throw new InvalidArgumentException(__METHOD__ . " \$pageController class doesn't exist");
                }
                if (is_a($pageControllerOrClassName, AbstractPageController::class, true)) {
                    $page = $this->factoryPage();
                    $pageController = new $pageControllerOrClassName($this, $page);
                } else {
                    throw new InvalidArgumentException(__METHOD__ . " \$pageController object type error");
                }
            } catch (Exception $e) {
                return $this->displayErrorPage($e, "Page setup error");
            }
        } else {
            $pageController = $pageControllerOrClassName;
        }

        assert($pageController instanceof $pageControllerOrClassName && $pageController instanceof AbstractPageController);

        // xajax
        $pageController->userRegisterXajax();

        try {
            $script = $pageController->getLms()->RunXajax();
        } catch (Exception $e) {
            $xajaxResponse = $pageController->factoryXajaxResponse();
            $txt = "Błąd: nieobsługiwany wyjątek\n\nKlasa: " . get_class($e) .
                "\nKod: " . $e->getCode() . "\nKomunikat: " . $e->getMessage() . "\n";
            $xajaxResponse->alert($txt);

            $xajaxResponse->printOutput();
            exit(0);
        }

        if ($script) {
            $pageController->getPage()->assign('xajax', $script);
        }

        try {
            $pageController->show();
        } catch (Exception $e) {
            return $this->displayErrorPage($e, "Page show error");
        }

        return true;
    }

    public function displayErrorPage(Exception $e, $applicationErrorMessage)
    {
        try {
            $this->factoryPage()
                ->setException($e)
                ->setErrorMessage($applicationErrorMessage)
                ->setTemplate('xpon/page/error.tpl')
                ->display();
        } catch (Exception $e) {
            printf("<pre>");
            printf("Exception inception - there was exception durring processign exception :)\n\n" .
                "application message:\n$applicationErrorMessage\n\n" .
                "exception class: " . get_class($e) . "\n" .
                "exception message:\n{$e->getMessage()}\n" .
                "exception code:\n{$e->getCode()}\n\n");
        }

        return false;
    }

    public function factoryPage()
    {
        return new Page($this->getSmarty());
    }

}
