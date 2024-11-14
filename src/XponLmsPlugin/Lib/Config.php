<?php


namespace XponLmsPlugin\Lib;


use ConfigHelper;

class Config
{
    const CONFIG_SECTION = 'xpon';
    const CONFIG_ONTLIST_PAGELIMIT = self::CONFIG_SECTION . '.ontlist_pagelimit';

    const CONFIG_API_URL = self::CONFIG_SECTION . '.api_url';
    const CONFIG_API_LOGIN = self::CONFIG_SECTION . '.api_login';
    const CONFIG_API_PASSWORD = self::CONFIG_SECTION . '.api_password';

    const CONFIG_BIG_NETWORKS = 'phpui.big_networks';

    /** @var ConfigHelper */
    protected $configHelper;

    public function __construct($className)
    {
        $this->configHelper = $className;
    }

    /**
     * @param $name
     * @param mixed $defaultValue
     * @return string|null
     */
    public function get($name, $defaultValue = null)
    {
        $configHelper = $this->configHelper;

        return $configHelper::getConfig($name, $defaultValue);
    }

    /**
     * Parsuje wartość do bool
     * @param string $name
     * @return bool
     */
    public function getBool($name)
    {
        $configHelper = $this->configHelper;

        return $configHelper::checkConfig($name);
    }
}
