<?php


namespace XponLmsPlugin\Handler;


use XponLms;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\XponLmsPlugin;

class Handler
{
    /** @var XponLmsPlugin */
    protected $xponLmsPlugin;

    /**
     * @param XponLmsPlugin|null $xponLmsPlugin
     * @throws KeyNotSetException
     */
    public function __construct(XponLmsPlugin $xponLmsPlugin = null)
    {
        if (!$xponLmsPlugin) {
            $this->xponLmsPlugin = XponLms::whereIsMyPlugin();
        } else {
            $this->xponLmsPlugin = $xponLmsPlugin;
        }
    }
}
