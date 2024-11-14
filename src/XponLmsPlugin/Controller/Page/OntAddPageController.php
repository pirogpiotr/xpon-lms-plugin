<?php

namespace XponLmsPlugin\Controller\Page;

use InvalidArgumentException;
use RuntimeException;
use xajaxResponse;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\UrlGenerator;
use XponLmsPlugin\Model\OltModel;
use XponLmsPlugin\Model\OltPortGponModel;
use XponLmsPlugin\Model\OltSlotModel;
use XponLmsPlugin\Model\OntModel;

class OntAddPageController extends OntEditPageController
{
    const KEY_CONTENT_SLOTS = 'contentSlots';

    const KEY_CONTENT_PORTS = 'contentPorts';

    const KEY_ONT_FORMDATA = 'ont';

    public function userRegisterXajax()
    {
        parent::userRegisterXajax();

        $this->registerXajaxSimple(['redrawSlotPort', 'ontAdd']);
    }

    /**
     * @throws KeyNotSetException
     * @throws InvalidArgumentException
     * @throws ApiException
     */
    protected function userShow()
    {
        $page = $this->getPage()
            ->setTemplate('xpon/page/ontadd.tpl');

        if ($ont = filter_input(INPUT_POST, self::KEY_ONT_FORMDATA, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY)) {
            $page->assign(OntInfoPageController::KEY_ONT, $ont);
            $this->ont = $ont;
        }

        $this->prepareOntEditForm();

        $oltId = null;

        if (!$ont) {
            $olts = $this->getXponApiHelper()->getOltList();
            $page->assign(OltListPageController::KEY_OLTLIST, $olts);

            $oltId = count($olts) === 1 ? reset($olts)[OltModel::KEY_ID] : null;
        }

        $page->assign($this->renderSlotPort($oltId));
    }

    /**
     * @param array $formValues
     * @return xajaxResponse
     * @throws ApiException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function xajax_ontAdd(array $formValues)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        if (!isset($formValues[self::KEY_ONT_FORMDATA])) {
            throw new InvalidArgumentException('validation error: key \'ont\' is missing');
        }

        $ont = $this->fixOntFormValues($formValues);

        $response = $this->getXponApiHelper()->post("onts", $ont);

        if (!array_key_exists(OntModel::KEY_CONFIGMODE, $response)) {
            throw new RuntimeException("ont add: response validation failed");
        }

        $configMode = $response[OntModel::KEY_CONFIGMODE];
        if (in_array($configMode, [OntModel::CONFIGMODE_AUTO, OntModel::CONFIGMODE_PROFILE])) {
            UrlGenerator::redirectForOntSetup($xajaxResponse, $response);
        } else {
            $xajaxResponse->redirect(UrlGenerator::getUrlForOnt($response));
        }


        return $xajaxResponse;
    }

    /**
     * @param $selectedOltId
     * @param $selectedSlotId
     * @return xajaxResponse
     * @throws ApiException
     */
    public function xajax_redrawSlotPort($selectedOltId, $selectedSlotId)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        $selectedOltId = is_numeric($selectedOltId) ? (int)$selectedOltId : null;
        $selectedSlotId = is_numeric($selectedSlotId) ? (int)$selectedSlotId : null;

        $contentArray = $this->renderSlotPort($selectedOltId, $selectedSlotId);

        $xajaxResponse
            ->assign('slot-select', 'innerHTML', $contentArray[static::KEY_CONTENT_SLOTS])
            ->assign('port-select', 'innerHTML', $contentArray[static::KEY_CONTENT_PORTS]);

        return $xajaxResponse;
    }

    /**
     * @param int|null $selectedOltId
     * @param int|null $selectedSlotId
     * @return string[]
     * @throws ApiException
     */
    protected function renderSlotPort($selectedOltId = null, $selectedSlotId = null)
    {
        $xponApihelper = $this->getXponApiHelper();
        if (!$selectedOltId) {
            $contentSlots = '<option value="" style="display: none;">- wybierz OLT -</option>';
            $contentPorts = '<option value="" style="display: none;">- wybierz OLT -</option>';
        } else {
            $slots = $xponApihelper->getGponSlotList($selectedOltId);

            $contentSlots = '<option value="" style="display: none;">- wybierz slot -</option>';

            foreach ($slots as $slot) {
                $slotId = $slot[OltSlotModel::KEY_SLOT];
                if (count($slots) < 2) {
                    $selectedSlotId = $slotId;
                }
                $contentSlots .= sprintf('<option value="%d" %s>%d/%d %s</option>\n', $slotId,
                    ($selectedSlotId === $slotId || count($slots) < 2 ? 'selected' : ''),
                    $slot[OltSlotModel::KEY_FRAME], $slotId, $slot[OltSlotModel::KEY_DESCRIPTION]);
            }

            if ($selectedSlotId === null) {
                $contentPorts = '<option value="" style="display: none;">- wybierz slot -</option>';
            } else {
                $contentPorts = '<option value="" style="display: none;">- wybierz port -</option>';
                $ports = $xponApihelper->getGponPortList($selectedOltId, $selectedSlotId);

                foreach ($ports as $port) {
                    $portId = $port[OltPortGponModel::KEY_PORT];
                    $contentPorts .= sprintf('<option value="%d">%d %s</option>\n', $portId, $portId, $port[OltPortGponModel::KEY_DESCRIPTION]);
                }
            }
        }

        return [
            static::KEY_CONTENT_SLOTS => $contentSlots,
            static::KEY_CONTENT_PORTS => $contentPorts,
        ];
    }

}
