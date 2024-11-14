<?php

namespace XponLmsPlugin\Controller\Page;

use Exception;
use InvalidArgumentException;
use RuntimeException;
use xajaxResponse;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\UrlGenerator;
use XponLmsPlugin\Lib\XponApiHelper;
use XponLmsPlugin\Model\OntModel;

class OntInfoPageController extends AbstractPageController
{
    const KEY_ONT = 'xponOnt';

    const KEY_ONT_WANS = 'xponOntWans';
    const KEY_ONT_PORTS_ETH = 'xponOntEthPorts';
    const KEY_ONT_SERVICE_PORTS = 'xponOntServicePorts';

    const DELAY_ONT_RESTOREDEFAULTS = 6;
    const DELAY_ONT_REBOOT = 4;

    /** @var array|null */
    protected $ont;

    public function userRegisterXajax()
    {
        parent::userRegisterXajax();

        $this->registerXajaxSimple(['ontDelete', 'ontRefresh', 'ontReboot', 'ontRestoreDefaults']);
    }

    /**
     * @throws ApiException
     * @throws KeyNotSetException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    protected function userShow()
    {
        $ont = $this->getOntFromInputOrDie();

        $ontSelector = UrlGenerator::getOntSelector($ont);

        $ontDataArr = [
            static::KEY_ONT => $ont,
        ];

        $requestArr = [
            static::KEY_ONT_WANS => "onts/$ontSelector/wans",
            static::KEY_ONT_PORTS_ETH => "onts/$ontSelector/ports/eth",
            static::KEY_ONT_SERVICE_PORTS => "onts/$ontSelector/serviceports",
        ];

        foreach ($requestArr as $key => $url) {
            try {
                $ontDataArr[$key] = $this->getXponApiHelper()->get($url);
            } catch (Exception $e) {
                $ontDataArr[$key] = $e;
            }
        }

        $page = $this->getPage();
        $page
            ->setTemplate('xpon/page/ontinfo.tpl')
            ->assign($ontDataArr);
    }

    /**
     * @param int $inputType
     * @return array
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    protected function getOntFromInput($inputType = INPUT_GET)
    {
        $oltId = filter_input($inputType, OntModel::KEY_OLT_ID, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        $ifIndex = filter_input($inputType, OntModel::KEY_IFINDEX, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        $ontId = filter_input($inputType, OntModel::KEY_ID, FILTER_VALIDATE_INT);

        if (!is_numeric($oltId) || !is_numeric($ifIndex) || !is_numeric($ontId)) {
            throw new InvalidArgumentException("ont data not found / validation error");
        }

        return $this->getXponApiHelper()->get("onts/$oltId:$ifIndex.$ontId");
    }

    /**
     * @param int $inputType
     * @return array
     * @throws ApiException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    protected function getOntFromInputOrDie($inputType = INPUT_GET)
    {
        $ont = $this->getOntFromInput($inputType);

        if (!is_array($ont) || empty($ont)) {
            throw new RuntimeException("ont not found");
        }

        $this->ont = $ont;

        return $ont;
    }

    /**
     * @param array $ont
     * @param array $opts
     * @return xajaxResponse
     * @throws InvalidArgumentException
     * @throws ApiException
     */
    public function xajax_ontDelete(array $ont, array $opts)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        $ontSelector = UrlGenerator::getOntSelector($ont);

        $data = [
            XponApiHelper::KEY_ONTDELETE_RELATED => isset($opts[XponApiHelper::KEY_ONTDELETE_RELATED]) && $opts[XponApiHelper::KEY_ONTDELETE_RELATED] == true,
            XponApiHelper::KEY_ONTDELETE_CUSTOMER => isset($opts[XponApiHelper::KEY_ONTDELETE_CUSTOMER]) && $opts[XponApiHelper::KEY_ONTDELETE_CUSTOMER] == true,
        ];

        $this->getXponApiHelper()->delete("onts/$ontSelector", $data);

        $xajaxResponse->redirect(UrlGenerator::getUrlForPage(OntListPageController::class));

        return $xajaxResponse;
    }

    /**
     * @param array $ont
     * @param string $className
     * @return xajaxResponse
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function xajax_ontRefresh(array $ont, $className = null)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        $ontSelector = UrlGenerator::getOntSelector($ont);

        $this->getXponApiHelper()->get("onts/$ontSelector", [XponApiHelper::KEY_SOURCE => XponApiHelper::SOURCE_SNMP]);

        if ($className) {
            $xajaxResponse->redirect(UrlGenerator::getUrlForOnt($ont, $className));
        } else {
            $xajaxResponse->script('window.location.reload();');
        }

        return $xajaxResponse;
    }

    /**
     * @param array $ont
     * @return xajaxResponse
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function xajax_ontReboot(array $ont)
    {
        $ontSelector = UrlGenerator::getOntSelector($ont);

        $this->getXponApiHelper()->post("onts/$ontSelector/reboot");

        sleep(self::DELAY_ONT_REBOOT);

        return $this->xajax_ontRefresh($ont);
    }

    /**
     * @param array $ont
     * @return xajaxResponse
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function xajax_ontRestoreDefaults(array $ont)
    {
        $ontSelector = UrlGenerator::getOntSelector($ont);

        $this->getXponApiHelper()->post("onts/$ontSelector/restoredefaults");

        sleep(self::DELAY_ONT_RESTOREDEFAULTS);

        return $this->xajax_ontRefresh($ont);
    }

}
