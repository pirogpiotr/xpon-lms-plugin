<?php
/** @noinspection PhpUnused */

namespace XponLmsPlugin\Model;

class OntPortEthModel
{
    const KEY_ID = 'id';
    const KEY_ENABLED = 'enabled';
    const KEY_STATUS = 'status';
    const KEY_PORTTYPE = 'porttype';
    const KEY_AUTONEGOTIATION = 'autonegotiation';
    const KEY_DUPLEX = 'duplex';
    const KEY_VLAN_ID = 'vlanid';
    const KEY_VLAN_PRIORITY = 'vlanpriority';
    const KEY_SPEED = 'speed';

    const KEYS = [
        self::KEY_ID,
        self::KEY_ENABLED,
        self::KEY_STATUS,
        self::KEY_PORTTYPE,
        self::KEY_AUTONEGOTIATION,
        self::KEY_DUPLEX,
        self::KEY_VLAN_ID,
        self::KEY_VLAN_PRIORITY,
        self::KEY_SPEED,
    ];

    const DUPLEX_HALF = 1;
    const DUPLEX_FULL = 2;
    const DUPLEX_AUTONEG = 3;
    const DUPLEX_AUTOHALF = 4;
    const DUPLEX_AUTOFULL = 5;

    const DUPLEX_TEXTS = [
        self::DUPLEX_HALF => 'forced-half',
        self::DUPLEX_FULL => 'forced-full',
        self::DUPLEX_AUTONEG => 'autoneg',
        self::DUPLEX_AUTOHALF => 'auto-half',
        self::DUPLEX_AUTOFULL => 'auto-full',
    ];

    const SPEED_10M = 1;
    const SPEED_100M = 2;
    const SPEED_1000M = 3;
    const SPEED_AUTO = 4;
    const SPEED_AUTO10M = 5;
    const SPEED_AUTO100M = 6;
    const SPEED_AUTO1000M = 7;

    const SPEED_TEXTS = [
        self::SPEED_10M => '10M',
        self::SPEED_100M => '100M',
        self::SPEED_1000M => '1000M',
        self::SPEED_AUTO => 'auto',
        self::SPEED_AUTO10M => 'auto 10M',
        self::SPEED_AUTO100M => 'auto 100M',
        self::SPEED_AUTO1000M => 'auto 1000M',
    ];
}
