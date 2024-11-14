<?php


namespace XponLmsPlugin\Controller\Page;


use InvalidArgumentException;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\Config;
use XponLmsPlugin\Lib\Pager;
use XponLmsPlugin\Lib\XponApiHelper;
use XponLmsPlugin\Model\OntModel;

class OntListPageController extends AbstractPageController
{
    const KEY_ONTLIST = 'xponOnts';

    const KEY_ONTSEARCH = 'xponOntSearch';

    /**
     * @throws InvalidArgumentException
     * @throws KeyNotSetException
     * @throws ApiException
     */
    protected function userShow()
    {
        $this->getPage()
            ->setTemplate('xpon/page/ontlist.tpl');

        $ontListLimit = $this->getConfig()->get(Config::CONFIG_ONTLIST_PAGELIMIT, Pager::DEFAULT_LIMIT);

        $pager = $this->createAndSetPagerFromQuery()
            ->setLimit($ontListLimit)
            ->setDefaultSort(implode(',', [OntModel::KEY_OLT_ID, OntModel::KEY_IFINDEX, OntModel::KEY_ID]));

        $queryParams = [];
        if (array_key_exists(XponApiHelper::KEY_SEARCH, $_GET)) {
            $search = $_GET[XponApiHelper::KEY_SEARCH];
            $queryParams[XponApiHelper::KEY_SEARCH] = $search;
            $this->getPage()->assign(self::KEY_ONTSEARCH, $search);
        }

        $ontlist = $this->getXponApiHelper()->get('onts', $queryParams, $pager);

        $this->getPage()->assign([
            self::KEY_ONTLIST => $ontlist,
        ]);
    }

}
