<?php

namespace XponLmsPlugin\Handler;

use Exception;
use XponLms;
use XponLmsPlugin\Controller\Page\OntListPageController;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Model\OntModel;

class NodeHandler
{
    const HOOK_NODEINFO = 'nodeinfo';

    /**
     * @param array $hookData
     * @return array
     * @throws ApiException
     */
    public function execHook_nodeinfo_before_display(array $hookData)
    {
        if (array_key_exists(self::HOOK_NODEINFO, $hookData) && !empty($hookData[self::HOOK_NODEINFO])) {
            $nodeId = $hookData[self::HOOK_NODEINFO]['id'];


            try {
                $xponLmsPlugin = XponLms::whereIsMyPlugin();
                $xponApiHelper = $xponLmsPlugin->getXponApiHelper();
            } catch (Exception $e) {
                return $hookData;
            }

            $onts = $xponApiHelper->get('onts', [OntModel::KEY_NODE_ID => $nodeId]);

            $smartyVars = [
                OntListPageController::KEY_ONTLIST => $onts,
            ];

            $xponLmsPlugin->getSmarty()->assign($smartyVars);
        }

        return $hookData;
    }

    /**
     * @param array $hookData
     * @return array
     * @throws ApiException
     */
    public function execHook_nodeedit_before_display(array $hookData)
    {
        return $this->execHook_nodeinfo_before_display($hookData);
    }

}
