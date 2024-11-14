{$fsp = XponLmsPlugin\Lib\Helper::decodeHuaweiIfIndex($ont[XponLmsPlugin\Model\OntModel::KEY_IFINDEX])}
{$servicesArr = explode(',', $ont[XponLmsPlugin\Model\OntModel::KEY_SERVICES])}

<table class="lmsbox">
    <thead>
        <tr>
            <td class="bold">
                <i class="lms-ui-icon-netdev"></i>
                ONT {$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_ID]}:{$fsp.0}/{$fsp.1}/{$fsp.2}.{$ont[XponLmsPlugin\Model\OntModel::KEY_ID]} {$ont[XponLmsPlugin\Model\OntModel::KEY_SN]} "{$ont[XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION]}"
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="xpon-ontinfo-panels" class="container lmsbox-panels">
                <div class="lmsbox-panel">
                    <table class="xpon-ontinfo-table">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="xpon-label">Numer seryjny</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_SN]}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Opis</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION]}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Olt</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_NAME]|default:''} ({$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_ID]})
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="xpon-label">Port</span>
                                </td>
                                <td>
                                    {$fsp.0}/{$fsp.1}/{$fsp.2} {$ont[XponLmsPlugin\Model\OntModel::KEY_PORT_DESCRIPTION]}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="xpon-label">Ont id</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_ID]}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="{$columnsTotal}">&nbsp;</td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Tryb konfiguracji</span>
                                </td>
                                <td>
                                    {$_configmode = $ont[XponLmsPlugin\Model\OntModel::KEY_CONFIGMODE]}
                                    {if $_configmode == XponLmsPlugin\Model\OntModel::CONFIGMODE_MANUAL}
                                        Ręczny
                                    {elseif $_configmode == XponLmsPlugin\Model\OntModel::CONFIGMODE_AUTO}
                                        Automatyczny
                                    {elseif $_configmode == XponLmsPlugin\Model\OntModel::CONFIGMODE_PROFILE}
                                        Profil
                                    {else}
                                        <small>nieznany ONT</small>
                                    {/if}
                                </td>
                            </tr>

                            {if $_configmode == XponLmsPlugin\Model\OntModel::CONFIGMODE_PROFILE}
                                <tr>
                                    <td>
                                        <span class="xpon-label">Profil</span>
                                    </td>
                                    <td>
                                        {$ont[XponLmsPlugin\Model\OntModel::KEY_SETUPPROFILE]}
                                    </td>
                                </tr>
                            {/if}

                            <tr>
                                <td>
                                    <span class="xpon-label">Usługi</span>
                                </td>
                                <td>
                                    {implode(', ', $servicesArr)|capitalize|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Klient</span>
                                </td>
                                <td>
                                    {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID])}
                                        <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForCustomerInfo($ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID])}">
                                            {$ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_NAME]|default:''} ({$ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID]|string_format:"%04d"})
                                        </a>
                                    {else}
                                        -
                                    {/if}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Komputer</span>
                                </td>
                                <td>
                                    {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_NODE_ID])}
                                        <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForNodeInfo($ont[XponLmsPlugin\Model\OntModel::KEY_NODE_ID])}">
                                            {$ont[XponLmsPlugin\Model\OntModel::KEY_NODE_NAME]|default:''} ({$ont[XponLmsPlugin\Model\OntModel::KEY_NODE_ID]|string_format:"%04d"})
                                        </a>
                                    {else}
                                        -
                                    {/if}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Konto voip 1</span>
                                </td>
                                <td>
                                    {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_VOIP_ACCOUNT_1])}
                                        {$ont[XponLmsPlugin\Model\OntModel::KEY_VOIP_ACCOUNT_1]|string_format:"%04d"}
                                    {else}
                                        -
                                    {/if}
                                </td>
                            </tr>

                            {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_VOIP_ACCOUNT_2])}
                                <tr>
                                    <td>
                                        <span class="xpon-label">Konto voip 2</span>
                                    </td>
                                    <td>
                                        {$ont[XponLmsPlugin\Model\OntModel::KEY_VOIP_ACCOUNT_2]|string_format:"%04d"}
                                    </td>
                                </tr>
                            {/if}

                            <tr>
                                <td>
                                    <span class="xpon-label">Porty IPTV</span>
                                </td>
                                <td>
                                        <span {if !in_array(XponLmsPlugin\Model\OntModel::SERVICE_IPTV, $servicesArr)}class="xpon-disabled"{/if}>
                                            {implode(', ', explode(',', $ont[XponLmsPlugin\Model\OntModel::KEY_IPTV_PORTS]))|default:'-'}
                                        </span>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="{$columnsTotal}">&nbsp;</td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Status</span>
                                </td>
                                <td>
                                    {if $ont[XponLmsPlugin\Model\OntModel::KEY_UPTIME] > 0}
                                        <span class="xpon-status-online">Online</span> {$ont[XponLmsPlugin\Model\OntModel::KEY_UPTIME]|intervalDiffShort}
                                    {else}
                                        <span class="xpon-status-offline">Offline</span> {$ont[XponLmsPlugin\Model\OntModel::KEY_UPTIME]|intervalDiffShort}
                                    {/if}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Ont / Olt Rx</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_ONT_RX]|default:'-'} / {$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_RX]|default:'-'} <small>dBm</small>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Odległość</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_DISTANCE]|default:'-'} <small>m</small>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label" title="Stan administracyjny">Stan adm.</span>
                                </td>
                                <td>
                                    {if $ont[XponLmsPlugin\Model\OntModel::KEY_ACTIVE]}
                                        <span class="xpon-status-online">Włączony</span>
                                    {else}
                                        <span class="xpon-status-offline">Wyłączony</span>
                                    {/if}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Stan konfiguracji</span>
                                </td>
                                <td>
                                    {$val = $ont[XponLmsPlugin\Model\OntModel::KEY_CONFIGSTATUS]}
                                    {if $val == 1}
                                        <span class="xpon-value-ok">Init</span>
                                    {elseif $val == 2}
                                        <span class="xpon-value-ok">Ok</span>
                                    {elseif $val == 3}
                                        <span class="xpon-value-error">Failed</span>
                                    {elseif $val == 4}
                                        <span class="xpon-value-error">No resume</span>
                                    {elseif $val == 5}
                                        <span class="xpon-value-warning">Config</span>
                                    {else}
                                        ? ({$val})
                                    {/if}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Stan dopasowania</span>
                                </td>
                                <td>
                                    {$val = $ont[XponLmsPlugin\Model\OntModel::KEY_MATCHSTATUS]}
                                    {if $val == 1}
                                        <span class="xpon-value-warning">Init</span>
                                    {elseif $val == 2}
                                        <span class="xpon-value-ok">Ok</span>
                                    {elseif $val == 3}
                                        <span class="xpon-value-error">Mismatch</span>
                                    {else}
                                        ? ({$val})
                                    {/if}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Line profile</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_LINEPROFILE]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Service profile</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_SERVICEPROFILE]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Ostatnio wyłączony</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNTIME]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Powód</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE_TEXT]|default:'-'}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="xpon-label">Ostatnio włączony</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTUPTIME]|default:'-'}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="xpon-label">Ostatni dying-gasp</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDYINGGASPTIME]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Wersja</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_VERSION]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Wersja standby</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_STANDBYVERSION]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Model</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_EQUIPID]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Product id</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_PRODUCTID]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Vendor id</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_VENDORID]|default:'-'}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span class="xpon-label">Wersja HW</span>
                                </td>
                                <td>
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_HWVERSION]|default:'-'}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div id="xpon-ont-stats" class="lmsbox-panel">
                    {$ontUrlPrefix = "{XponLmsPlugin\Lib\UrlGenerator::getUrlForPage(XponLmsPlugin\Controller\Page\ImageViewPageController::class)}&{XponLmsPlugin\Controller\Page\ImageViewPageController::KEY_URL}=onts/{XponLmsPlugin\Lib\UrlGenerator::getOntSelector($ont)}"}
                    <div id="stats-period-div">
                        {$arr = [
                        '1d' => 1,
                        '3d' => 3,
                        '7d' => 7,
                        '1m' => 30,
                        '3m' => 90,
                        '1y' => 365,
                        '5y' => 365 * 5
                        ]}
                        {$val = 7 * 60 * 60 * 24}
                        <label>
                            Okres statystyk
                            <select id="stats-period-select" autocomplete="off">
                                {foreach $arr as $desc => $value}
                                    {$_tmp = $value * 60 * 60 * 24}
                                    <option value="{$_tmp}" {if $val == $_tmp}selected{/if}>{$desc}</option>
                                {/foreach}
                            </select>
                        </label>
                    </div>
                    <div><img src="{$ontUrlPrefix}/graphs/optics" alt="- brak statystyk -"></div>
                    <div><img src="{$ontUrlPrefix}/graphs/traffic" alt=""></div>
                    <div><img src="{$ontUrlPrefix}/graphs/packets" alt=""></div>
                    <div><img src="{$ontUrlPrefix}/graphs/errors" alt=""></div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="lms-ui-box-buttons">
                <button id="xpon-button-delete" class="lms-ui-button">
                    <i class="lms-ui-icon-delete"></i><span class="lms-ui-label">Usuń</span>
                </button>

                <button id="xpon-button-setup" class="lms-ui-button">
                    <i class="lms-ui-icon-configuration"></i><span class="lms-ui-label">Konfiguruj</span>
                </button>

                <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForOnt($ont, XponLmsPlugin\Controller\Page\OntEditPageController::class)}"
                   class="lms-ui-button lms-ui-link-button">
                    <i class="lms-ui-icon-edit"></i><span class="lms-ui-label">Edytuj</span>
                </a>

                <span class="xpon-footer-separator"></span>

                <button id="xpon-button-restoredefaults" class="lms-ui-button">
                    <i class="lms-ui-icon-hide FIXME-icon"></i><span class="lms-ui-label">Reset ustawień</span>
                </button>

                <button id="xpon-button-reboot" class="lms-ui-button">
                    <i class="lms-ui-icon-hide FIXME-icon"></i><span class="lms-ui-label">Reboot</span>
                </button>

                <span class="xpon-footer-separator"></span>

                <button id="xpon-button-refresh" class="lms-ui-button">
                    <i class="lms-ui-icon-reload"></i><span class="lms-ui-label">Odśwież</span>
                </button>

            </td>
        </tr>
    </tbody>
</table>

<script id="xpon-js-ontinfo-base" type="text/javascript" language="javascript">
    $(function () {
        let ont = {$ont|json_encode};

        $('#stats-period-select').on('change', function (event) {
            let period = $(event.target).val();
            $('#xpon-ont-stats > div > img').each(function () {
                let img = $(this);
                if (img.attr('src').search('{XponLmsPlugin\Controller\Page\ImageViewPageController::KEY_INTERVAL}') === -1) {
                    img.attr('src', img.attr('src').concat('&{XponLmsPlugin\Controller\Page\ImageViewPageController::KEY_INTERVAL}=' + period));
                } else {
                    img.attr('src', img.attr('src').replace(/interval=\d*/, 'interval=' + period));
                }
                img.attr('src', img.attr('src').concat('&_=' + Date.now()));
            });
        });

        $('#xpon-button-delete').on('click', function () {
            XponLmsPlugin.ontDelete(ont);
        });

        $('#xpon-button-setup').on('click', function () {
            XponLmsPlugin.ontSetup(ont);
        });

        $('#xpon-button-refresh').on('click', function () {
            XponLmsPlugin.ontRefresh(ont);
        });

        $('#xpon-button-reboot').on('click', function () {
            XponLmsPlugin.ontReboot(ont);
        });

        $('#xpon-button-restoredefaults').on('click', function () {
            XponLmsPlugin.ontRestoreDefaults(ont);
        });

    });
</script>
