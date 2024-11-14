<?php

namespace XponLmsPlugin\Model;

class OltSlotModel
{
    const KEY_OLT_ID = 'oltid';

    const KEY_FRAME = 'frame';
    const KEY_SLOT = 'slot';

    const KEY_TYPE = 'type';
    const KEY_TYPENAME = 'typename';

    const KEY_DESCRIPTION = 'description';
    const KEY_VERSION = 'version';

    const KEY_WORKMODE = 'workmode';
    const KEY_SUBSLOTS = 'subslots';

    const KEY_OPERSTATUS = 'operstatus';
    const KEY_ADMINSTATUS = 'adminstatus';
    const KEY_PRIMARYSTATUS = 'primarystatus';
    const KEY_SECONDARYSTATUS = 'secondarystatus';
    const KEY_SERIAL = 'serial';
    const KEY_SHUTDOWNSTATE = 'shutdownstate';
    const KEY_TEMPERATURE = 'temperature';
    const KEY_CLEICODE = 'cleicode';

    const KEYS = [
        self::KEY_OLT_ID,
        self::KEY_FRAME,
        self::KEY_SLOT,
        self::KEY_TYPE,
        self::KEY_TYPENAME,

        self::KEY_DESCRIPTION,
        self::KEY_VERSION,

        self::KEY_WORKMODE,
        self::KEY_SUBSLOTS,

        self::KEY_OPERSTATUS,
        self::KEY_ADMINSTATUS,
        self::KEY_PRIMARYSTATUS,
        self::KEY_SECONDARYSTATUS,
        self::KEY_SERIAL,
        self::KEY_SHUTDOWNSTATE,
        self::KEY_TEMPERATURE,
        self::KEY_CLEICODE,
    ];
}
