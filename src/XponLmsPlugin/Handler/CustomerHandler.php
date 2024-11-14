<?php

namespace XponLmsPlugin\Handler;

use Exception;
use XponLms;
use XponLmsPlugin\Controller\Page\OntListPageController;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Model\OntModel;

class CustomerHandler extends Handler
{
    const HOOK_CUSTOMERINFO = 'customerinfo';

    /**
     * @param array $hookData Zawiera .smarty i .customerinfo
     * @return array zwraca $hookData
     * @throws ApiException
     */
    public function execHook_customerinfo_before_display(array $hookData)
    {
        if (array_key_exists(self::HOOK_CUSTOMERINFO, $hookData) && !empty($hookData[self::HOOK_CUSTOMERINFO])) {

            $customerInfo = $hookData[self::HOOK_CUSTOMERINFO];
            $customerId = $customerInfo['id'];


            try {
                $xponLmsPlugin = XponLms::whereIsMyPlugin();
                $xponApiHelper = $xponLmsPlugin->getXponApiHelper();
            } catch (Exception $e) {
                return $hookData;
            }

            $onts = $xponApiHelper->get('onts', [OntModel::KEY_CUSTOMER_ID => $customerId]);

            $smartyVars = [
                OntListPageController::KEY_ONTLIST => $onts,
            ];

            $xponLmsPlugin->getSmarty()->assign($smartyVars);
        }

        return $hookData;
    }

    /**
     * @param array $hook_data
     * @return array
     * @throws ApiException
     */
    public function execHook_customeredit_before_display(array $hook_data)
    {
        return $this->execHook_customerinfo_before_display($hook_data);
    }
}
