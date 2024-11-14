<?php

namespace XponLmsPlugin\Controller\Page;

use Exception;
use InvalidArgumentException;
use RuntimeException;
use SmartyException;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\UrlGenerator;
use XponLmsPlugin\Lib\XponApiHelper;
use XponLmsPlugin\Model\OntModel;

class OntSetupPageController extends OntInfoPageController
{

    public function userRegisterXajax()
    {
    }

    protected function userShow()
    {
    }

    /**
     * @throws ApiException
     * @throws InvalidArgumentException
     * @throws KeyNotSetException
     * @throws RuntimeException
     * @throws SmartyException
     */
    public function show()
    {
        $ont = $this->getOntFromInputOrDie(INPUT_POST);

        $page = $this->getPage();

        $page->setTemplate('header.html')->display();
        $page->setTemplate('lmsboxbase.tpl')->display();

        $ontSelector = UrlGenerator::getOntSelector($ont);

        printf("<h2>Konfigurowanie ONT $ontSelector \"%s\"</h2>", $ont[OntModel::KEY_DESCRIPTION]);

        print('<TABLE WIDTH="100%" class="superlight" CELLPADDING="5"><TR><TD class="fall">');

        flush();

        $data = [
            XponApiHelper::KEY_ONTSETUP_SETUP => XponApiHelper::ONTSETUP_ALL,
        ];

        try {
            $response = $this->getXponApiHelper()->post("onts/$ontSelector/setup", $data);

            $wasOk = array_key_exists(XponApiHelper::KEY_MESSAGE, $response);
            if ($wasOk) {
                print(nl2br($response[XponApiHelper::KEY_MESSAGE]));
            }
        } catch (Exception $e) {
            print(nl2br(sprintf("<span class='xpon-error'>Błąd</span>\nKlasa: %s\nKod: %d\nKomunikat: %s\n", get_class($e), $e->getCode(), $e->getMessage())));
        } finally {
            print('</TD></TR></TABLE>');

            printf('<div class="center">
                <a class="lms-ui-button lms-ui-link-button" title="Wróć do ONT" href="%s">
                    <i class="lms-ui-icon-cancel"></i><span class="lms-ui-label">Wróc do ONT</span>
                </a>
            </div>', UrlGenerator::getUrlForOnt($ont));
        }

        $page->setTemplate('footer.html')->display();
    }

}
