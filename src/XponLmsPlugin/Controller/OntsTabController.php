<?php

namespace XponLmsPlugin\Controller;

use Exception;
use Smarty;
use XponLms;
use XponLmsPlugin\Model\OntModel;

class OntsTabController extends AbstractController
{
    public static function init(array $hookData)
    {
        try {
            $xponLmsPlugin = XponLms::whereIsMyPlugin();

            $controller = new OntsTabController($xponLmsPlugin);
            $controller->run($hookData);
        } catch (Exception $e) {
            if (isset($hookData['smarty'])) {
                /** @var Smarty $smarty */
                $smarty = $hookData['smarty'];
                $smarty->assign('xponerror', $e->getMessage());
            }
        }

        return $hookData;
    }

    public function assignXajaxToSmartyIfNeeded()
    {
        $smarty = $this->getSmarty();

        $xajax = $smarty->getTemplateVars('xajax');

        if (!$xajax) {
            $smarty->assign([
                'xajax' => $this->getLms()->RunXajax(),
                'xponRunXajax' => true,
            ]);
        }
    }

    public function registerXajax()
    {
        $this->registerXajaxSimple('refreshOntsTab');
        $this->assignXajaxToSmartyIfNeeded();
    }

    public function run($hookData)
    {
        $this->registerXajax();
    }

    public function xajax_refreshOntsTab($formValues)
    {
        $xajaxResponse = $this->factoryXajaxResponse();

        if (isset($formValues[OntModel::KEY_CUSTOMER_ID]) || isset($formValues[OntModel::KEY_NODE_ID])) {
            try {
                $xponApiHelper = $this->getXponApiHelper();

                if (isset($formValues[OntModel::KEY_NODE_ID])) {
                    $queryParams = [OntModel::KEY_NODE_ID => $formValues[OntModel::KEY_NODE_ID]];
                } else {
                    $queryParams = [OntModel::KEY_CUSTOMER_ID => $formValues[OntModel::KEY_CUSTOMER_ID]];
                }
                $onts = $xponApiHelper->get('onts', $queryParams);

                $smarty = $this->getSmarty();
                $smarty->assign([
                    'onts' => $onts,
                    'ontsWasLoaded' => 1,
                ]);

                $html = $smarty->fetch('xpon/component/ontstab-content.tpl');
                $xajaxResponse->assign('xpon-ontlist-content', 'innerHTML', $html);
            } catch (Exception $e) {
                $xajaxResponse->script('var err = ' . json_encode($e->getMessage()) . '; console.error("data load failed becouse of: ", err); ');
                $xajaxResponse->script('
                    var err = ' . json_encode($e->getMessage()) . ';
                    document.getElementById("xpon-ontlist-content").innerHTML=`<div class="lms-ui-tab-empty-table"><span style="color: red; font-weight: bold;">${err}</div>`;
                ');
                return $xajaxResponse;
            }

        }

        return $xajaxResponse;
    }
}
