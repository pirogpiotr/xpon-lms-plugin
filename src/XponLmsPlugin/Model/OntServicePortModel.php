<?php
/** @noinspection PhpUnused */

namespace XponLmsPlugin\Model;

class OntServicePortModel
{
    const KEY_ID = 'id';
    const KEY_TARGETTYPE = 'targettype';
    const KEY_PORTS = 'ports';

    const KEY_GEM = 'gem';
    const KEY_TYPE = 'type';
    const KEY_MULTISERVICETYPE = 'multiservicetype';
    const KEY_VLAN = 'vlan';
    const KEY_USERVLAN = 'uservlan';
    const KEY_VLAN_DESCRIPTION = 'vlandescription';
    const KEY_TAGTRANSFORM = 'tagtransform';
    const KEY_ADMINSTATUS = 'enabled';
    const KEY_OPERSTATUS = 'state';
    const KEY_DESCRIPTION = 'description';
    const KEY_DESCRIPTION_REMOTE = 'remotedescription';
    const KEY_TRAFFICTABLE_OUTBOUND = 'traffictableoutbound';
    const KEY_TRAFFICTABLE_INBOUND = 'traffictableinbound';
    const KEY__TIMESTAMP = '_timestamp';

    const KEYS = [
        self::KEY_ID,

        self::KEY_TARGETTYPE,
        self::KEY_PORTS,
        self::KEY_GEM,
        self::KEY_TYPE,
        self::KEY_MULTISERVICETYPE,
        self::KEY_VLAN,
        self::KEY_USERVLAN,
        self::KEY_VLAN_DESCRIPTION,
        self::KEY_TAGTRANSFORM,
        self::KEY_ADMINSTATUS,
        self::KEY_OPERSTATUS,
        self::KEY_DESCRIPTION,
        self::KEY_DESCRIPTION_REMOTE,
        self::KEY_TRAFFICTABLE_OUTBOUND,
        self::KEY_TRAFFICTABLE_INBOUND,
        self::KEY__TIMESTAMP,
    ];

    const TYPE_E2E = 14;
    const TYPE_GEM = 4;

    const TARGETTYPE_IPHOST = 1;
    const TARGETTYPE_PORT = 0;
    const TARGETTYPE_ONT = 255;

    const TAGTRANSFORM_DEFAULT = 0;
    const TAGTRANSFORM_TRANSPARENT = 1;
    const TAGTRANSFORM_TRANSLATE = 2;
    const TAGTRANSFORM_TRANSLATEANDADD = 3;

    const TAGTRANSFORM_TEXTS = [
        self::TAGTRANSFORM_DEFAULT => 'default',
        self::TAGTRANSFORM_TRANSPARENT => 'transparent',
        self::TAGTRANSFORM_TRANSLATE => 'translate',
        self::TAGTRANSFORM_TRANSLATEANDADD => 'translateAndAdd',
    ];
}
