<?php

namespace XponLmsPlugin\Lib;

use InvalidArgumentException;
use xajaxResponse;
use XponLms;
use XponLmsPlugin\Controller\OntSearchServiceController;
use XponLmsPlugin\Controller\Page\ImageViewPageController;
use XponLmsPlugin\Controller\Page\OltListPageController;
use XponLmsPlugin\Controller\Page\OntAddPageController;
use XponLmsPlugin\Controller\Page\OntAutofindPageController;
use XponLmsPlugin\Controller\Page\OntEditPageController;
use XponLmsPlugin\Controller\Page\OntInfoPageController;
use XponLmsPlugin\Controller\Page\OntListPageController;
use XponLmsPlugin\Controller\Page\OntSetupPageController;
use XponLmsPlugin\Model\OntModel;

class UrlGenerator
{

    const KEY_MODULE = 'm';

    const XPON_PAGE_PREFIX = 'xpon-';

    const URL_PREFIX = '?' . self::KEY_MODULE . '=';

    const LMS_MODULE_CUSTOMERINFO = 'customerinfo';
    const LMS_MODULE_NODEINFO = 'nodeinfo';

    const URL_PAGES = [
        OntListPageController::class => self::XPON_PAGE_PREFIX . 'ontlist',
        OntAutofindPageController::class => self::XPON_PAGE_PREFIX . 'ontautofind',
        OntAddPageController::class => self::XPON_PAGE_PREFIX . 'ontadd',
        OltListPageController::class => self::XPON_PAGE_PREFIX . 'oltlist',
        OntInfoPageController::class => self::XPON_PAGE_PREFIX . 'ontinfo',
        OntEditPageController::class => self::XPON_PAGE_PREFIX . 'ontedit',
        OntSetupPageController::class => self::XPON_PAGE_PREFIX . 'ontsetup',
        ImageViewPageController::class => self::XPON_PAGE_PREFIX . 'imageview',
        OntSearchServiceController::class => self::XPON_PAGE_PREFIX . 'ontsearch',
        self::LMS_MODULE_CUSTOMERINFO => self::LMS_MODULE_CUSTOMERINFO,
        self::LMS_MODULE_NODEINFO => self::LMS_MODULE_NODEINFO,
    ];

    /**
     * @param array $ont
     * @return string
     * @throws InvalidArgumentException
     */
    public static function getOntSelector(array $ont)
    {
        foreach ([OntModel::KEY_OLT_ID, OntModel::KEY_IFINDEX, OntModel::KEY_ID] as $name) {
            if (!array_key_exists($name, $ont)) {
                throw new InvalidArgumentException(__METHOD__ . ": key '$name' missing");
            }
        }
        return sprintf("%d:%d.%d", $ont[OntModel::KEY_OLT_ID], $ont[OntModel::KEY_IFINDEX], $ont[OntModel::KEY_ID]);
    }

    public static function getOntHtmlData(array $ont)
    {
        return 'data-' . OntModel::KEY_OLT_ID . '=' . $ont[OntModel::KEY_OLT_ID] . ' ' .
        'data-' . OntModel::KEY_IFINDEX . '=' . $ont[OntModel::KEY_IFINDEX] . ' ' .
        'data-' . OntModel::KEY_ID . '=' . $ont[OntModel::KEY_ID] . ' ';
    }

    /**
     * @param $urlPart
     * @return string
     */
    public static function getPublic($urlPart)
    {

        $url = XponLms::URL_PUBLIC . $urlPart;

        if (XponLms::DEVEL) {
            $url .= '?_=' . time();
        }

        return $url;
    }

    /**
     * @param $className
     * @return string
     * @throws InvalidArgumentException
     * @smarty
     */
    public static function getModuleForPage($className)
    {
        if (!array_key_exists($className, self::URL_PAGES)) {
            throw new InvalidArgumentException(__METHOD__ . ": url for class $className is not set");
        }

        return self::URL_PAGES[$className];
    }

    /**
     * @param $className
     * @param array $params
     * @return string
     * @throws InvalidArgumentException
     */
    public static function getUrlForPage($className, array $params = [])
    {
        $url = self::URL_PREFIX . self::getModuleForPage($className);

        if ($params) {
            $url .= '&' . http_build_query($params);
        }

        return $url;
    }

    /**
     * @param array $ont
     * @param string $className
     * @return string
     * @throws InvalidArgumentException
     * @noinspection PhpUnused @smarty
     */
    public static function getUrlForOnt(array $ont, $className = OntInfoPageController::class)
    {
        $ontData = [];
        foreach ([OntModel::KEY_OLT_ID, OntModel::KEY_IFINDEX, OntModel::KEY_ID] as $field) {
            if (!isset($ont[$field])) {
                throw new InvalidArgumentException(__METHOD__ . ": ont data error - field '$field' missing");
            }
            $ontData[$field] = $ont[$field];
        }

        return self::getUrlForPage($className, $ontData);
    }

    /**
     * @param $customerId
     * @return string
     * @noinspection PhpUnused @smarty
     * @throws InvalidArgumentException
     */
    public static function getUrlForCustomerInfo($customerId)
    {
        return self::getUrlForPage(self::LMS_MODULE_CUSTOMERINFO, ['id' => $customerId]);
    }

    /**
     * @param $nodeId
     * @return string
     * @noinspection PhpUnused @smarty
     * @throws InvalidArgumentException
     */
    public static function getUrlForNodeInfo($nodeId)
    {
        return self::getUrlForPage(self::LMS_MODULE_NODEINFO, ['id' => $nodeId]);
    }

    /**
     * @param xajaxResponse $xajaxResponse
     * @param array $ont
     * @throws InvalidArgumentException
     */
    public static function redirectForOntSetup(xajaxResponse $xajaxResponse, array $ont)
    {
        $url = UrlGenerator::getUrlForPage(OntSetupPageController::class);

        // $data = json_encode($ont);
        $data = addslashes(json_encode($ont));

        $script = "data = JSON.parse('$data');";
        $script .= "XponLmsPlugin.redirectWithPostForm('$url', data);";

        $xajaxResponse->script($script);
    }

}
