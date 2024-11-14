<?php

namespace XponLmsPlugin\Handler;

use Exception;
use InvalidArgumentException;
use Smarty;
use XponLms;
use XponLmsPlugin\Controller\OntsTabController;
use XponLmsPlugin\Exception\KeyNotSetException;

class CustomerHandler extends Handler
{
    const HOOK_CUSTOMERINFO = 'customerinfo';

    /**
     * @param array $hookData Zawiera .smarty i .customerinfo
     * @return array zwraca $hookData
     * @throws InvalidArgumentException
     * @throws KeyNotSetException
     */
    public function execHook_customerinfo_before_display(array $hookData)
    {
        OntsTabController::init($hookData);

        return $hookData;
    }

    /**
     * @param array $hook_data
     * @return array
     * @throws InvalidArgumentException
     * @throws KeyNotSetException
     */
    public function execHook_customeredit_before_display(array $hook_data)
    {
        return $this->execHook_customerinfo_before_display($hook_data);
    }
}
