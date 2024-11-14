<?php

namespace XponLmsPlugin\Model;

class OntAttributeModel
{
    const KEY_HIDDEN = 'hidden';
    const KEY_NAME = 'name';
    const KEY_VALUE = 'value';
    const KEY_ENABLED = 'enabled';
    const KEY_DISPLAYNAME = 'displayname';
    const KEY_DESCRIPTION = 'description';
    const KEY_ENABLESWITCH = 'enableswitch';
    const KEY_PRIO = 'prio';
    const KEY_TYPE = 'type';
    const KEY_DEFAULTVALUE = 'defaultvalue';
    const KEY_DEFAULTENABLED = 'defaultenabled';
    const KEY_MINLENGTH = 'minlength';
    const KEY_MAXLENGTH = 'maxlength';
    const KEY_REQUIRE_CAP = 'require_cap';

    const KEYS = [
        self::KEY_HIDDEN,
        self::KEY_NAME,
        self::KEY_VALUE,
        self::KEY_ENABLED,
        self::KEY_DISPLAYNAME,
        self::KEY_DESCRIPTION,
        self::KEY_ENABLESWITCH,
        self::KEY_PRIO,
        self::KEY_TYPE,
        self::KEY_DEFAULTVALUE,
        self::KEY_DEFAULTENABLED,
        self::KEY_MINLENGTH,
        self::KEY_MAXLENGTH,
        self::KEY_REQUIRE_CAP,
    ];
}
