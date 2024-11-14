<?php

namespace XponLmsPlugin\Model;

class OntModel
{
    const KEY_SN = 'sn';
    const KEY_ID = 'id';
    const KEY_IFINDEX = 'ifindex';
    const KEY_FRAME = 'frame';
    const KEY_SLOT = 'slot';
    const KEY_PORT = 'port';
    const KEY_DESCRIPTION = 'description';
    const KEY_LINEPROFILE = 'lineprofile';
    const KEY_SERVICEPROFILE = 'serviceprofile';
    const KEY_ACTIVE = 'active';
    const KEY_EQUIPID = 'equipid';
    const KEY_VERSION = 'version';
    const KEY_STANDBYVERSION = 'standbyversion';
    const KEY_PRODUCTID = 'productid';
    const KEY_VENDORID = 'vendorid';
    const KEY_HWVERSION = 'hwversion';
    const KEY_RUNSTATUS = 'runstatus';
    const KEY_CONFIGSTATUS = 'configstatus';
    const KEY_MATCHSTATUS = 'matchstatus';

    const KEY_LASTUPTIME = 'lastuptime';
    const KEY_LASTDOWNTIME = 'lastdowntime';
    const KEY_LASTDYINGGASPTIME = 'lastdyinggasptime';
    const KEY_LASTDOWNCAUSE = 'lastdowncause';
    const KEY_LASTDOWNCAUSE_TEXT = 'lastdowncause_text';
    const KEY_UPTIME = 'uptime';

    const KEY_DISTANCE = 'distance';
    const KEY_ONT_RX = 'ontrx';
    const KEY_OLT_RX = 'oltrx';

    const KEY_CONFIGMODE = 'configmode';
    const CONFIGMODE_MANUAL = 1;
    const CONFIGMODE_AUTO = 2;
    const CONFIGMODE_PROFILE = 3;

    const KEY_SERVICES = 'services';
    const KEY_SETUPPROFILE = 'setupprofile';
    const KEY_ATTRIBUTES = 'attributes';
    const KEY_CUSTOMER_ID = 'customerid';
    const KEY_CUSTOMER_NAME = 'customername';
    const KEY_CUSTOMER_ADDRESS = 'customeraddress';
    const KEY_NODE_ID = 'nodeid';
    const KEY_NODE_NAME = 'nodename';
    const KEY_IPTV_PORTS = 'iptvports';
    const KEY_VOIP_NODE_ID = 'voipnodeid';
    const KEY_VOIP_ACCOUNT_1 = 'voipaccount1';
    const KEY_VOIP_ACCOUNT_2 = 'voipaccount2';


    const KEY_OLT_ID = 'oltid';
    const KEY_OLT_NAME = 'oltname';
    const KEY_OLT_DESCRIPTION = 'oltdescription';

    const KEY_PORT_DESCRIPTION = 'portdescription';

    const SERVICE_INTERNET = 'internet';
    const SERVICE_VOIP = 'voip';
    const SERVICE_IPTV = 'iptv';

    const SERVICES = [
        self::SERVICE_INTERNET,
        self::SERVICE_IPTV,
        self::SERVICE_VOIP,
    ];

}
