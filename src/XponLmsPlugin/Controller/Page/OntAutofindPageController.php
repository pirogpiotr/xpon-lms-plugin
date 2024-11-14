<?php


namespace XponLmsPlugin\Controller\Page;


use InvalidArgumentException;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\XponApiHelper;

class OntAutofindPageController extends AbstractPageController
{
    const KEY_AUTOFIND = 'xponAutofind';
    const KEY_ERRORS = 'xponErrors';
    const KEY_SUCCESS = 'xponSuccess';

    /**
     * @throws InvalidArgumentException
     * @throws ApiException
     * @throws KeyNotSetException
     */
    protected function userShow()
    {
        $this->getPage()
            ->setTemplate('xpon/page/autofindlist.tpl');

        $response = $this->getXponApiHelper()->get('onts/autofind');

        if (!array_key_exists(XponApiHelper::KEY_RESPONSE_AUTOFIND, $response)) {
            throw new ApiException(null, "Response error");
        }

        $this->getPage()->assign([
            self::KEY_AUTOFIND => $response[XponApiHelper::KEY_RESPONSE_AUTOFIND],
            self::KEY_ERRORS => $response[XponApiHelper::KEY_RESPONSE_ERRORS],
            self::KEY_SUCCESS => $response[XponApiHelper::KEY_RESPONSE_SUCCESS],
        ]);
    }
}
