<?php
/** @noinspection PhpUnused */

namespace XponLmsPlugin\Model;

class OntWanModel
{
    const KEY_ID = 'id';
    const KEY_DESCRIPTION = 'description';

    const KEY_SERVICETYPE = 'servicetype';
    const KEY_LAYER = 'layer';
    const KEY_STATE = 'state';
    const KEY_IPTYPE = 'iptype';

    const KEY_VLANID = 'vlanid';
    const KEY_ENABLED = 'enabled';

    const KEY_IPV4ENABLED = 'ipv4enabled';
    const KEY_IPV6ENABLED = 'ipv6enabled';
    const KEY_IPV6PREFIX = 'ipv6prefix';
    const KEY_IPV6PREFIXLEN = 'ipv6prefixlen';
    const KEY_IPV6PREFIXMODE = 'ipv6prefixmode';
    const KEY_IPV6ADDR = 'ipv6addr';
    const KEY_IPV6ADDRSTATUS = 'ipv6addrstatus';
    const KEY_IPV6ADDRMODE = 'ipv6addrmode';
    const KEY_MVLANID = 'mvlanid';
    const KEY_NAT = 'nat';
    const KEY_VLANP = 'vlanp';

    const KEY_OLT_ID = 'oltid';

    const KEY__INDEX = '_index';
    const KEY_ONT_ID = 'ontid';
    const KEY_OLT_IFINDEX = 'ifindex';

    const KEY_OLT_NAME = 'oltname';
    const KEY_OLT_DESCRIPTION = 'oltdescription';
    const KEY_PORT_DESCRIPTION = 'portdescription';
    const KEY_FRAME = 'frame';
    const KEY_SLOT = 'slot';
    const KEY_PORT = 'port';
    const KEY_ONT_SN = 'ontsn';
    const KEY_ONT_DESCRIPTION = 'ontdescription';
    const KEY_IPADDR = 'ipaddr';
    const KEY_MASK = 'mask';
    const KEY_GATEWAY = 'gateway';
    const KEY_VALUE_1 = 'value_1';
    const KEY_MAC = 'mac';
    const KEY_VALUE_21 = 'value_21';
    const KEY_VALUE_22 = 'value_22';
    const KEY_IPV6PREFIXTIME = 'ipv6prefixtime';
    const KEY_IPV6ADDRTIME = 'ipv6addrtime';
    const KEY_UNKNOWN7_ = 'unknown7_';
    const KEY_UNKNOWN8_ = 'unknown8_';
    const KEY_UNKNOWN9_ = 'unknown9_';
    const KEY__TIMESTAMP = '_timestamp';

    const KEYS = [
        self::KEY_DESCRIPTION,
        self::KEY_ID,

        self::KEY_SERVICETYPE,
        self::KEY_LAYER,
        self::KEY_STATE,
        self::KEY_IPTYPE,

        self::KEY_VLANID,
        self::KEY_ENABLED,

        self::KEY_IPV4ENABLED,
        self::KEY_IPV6ENABLED,
        self::KEY_IPV6PREFIX,
        self::KEY_IPV6PREFIXLEN,
        self::KEY_IPV6PREFIXMODE,
        self::KEY_IPV6ADDR,
        self::KEY_IPV6ADDRSTATUS,
        self::KEY_IPV6ADDRMODE,
        self::KEY_MVLANID,
        self::KEY_NAT,
        self::KEY_VLANP,

        self::KEY_OLT_ID,

        self::KEY__INDEX,
        self::KEY_OLT_NAME,
        self::KEY_OLT_DESCRIPTION,
        self::KEY_OLT_IFINDEX,
        self::KEY_FRAME,
        self::KEY_SLOT,
        self::KEY_PORT,
        self::KEY_PORT_DESCRIPTION,

        self::KEY_ONT_ID,
        self::KEY_ONT_SN,
        self::KEY_ONT_DESCRIPTION,

        self::KEY_IPADDR,
        self::KEY_MASK,
        self::KEY_GATEWAY,
        self::KEY_VALUE_1,
        self::KEY_MAC,
        self::KEY_VALUE_21,
        self::KEY_VALUE_22,
        self::KEY_IPV6PREFIXTIME,
        self::KEY_IPV6ADDRTIME,
        self::KEY_UNKNOWN7_,
        self::KEY_UNKNOWN8_,
        self::KEY_UNKNOWN9_,
        self::KEY__TIMESTAMP,
    ];

    const SERVICETYPE_INTERNET = 0;
    const SERVICETYPE_TR069 = 1;
    const SERVICETYPE_VOIP = 2;
    const SERVICETYPE_TR069_INTERNET = 3;
    const SERVICETYPE_TR069_VOIP_INTERNET = 5;
    const SERVICETYPE_VOIP_INTERNET = 6;
    const SERVICETYPE_IPTV = 7;
    const SERVICETYPE_OTHER = 8;
    const SERVICETYPE_IPTV_INTERNET = 13;

    const SERVICETYPE_TEXTS = [
        self::SERVICETYPE_INTERNET => 'INTERNET',
        self::SERVICETYPE_TR069 => 'TR069',
        self::SERVICETYPE_VOIP => 'VOIP',
        self::SERVICETYPE_TR069_INTERNET => 'TR069_INTERNET',
        self::SERVICETYPE_TR069_VOIP_INTERNET => 'TR069_VOIP_INTERNET',
        self::SERVICETYPE_VOIP_INTERNET => 'VOIP_INTERNET',
        self::SERVICETYPE_IPTV => 'IPTV',
        self::SERVICETYPE_OTHER => 'OTHER',
        self::SERVICETYPE_IPTV_INTERNET => 'IPTV_INTERNET',
    ];

    const LAYER_ROUTE = 1;
    const LAYER_BRIDGE = 2;

    const LAYER_TEXTS = [
        self::LAYER_ROUTE => 'route',
        self::LAYER_BRIDGE => 'bridge',
    ];

    const STATE_INIT = 0;
    const STATE_CONNECTING = 1;
    const STATE_CONNECTED = 2;
    const STATE_DISCONNECTED = 5;

    const STATE_TEXTS = [
        self::STATE_INIT => 'init',
        self::STATE_CONNECTING => 'connecting',
        self::STATE_CONNECTED => 'connected',
        self::STATE_DISCONNECTED => 'disconnected'
    ];

    const IPTYPE_NOIP = 0;
    const IPTYPE_DHCP  = 1;
    const IPTYPE_STATIC = 2;
    const IPTYPE_PPPOE  = 3;

    const IPTYPE_TEXTS = [
        self::IPTYPE_NOIP => 'no ip',
        self::IPTYPE_DHCP => 'dhcp',
        self::IPTYPE_STATIC => 'static',
        self::IPTYPE_PPPOE => 'pppoe',
    ];

}
