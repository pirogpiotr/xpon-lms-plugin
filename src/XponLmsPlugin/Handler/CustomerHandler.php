<?php

namespace XponLmsPlugin\Handler;

use XponLmsPlugin\Controller\OntsTabController;

class CustomerHandler extends Handler
{
    const HOOK_CUSTOMERINFO = 'customerinfo';

    /**
     * @param array $hookData Zawiera .smarty i .customerinfo
     * @return array zwraca $hookData
     */
    public function execHook_customerinfo_before_display(array $hookData)
    {
        return OntsTabController::init($hookData);
    }

    /**
     * @param array $hook_data
     * @return array
     */
    public function execHook_customeredit_before_display(array $hook_data)
    {
        return $this->execHook_customerinfo_before_display($hook_data);
    }
}
