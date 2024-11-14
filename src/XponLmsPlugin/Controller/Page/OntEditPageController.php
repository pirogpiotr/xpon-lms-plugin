<?php

namespace XponLmsPlugin\Controller\Page;

use InvalidArgumentException;
use RuntimeException;
use xajaxResponse;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\Config;
use XponLmsPlugin\Lib\UrlGenerator;
use XponLmsPlugin\Model\OntAttributeModel;
use XponLmsPlugin\Model\OntModel;

class OntEditPageController extends OntInfoPageController
{

    const KEY_CONTENT_NODES = 'contentNodes';

    const KEY_CONTENT_VOIP = 'contentVoip';

    const KEY_SETUPPROFILES = 'xponOntSetupProfiles';

    const KEY_ONTATTRIBUTES = 'xponOntAttributes';

    const VOIP_PORT_ID_1 = 1;
    const VOIP_PORT_ID_2 = 2;
    const VOIP_PORTS_ID = [self::VOIP_PORT_ID_1, self::VOIP_PORT_ID_2];
    const VOIP_PORTS_MAPPING = [self::VOIP_PORT_ID_1 => OntModel::KEY_VOIP_ACCOUNT_1, self::VOIP_PORT_ID_2 => OntModel::KEY_VOIP_ACCOUNT_2];

    public function userRegisterXajax()
    {
        parent::userRegisterXajax();

        $this->registerXajaxSimple(['redrawCustomerAccounts', 'ontUpdate', 'ontUpdateSaveOnly']);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ApiException
     * @throws KeyNotSetException
     */
    protected function userShow()
    {
        $ont = $this->getOntFromInputOrDie();

        $this->getPage()
            ->setTemplate('xpon/page/ontedit.tpl')
            ->assign([
                OntInfoPageController::KEY_ONT => $ont,
            ]);

        $this->prepareOntEditForm();
    }

    /**
     * @throws ApiException
     * @throws InvalidArgumentException
     * @throws KeyNotSetException
     */
    protected function prepareOntEditForm()
    {
        $page = $this->getPage();
        $ont = $this->ont;

        if (!$this->getConfig()->getBool(Config::CONFIG_BIG_NETWORKS)) {
            $page->assign('customers', $this->getLms()->GetCustomerNames());

            $customerId = isset($ont[OntModel::KEY_CUSTOMER_ID]) ? (int)$ont[OntModel::KEY_CUSTOMER_ID] : null;
            $nodeId = $customerId && isset($ont[OntModel::KEY_NODE_ID]) ? (int)$ont[OntModel::KEY_NODE_ID] : null;

            $voipPorts = [];
            foreach (self::VOIP_PORTS_MAPPING as $portId => $modelKey) {
                $voipPorts[$portId] = $customerId && isset($ont[$modelKey]) ? (int)$ont[$modelKey] : null;
            }

            $contentArray = $this->renderCustomerAccounts($customerId, $nodeId, $voipPorts);

            $page->assign($contentArray);
        }

        $ontSetupProfiles = $this->getXponApiHelper()->getOntSetupProfiles();

        $ontAttributes = $this->prepareOntAttributes();

        $page->assign([
            self::KEY_SETUPPROFILES => $ontSetupProfiles,
            self::KEY_ONTATTRIBUTES => $ontAttributes,
        ]);
    }

    /**
     * @param array $formValues
     * @return xajaxResponse
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function xajax_ontUpdateSaveOnly(array $formValues)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        $ont = $this->updateOntFromFormValues($formValues);

        $xajaxResponse->redirect(UrlGenerator::getUrlForOnt($ont));

        return $xajaxResponse;
    }

    /**
     * @param array $formValues
     * @return xajaxResponse
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function xajax_ontUpdate(array $formValues)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        $ont = $this->updateOntFromFormValues($formValues);

        UrlGenerator::redirectForOntSetup($xajaxResponse, $ont);

        return $xajaxResponse;
    }

    /**
     * @param $selectedCustomerId
     * @param null $selectedNodeId
     * @param array $selectedVoipAccounts Indeksowane ID portów, czyli 1, 2...
     * @return array
     */
    protected function renderCustomerAccounts($selectedCustomerId, $selectedNodeId = null, array $selectedVoipAccounts = [])
    {
        $lms = $this->getLms();

        if ($selectedCustomerId && $nodes = $lms->GetCustomerNodes($selectedCustomerId)) {
            $contentNodes = '<option value="" ' . ($selectedNodeId == null ? 'selected' : '') . '> - </option>';
            foreach ($nodes as $node) {
                $nodeId = $node['id'];
                $contentNodes .= sprintf('<option value="%d" %s>%s %s (%04d)</option>\n', $nodeId, ($selectedNodeId == $nodeId ? 'selected' : ''), $node['name'], $node['ip'], $nodeId);
            }
        } else {
            $contentNodes = '<option value="" selected>- brak komputerów -</option>';
        }

        $voipAccounts = $lms->GetCustomerVoipAccounts($selectedCustomerId);
        $contentVoip = [];

        foreach (static::VOIP_PORTS_ID as $portId) {
            $voipAccount = isset($selectedVoipAccounts[$portId]) ? intval($selectedVoipAccounts[$portId]) : null;

            if (empty($voipAccounts)) {
                $contentVoipCurrent = '<option value="" selected>- brak kont voip -</option>';
            } else {
                $contentVoipCurrent = '<option value="" ' . ($voipAccount == null ? 'selected' : '') . '> - </option>';

                foreach ($voipAccounts as $voip) {
                    $contentVoipCurrent .= sprintf("<option value=\"%d\" %s>%s %s (%04d)</option>\n",
                        $voip['id'], ($voipAccount == $voip['id'] ? 'selected' : ''), $voip['login'], $voip['phones'][0]['phone'], $voip['id']);
                }
            }

            $contentVoip[$portId] = $contentVoipCurrent;
        }

        return [
            static::KEY_CONTENT_NODES => $contentNodes,
            static::KEY_CONTENT_VOIP => $contentVoip,
        ];
    }

    /**
     * @return array
     * @throws ApiException
     */
    protected function prepareOntAttributes()
    {
        $ont = $this->ont;
        $equipId = isset($ont[OntModel::KEY_EQUIPID]) ? $ont[OntModel::KEY_EQUIPID] : null;

        $configuredOntAttributes = $this->getXponApiHelper()->getConfiguredOntAttributes($equipId);
        $configuredOntAttributes = array_column($configuredOntAttributes, null, OntAttributeModel::KEY_NAME);

        $ontAttributes = isset($ont[OntModel::KEY_ATTRIBUTES]) ? $ont[OntModel::KEY_ATTRIBUTES] : [];

        foreach ($ontAttributes as $name => $value) {
            if (!isset($configuredOntAttributes[$name])) {
                $configuredOntAttributes[$name] = [OntAttributeModel::KEY_NAME => $name];
            }
            $configuredOntAttributes[$name][OntAttributeModel::KEY_VALUE] = $value;
        }

        $configuredOntAttributes = array_values($configuredOntAttributes);

        usort($configuredOntAttributes, function ($dataA, $dataB) {
            if ($dataA[OntAttributeModel::KEY_PRIO] == $dataB[OntAttributeModel::KEY_PRIO]) {
                return 0;
            }

            return $dataA[OntAttributeModel::KEY_PRIO] > $dataB[OntAttributeModel::KEY_PRIO] ? -1 : 1;
        });

        return $configuredOntAttributes;
    }

    /**
     * @param int $selectedCustomerId
     * @param int $selectedNodeId
     * @return xajaxResponse
     */
    public function xajax_redrawCustomerAccounts($selectedCustomerId, $selectedNodeId = null)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        $contentArray = $this->renderCustomerAccounts($selectedCustomerId, $selectedNodeId);

        $xajaxResponse->assign('node-select', 'innerHTML', $contentArray[static::KEY_CONTENT_NODES]);

        foreach (static::VOIP_PORTS_ID as $portId) {
            $elemId = "voip-$portId-select";
            $content = isset($contentArray[static::KEY_CONTENT_VOIP][$portId]) ? $contentArray[static::KEY_CONTENT_VOIP][$portId] : '';
            $xajaxResponse->assign($elemId, 'innerHTML', $content);
        }

        return $xajaxResponse;
    }

    /**
     * @param array $formValues
     * @return array|object|string
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    protected function updateOntFromFormValues(array $formValues)
    {
        $ont = $this->fixOntFormValues($formValues);

        $ontSelector = UrlGenerator::getOntSelector($ont);

        return $this->getXponApiHelper()->patch("onts/$ontSelector", $ont);
    }

    /**
     * @param array $formValues
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function fixOntFormValues(array $formValues)
    {
        if (!isset($formValues[OntAddPageController::KEY_ONT_FORMDATA])) {
            throw new InvalidArgumentException('validation error: key \'' . OntAddPageController::KEY_ONT_FORMDATA . '\' is missing');
        }

        $ont = $formValues[OntAddPageController::KEY_ONT_FORMDATA];

        $servicesArr = [];
        if ($ont[OntModel::KEY_SERVICES]) {
            $servicesArr = array_flip(explode(',', $ont[OntModel::KEY_SERVICES]));
        }

        $internetEnabled = false;
        if ($ont[OntModel::KEY_NODE_ID]) {
            $internetEnabled = true;
        } else {
            foreach (['internet.login', 'internet.password', 'internet.ipaddress'] as $attrName) {
                if ($ont[OntModel::KEY_ATTRIBUTES][$attrName]) {
                    $internetEnabled = true;
                    break;
                }
            }
        }
        if ($internetEnabled) {
            $servicesArr[OntModel::SERVICE_INTERNET] = 1;
        } else {
            unset($servicesArr[OntModel::SERVICE_INTERNET]);
        }

        if ($ont[OntModel::KEY_VOIP_ACCOUNT_1] || $ont[OntModel::KEY_VOIP_ACCOUNT_2]) {
            $servicesArr[OntModel::SERVICE_VOIP] = 1;
        } else {
            unset($servicesArr[OntModel::SERVICE_VOIP]);
        }

        if (isset($formValues['service_iptv']) && $formValues['service_iptv'] == '1') {
            $servicesArr[OntModel::SERVICE_IPTV] = 1;
        } else {
            unset($servicesArr[OntModel::SERVICE_IPTV]);
        }

        $ont[OntModel::KEY_SERVICES] = array_keys($servicesArr);

        $ont[OntModel::KEY_IPTV_PORTS] = (isset($formValues['service_iptv_ports']) ? array_values($formValues['service_iptv_ports']) : []);

        return $ont;
    }

}
