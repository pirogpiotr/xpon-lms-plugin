<?php

use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Handler\CustomerHandler;
use XponLmsPlugin\Handler\InitHandler;
use XponLmsPlugin\Handler\NodeHandler;
use XponLmsPlugin\Lib\Config;
use XponLmsPlugin\XponLmsPlugin;

/**
 *
 * Class XponLms
 */
class XponLms extends LMSPlugin
{
    /** @var bool */
    const DEVEL = false;

    /** @var bool */
    const ENABLE_WARNINGS = false;

    // const URL_PUBLIC = 'img/' . XponLms::PLUGIN_DIRNAME . '/';
    const URL_PUBLIC = 'plugins/' . XponLms::PLUGIN_DIRNAME . '/public/';

    const VERSION = '0.1';
    const VERSION_TIMESTAMP = '20210415';

    const PLUGIN_NAME = 'XponLmsPlugin';
    const PLUGIN_DESCRIPTION = 'Obsługa systemu Xpon v' . self::VERSION;
    const PLUGIN_AUTHOR = 'Piotr Piróg pirogpiotr@gmail.com';

    const PLUGIN_DIRNAME = self::class;
    const PATH_PLUGIN = __DIR__ . DIRECTORY_SEPARATOR;
    const PATH_MODULES = self::PATH_PLUGIN . 'modules' . DIRECTORY_SEPARATOR;
    const PATH_TEMPLATES = self::PATH_PLUGIN . 'templates' . DIRECTORY_SEPARATOR;

    const METHODPREFIX = 'execHook_';

    /** @var XponLmsPlugin */
    protected static $xponLmsPlugin;

    /** @var array */
    protected $handlers = [];

    /**
     * LMS Entry Point
     * @throws RuntimeException
     */
    public function __construct()
    {
        parent::__construct();

        $config = new Config(ConfigHelper::class);
        $xponLmsPlugin = new XponLmsPlugin($config);

        static::setXponLmsPlugin($xponLmsPlugin);
    }

    /**
     * @return XponLmsPlugin
     * @throws KeyNotSetException
     */
    public static function whereIsMyPlugin()
    {
        if (static::$xponLmsPlugin === null) {
            throw new KeyNotSetException(__METHOD__ . ": XponLmsPlugin instance is not set!");
        }

        return static::$xponLmsPlugin;
    }

    public static function setXponLmsPlugin(XponLmsPlugin $xponLmsPlugin)
    {
        static::$xponLmsPlugin = $xponLmsPlugin;

        return $xponLmsPlugin;
    }

    /**
     * LMS Entry Point
     */
    public function registerHandlers()
    {
        $this->handlers = [];

        $hookArr = ['lms_initialized', 'smarty_initialized', 'modules_dir_initialized', 'menu_initialized', 'access_table_initialized'];
        $this->_registerHookArr(InitHandler::class, $hookArr);

        $hookArr = ['customerinfo_before_display', 'customeredit_before_display'];
        $this->_registerHookArr(CustomerHandler::class, $hookArr);

        $hookArr = ['nodeinfo_before_display', 'nodeedit_before_display'];
        $this->_registerHookArr(NodeHandler::class, $hookArr);
    }

    /**
     * @param string $className
     * @param array $hookArr
     */
    protected function _registerHookArr($className, array $hookArr)
    {
        foreach ($hookArr as $hookName) {
            $this->handlers[$hookName] = [
                'class' => $className,
                'method' => static::METHODPREFIX . $hookName,
            ];
        }
    }

}
