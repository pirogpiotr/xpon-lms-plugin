<?php

namespace XponLmsPlugin\Handler;

use XponLmsPlugin\Controller\OntsTabController;
use XponLmsPlugin\Exception\ApiException;

class NodeHandler
{
    const HOOK_NODEINFO = 'nodeinfo';

    /**
     * @param array $hookData
     * @return array
     */
    public function execHook_nodeinfo_before_display(array $hookData)
    {
        OntsTabController::init($hookData);
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
