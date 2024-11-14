<?php

namespace XponLmsPlugin\Controller;

use InvalidArgumentException;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Lib\UrlGenerator;
use XponLmsPlugin\Lib\XponApiHelper;
use XponLmsPlugin\Model\OntModel;

class OntSearchServiceController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     * @throws ApiException
     */
    public function run()
    {
        if (!array_key_exists(XponApiHelper::KEY_SEARCH, $_GET) || !($search = $_GET[XponApiHelper::KEY_SEARCH])) {
            printf("key 'search' missing");
            exit(1);
        }

        $onts = $this->getXponApiHelper()->get('onts/', [XponApiHelper::KEY_SEARCH => $search]);

        $dataArr = [];

        foreach ($onts as $ont) {
            $dataArr[] = [
                // 'icon' => 'fa-fw lms-ui-icon-hide',
                'name' => sprintf("%d:%d/%d/%d.%d %s",
                    $ont[OntModel::KEY_OLT_ID], $ont[OntModel::KEY_FRAME], $ont[OntModel::KEY_SLOT], $ont[OntModel::KEY_PORT],
                    $ont[OntModel::KEY_ID], $ont[OntModel::KEY_SN]
                ),
                'name_class' => '',
                'description' => sprintf("%s %s %s",
                    $ont[OntModel::KEY_DESCRIPTION],
                    $ont[OntModel::KEY_CUSTOMER_NAME], $ont[OntModel::KEY_CUSTOMER_ADDRESS]
                ),
                'description_class' => '',
                'action' => UrlGenerator::getUrlForOnt($ont),
            ];
        }

        header('Content-type: application/json');
        echo json_encode($dataArr);
        exit(0);
    }
}
