<?php

namespace XponLmsPlugin\Model;

/**
 * Class OntAutofindModel
 * @package XponLmsPlugin\Model
 * @noinspection PhpUnused @smarty
 */
class OntAutofindModel
{
    const KEY_OLT_ID = 'oltid';
    const KEY_OLT_NAME = 'oltname';
    const KEY_OLT_DESCRIPTION = 'oltdescription';
    const KEY_FRAME = 'frame';
    const KEY_SLOT = 'slot';
    const KEY_PORT = 'port';
    const KEY_ID = 'id';
    const KEY_IFINDEX = 'ifindex';

    const KEY_PORT_DESCRIPTION = 'portdescription';
    const KEY_SN = 'sn';
    const KEY_PASSWORD = 'password';
    const KEY_VERSION = 'version';
    const KEY_HWVERSION = 'hwversion';
    const KEY_VENDORID = 'vendorid';
    const KEY_EQUIPID = 'equipid';

    const KEY_FINDTIME = 'findtime';

    const KEYS = [
        self::KEY_OLT_ID,
        self::KEY_OLT_NAME,
        self::KEY_OLT_DESCRIPTION,
        self::KEY_FRAME,
        self::KEY_SLOT,
        self::KEY_PORT,
        self::KEY_ID,
        self::KEY_IFINDEX,

        self::KEY_PORT_DESCRIPTION,
        self::KEY_SN,
        self::KEY_PASSWORD,
        self::KEY_VERSION,
        self::KEY_HWVERSION,
        self::KEY_VENDORID,
        self::KEY_EQUIPID,

        self::KEY_FINDTIME,
    ];
}
