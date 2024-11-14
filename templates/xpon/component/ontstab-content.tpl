{if $onts}

    <div class="lms-ui-tab-table-row header">
        <div class="lms-ui-tab-table-wrapper col-prefix-only">
            <div class="lms-ui-tab-table-column oltandport">
                Olt<br>Port.OntId
            </div>
            <div class="lms-ui-tab-table-column descriptionandsn">
                Opis
                <br>
                Serial
            </div>
            <div class="lms-ui-tab-table-column configmode">
                Tryb konfiguracji
            </div>
            <div class="lms-ui-tab-table-column lineandserviceprofile">
                Line profile
                <br>
                Service profile
            </div>
            <div class="lms-ui-tab-table-column modelandversion">
                Model
                <br>
                Wersja
            </div>
            <div class="lms-ui-tab-table-column activeandstatus">
                Włączony
                <br>
                Status Config / Match
            </div>
            <div class="lms-ui-tab-table-column stateandreason">
                Stan
                <br>
                Powód wyłączenia
            </div>
            <div class="lms-ui-tab-table-column opticanddistance">
                Ont / Olt Rx
                <br>
                Odległość
            </div>
        </div>

        <div class="lms-ui-tab-table-column control">
            &nbsp;
        </div>

    </div>

    {foreach $onts as $ont}
        {$ontInfoUrl = XponLmsPlugin\Lib\UrlGenerator::getUrlForOnt($ont)}
        <div class="lms-ui-tab-table-row" data-target-url="{$ontInfoUrl}">
            <div class="lms-ui-tab-table-wrapper col-prefix-only">
                <div class="lms-ui-tab-table-column oltandport">
                    ({$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_ID]}) {$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_NAME]}
                    <br>
                    {$ont[XponLmsPlugin\Model\OntModel::KEY_FRAME]}/{$ont[XponLmsPlugin\Model\OntModel::KEY_SLOT]}/{$ont[XponLmsPlugin\Model\OntModel::KEY_PORT]}.{$ont[XponLmsPlugin\Model\OntModel::KEY_ID]}
                    {$ont[XponLmsPlugin\Model\OntModel::KEY_PORT_DESCRIPTION]|default:''}
                </div>
                <div class="lms-ui-tab-table-column descriptionandsn">
                    <a href="{$ontInfoUrl}">
                        <span class="xpon-pre">{$ont[XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION]}</span>
                        <br>
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_SN]}
                    </a>
                </div>

                <div class="lms-ui-tab-table-column configmode">
                    {$_configmode = $ont[XponLmsPlugin\Model\OntModel::KEY_CONFIGMODE]}
                    {if $_configmode == XponLmsPlugin\Model\OntModel::CONFIGMODE_MANUAL}
                        Ręczny
                    {elseif $_configmode == XponLmsPlugin\Model\OntModel::CONFIGMODE_AUTO}
                        Automatyczny
                    {elseif $_configmode == XponLmsPlugin\Model\OntModel::CONFIGMODE_PROFILE}
                        Profil
                        <br>
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_SETUPPROFILE]}
                    {else}
                        <small>nieznany ONT</small>
                    {/if}
                </div>
                <div class="lms-ui-tab-table-column lineandserviceprofile">
                    {$ont[XponLmsPlugin\Model\OntModel::KEY_LINEPROFILE]}
                    <br>
                    {$ont[XponLmsPlugin\Model\OntModel::KEY_SERVICEPROFILE]}
                </div>
                <div class="lms-ui-tab-table-column modelandversion">
                    {$ont[XponLmsPlugin\Model\OntModel::KEY_EQUIPID]|default:'-'}
                    <br>
                    {$ont[XponLmsPlugin\Model\OntModel::KEY_VERSION]|default:'-'}
                </div>

                <div class="lms-ui-tab-table-column activeandstatus" >
                    {if $ont[XponLmsPlugin\Model\OntModel::KEY_ACTIVE]}
                        <span class="xpon-status-online">Włączony</span>
                    {else}
                        <span class="xpon-status-offline">Wyłączony</span>
                    {/if}
                    <br>
                    {$val = $ont[XponLmsPlugin\Model\OntModel::KEY_CONFIGSTATUS]}
                    {if $val == 1}
                        <span style="color: orange;">Init</span>
                    {elseif $val == 2}
                        <span style="color: green;">Ok</span>
                    {elseif $val == 3}
                        <span style="color: red;">Failed</span>
                    {elseif $val == 4}
                        <span style="color: red;">No resume</span>
                    {elseif $val == 5}
                        <span style="color: orange;">Config</span>
                    {else}
                        ? ({$val})
                    {/if}
                    /
                    {$val = $ont[XponLmsPlugin\Model\OntModel::KEY_MATCHSTATUS]}
                    {if $val == 1}
                        <span style="color: orange;">Init</span>
                    {elseif $val == 2}
                        <span style="color: green;">Ok</span>
                    {elseif $val == 3}
                        <span style="color: red;">Mismatch</span>
                    {else}
                        ? ({$val})
                    {/if}
                </div>

                {capture name=title}
                    Ostatnio wyłączony: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNTIME]|default:'-'}<br>
                    Powód: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE_TEXT]|default:'-'} ({$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE]|default:'-'})<br>
                    Ostatnio włączony: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTUPTIME]|default:'-'}<br>
                    Ostatni dying-gasp: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDYINGGASPTIME]|default:'-'}<br>
                {/capture}
                <div class="lms-ui-tab-table-column stateandreason" title="{$smarty.capture.title}">
                    {if $ont[XponLmsPlugin\Model\OntModel::KEY_UPTIME] > 0}
                        <span class="xpon-status-online">Online</span> {$ont[XponLmsPlugin\Model\OntModel::KEY_UPTIME]|intervalDiffShort}
                    {else}
                        <span class="xpon-status-offline">Offline</span> {$ont[XponLmsPlugin\Model\OntModel::KEY_UPTIME]|intervalDiffShort}
                    {/if}
                    <br>
                    <span class="xpon-cliptext">
                                    {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE_TEXT]|default:'-'}
                        {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE])}<small>({$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE]|default:'-'})</small>{/if}
                                </span>
                </div>

                <div class="lms-ui-tab-table-column opticanddistance">
                    {$ont[XponLmsPlugin\Model\OntModel::KEY_ONT_RX]|default:"-"} / {$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_RX]|default:"-"}
                    <br>
                    {($ont[XponLmsPlugin\Model\OntModel::KEY_DISTANCE]) ? "{$ont[XponLmsPlugin\Model\OntModel::KEY_DISTANCE]} m" : "-"}
                </div>

            </div>

            <div class="lms-ui-tab-table-column control">
            </div>
        </div>
    {/foreach}

{else}
    <div class="lms-ui-tab-empty-table">
        {if isset($xponerror)}
            <span style="color: red; font-weight: bold">
                Błąd:<br>
                {$xponerror}
            </span>
        {elseif $ontsWasLoaded}
            Ten klient nie posiada powiązanych ONT.
        {else}
            Nie załadowano danych.
        {/if}
    </div>
{/if}
