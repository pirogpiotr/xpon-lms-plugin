<?php


namespace XponLmsPlugin\Handler;


use AccessRights;
use Exception;
use InvalidArgumentException;
use LMS;
use Permission;
use Smarty;
use Smarty_Internal_Template;
use SmartyException;
use XponLms;
use XponLmsPlugin\Controller\Page\OltListPageController;
use XponLmsPlugin\Controller\Page\OntAddPageController;
use XponLmsPlugin\Controller\Page\OntAutofindPageController;
use XponLmsPlugin\Controller\Page\OntListPageController;
use XponLmsPlugin\Lib\Helper;
use XponLmsPlugin\Lib\UrlGenerator;

class InitHandler extends Handler
{
    const KEY_MENUITEM_NAME = 'name';
    const KEY_MENUITEM_LINK = 'link';
    const KEY_MENUITEM_TIP = 'tip';
    const KEY_MENUITEM_PRIO = 'prio';
    const KEY_MENUITEM_IMG = 'img';
    const KEY_MENUITEM_CSS = 'css';

    public function execHook_lms_initialized(LMS $lms)
    {
        $this->xponLmsPlugin->setLms($lms);

        return $lms;
    }

    /**
     *
     * @param Smarty $smarty
     * @return Smarty
     * @throws SmartyException
     */
    public function execHook_smarty_initialized(Smarty $smarty)
    {
        XponLms::insertDefaultTemplateDir($smarty);

        if (XponLms::ENABLE_WARNINGS) {
            $smarty->error_unassigned = true;
            $smarty->error_reporting = 0xFFFFFF;
        }

        $this->registerSmartyPlugins($smarty);

        $this->xponLmsPlugin->setSmarty($smarty);

        return $smarty;
    }

    /**
     * @param Smarty $smarty
     * @throws SmartyException
     */
    public static function registerSmartyPlugins(Smarty $smarty)
    {
        $smarty->registerPlugin(Smarty::PLUGIN_MODIFIER, "dateDiffShort", function ($unixtimestamp) {
            return Helper::dateDiffShort($unixtimestamp);
        });

        $smarty->registerPlugin(Smarty::PLUGIN_MODIFIER, "intervalDiffShort", function ($unixtimestamp) {
            return Helper::intervalDiffShort($unixtimestamp);
        });

        $smarty->registerPlugin(Smarty::PLUGIN_FUNCTION, "printListHeader", function ($params, Smarty_Internal_Template $smarty) {
            return Helper::printListHeader($params, $smarty);
        });
    }

    public function execHook_modules_dir_initialized(array $modulesDirs)
    {
        $xponModulesDir = XponLms::PATH_MODULES;
        array_unshift($modulesDirs, $xponModulesDir);

        return $modulesDirs;
    }

    /**
     * @param array $menuArray
     * @return array
     * @throws InvalidArgumentException
     */
    public function execHook_menu_initialized(array $menuArray = [])
    {
        $newMenu = [
            'xpon' => [
                self::KEY_MENUITEM_NAME => 'XPON',
                self::KEY_MENUITEM_IMG => '../'. UrlGenerator::getPublic('img/favicon-16.png'),
                // self::KEY_MENUITEM_CSS => 'lms-ui-menu-item-icon times',
                self::KEY_MENUITEM_TIP => 'XPON',
                self::KEY_MENUITEM_PRIO => 20,
                'submenu' => [
                    [
                        self::KEY_MENUITEM_NAME => 'Lista ONT',
                        self::KEY_MENUITEM_LINK => UrlGenerator::getUrlForPage(OntListPageController::class),
                        // self::KEY_MENUITEM_PRIO => 32,
                        self::KEY_MENUITEM_TIP => null,
                    ], [
                        self::KEY_MENUITEM_NAME => 'Dodaj ONT (Autofind)',
                        self::KEY_MENUITEM_LINK => UrlGenerator::getUrlForPage(OntAutofindPageController::class),
                        // self::KEY_MENUITEM_PRIO => 31,
                        self::KEY_MENUITEM_TIP => null,
                    ], [
                        self::KEY_MENUITEM_NAME => 'Dodaj ONT (Ręcznie)',
                        self::KEY_MENUITEM_LINK => UrlGenerator::getUrlForPage(OntAddPageController::class),
                        self::KEY_MENUITEM_TIP => null,
                    ], [
                        self::KEY_MENUITEM_NAME => '---',
                        self::KEY_MENUITEM_TIP => null,
                    ], [
                        self::KEY_MENUITEM_NAME => 'Lista OLT',
                        self::KEY_MENUITEM_LINK => UrlGenerator::getUrlForPage(OltListPageController::class),
                        // self::KEY_MENUITEM_PRIO => 100,
                        self::KEY_MENUITEM_TIP => null,
                    ], [
                        self::KEY_MENUITEM_NAME => '---',
                        self::KEY_MENUITEM_TIP => null,
                    ], [
                        self::KEY_MENUITEM_NAME => 'Konfiguracja',
                        self::KEY_MENUITEM_LINK => '?m=configlist&s=xpon',
                        // self::KEY_MENUITEM_PRIO => 1000,
                        self::KEY_MENUITEM_TIP => null,
                    ],
                ],
            ],
        ];

        $menuKeys = array_keys($menuArray);
        $i = array_search('netdevices', $menuKeys);
        return array_slice($menuArray, 0, $i, true) + $newMenu + array_slice($menuArray, $i, null, true);
    }

    /**
     * @return void Wynik nie jest używany do niczego
     * @throws Exception
     */
    public function execHook_access_table_initialized()
    {
        AccessRights::getInstance()
            ->insertPermission(new Permission(
                'xpon_full',
                'XPON full access',
                '^xpon-.*$',
                null,
                ['xpon' => Permission::MENU_ALL]
            ), AccessRights::FIRST_FORBIDDEN_PERMISSION);
    }

}
