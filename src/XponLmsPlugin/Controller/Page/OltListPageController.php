<?php

namespace XponLmsPlugin\Controller\Page;

use InvalidArgumentException;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;

class OltListPageController extends AbstractPageController
{
    const KEY_OLTLIST = 'xponOlts';

    /**
     * @throws InvalidArgumentException
     * @throws KeyNotSetException
     * @throws ApiException
     */
    protected function userShow()
    {
        $this->getPage()
            ->setTemplate('xpon/page/oltlist.tpl');

        $oltlist = $this->getXponApiHelper()->getOltList();

        $this->getPage()->assign([
            self::KEY_OLTLIST => $oltlist,
        ]);
    }
}
