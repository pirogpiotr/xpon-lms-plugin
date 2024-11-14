{extends file="xpon/page/xponpagetemplate.tpl"}

{block name="xpon-module-content"}

    {$page = ${XponLmsPlugin\Lib\Page::KEY_PAGE}}

    <h1>
        Lista ONT
    </h1>

    <div id="xpon-ontsearch">
        <form method="get">
            <input name="{XponLmsPlugin\Lib\UrlGenerator::KEY_MODULE}" type="hidden" value="{XponLmsPlugin\Lib\UrlGenerator::getModuleForPage(XponLmsPlugin\Controller\Page\OntListPageController::class)}">
            <label>
                <i class="lms-ui-quick-search-icon lms-ui-icon-search"></i>
                <input id="xpon-ontsearch-input" class="lms-ui-quick-search-input" type="text" autocomplete="off"
                       name="search" value="{${XponLmsPlugin\Controller\Page\OntListPageController::KEY_ONTSEARCH}|default:''}" size="30" placeholder="Wyszukiwanie ONT">
                <i class="lms-ui-icon-hide"></i>
            </label>
        </form>
    </div>

    <script id="xpon-js-ontsearch" type="text/javascript" language="javascript">
        $(function () {
            let input = $('#xpon-ontsearch-input');
            input.trigger('focus');
            input[0].setSelectionRange(input.val().length, input.val().length);
            input.siblings('i.lms-ui-icon-hide').on('click', function() {
                if (input.attr('value')) {
                    let url = '{$page->getPager()->getUrlWithoutParams([XponLmsPlugin\Lib\XponApiHelper::KEY_SEARCH])}';
                    window.location.assign(url);
                } else {
                    input.val('');
                }
            });

            let url = '{XponLmsPlugin\Lib\UrlGenerator::getUrlForPage(XponLmsPlugin\Controller\OntSearchServiceController::class)}&{XponLmsPlugin\Lib\XponApiHelper::KEY_SEARCH}=';

            new AutoSuggest(
                $(input).closest('form').get(0),
                input.get(0),
                url,
                1
            );
        });
    </script>


    {$columnsTotal = 10}

    <table id="xpon-ontlist" class="lmsbox lms-ui-background-cycle">
        <thead>
            <tr>
                <td class="oltandport">
                    {printListHeader name=[XponLmsPlugin\Model\OntModel::KEY_OLT_ID, XponLmsPlugin\Model\OntModel::KEY_IFINDEX, XponLmsPlugin\Model\OntModel::KEY_ID] display="Olt<br>Port.OntId"}
                </td>
                <td class="descriptionandsn">
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION display="Opis"}
                    <br>
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_SN display="Serial"}
                </td>

                <td class="customerandnode">
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID display="Klient"}
                    <br>
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_NODE_ID display="Komputer"}
                </td>
                <td class="configmode">
                    {printListHeader name=[XponLmsPlugin\Model\OntModel::KEY_CONFIGMODE, XponLmsPlugin\Model\OntModel::KEY_SETUPPROFILE] display="Typ konfiguracji"}
                </td>
                <td class="lineandserviceprofile">
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_LINEPROFILE display="Line profile"}
                    <br>
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_SERVICEPROFILE display="Service profile"}
                </td>
                <td class="modelandversion">
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_EQUIPID display="Model"}
                    <br>
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_VERSION display="Wersja"}
                </td>
                <td class="activeandstatus">
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_ACTIVE display="Stan"}
                    <br>
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_CONFIGSTATUS display="Config"}
                    /
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_MATCHSTATUS display="Match"}
                </td>
                <td class="stateandreason">
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_UPTIME display="Uptime"}
                    <br>
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE display="Powód wyłączenia"}
                </td>
                <td class="opticanddistance">
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_ONT_RX display="Ont Rx"}
                     / {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_OLT_RX display="Olt Rx"}
                    <br>
                    {printListHeader name=XponLmsPlugin\Model\OntModel::KEY_DISTANCE display="Odległość"}
                </td>

                <td class="control text-right nobr">
                    Razem: {$page->getPager()->getTotal()}
                </td>
            </tr>
            <tr>
                {if $page->getPager()->getTotal()}
                    <td colspan="{$columnsTotal}">
                        <span class="bold">FIXME Filtr:</span>
                    </td>
                {/if}
            </tr>
            {if $page->getPager()->getTotal()}
                <tr>
                    <td class="lms-ui-pagination" colspan="{$columnsTotal}">
                        {include file="xpon/component/pagination.tpl" pager=$page->getPager()}
                    </td>
                </tr>
            {/if}
        </thead>
        <tfoot>
            {if $page->getPager()->getTotal()}
                <tr>
                    <td class="lms-ui-pagination" colspan="{$columnsTotal}">
                        {include file="xpon/component/pagination.tpl" pager=$page->getPager()}
                    </td>
                </tr>
            {/if}
        </tfoot>
        <tbody>
            {foreach ${XponLmsPlugin\Controller\Page\OntListPageController::KEY_ONTLIST} as $ont}
                {$ontInfoUrl = XponLmsPlugin\Lib\UrlGenerator::getUrlForOnt($ont)}
                <tr class="highlight" data-target-url="{$ontInfoUrl}">
                    <td class="oltandport">
                        ({$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_ID]}) <span class="xpon-value">{$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_NAME]}</span>
                        <br>
                        <span class="xpon-value">{$ont[XponLmsPlugin\Model\OntModel::KEY_FRAME]}/{$ont[XponLmsPlugin\Model\OntModel::KEY_SLOT]}/{$ont[XponLmsPlugin\Model\OntModel::KEY_PORT]}.{$ont[XponLmsPlugin\Model\OntModel::KEY_ID]}</span>
                        <span class="xpon-value">{$ont[XponLmsPlugin\Model\OntModel::KEY_PORT_DESCRIPTION]|default:''}</span>
                    </td>
                    <td class="descriptionandsn">
                        <a href="{$ontInfoUrl}">
                            <span class="xpon-pre">{$ont[XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION]}</span>
                            <br>
                            {$ont[XponLmsPlugin\Model\OntModel::KEY_SN]}
                        </a>
                    </td>

                    <td class="customerandnode">
                        {if $ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID]}
                            <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForCustomerInfo($ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID])}">
                                ({$ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID]}) {$ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_NAME]}
                            </a>
                            <br>
                            {if $ont[XponLmsPlugin\Model\OntModel::KEY_NODE_ID]}
                                <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForNodeInfo($ont[XponLmsPlugin\Model\OntModel::KEY_NODE_ID])}">
                                    ({$ont[XponLmsPlugin\Model\OntModel::KEY_NODE_ID]}) {$ont[XponLmsPlugin\Model\OntModel::KEY_NODE_NAME]}
                                </a>
                            {else}
                                -
                            {/if}
                        {else}
                            -<br>
                            -
                        {/if}
                    </td>
                    <td class="configmode">
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
                    </td>
                    <td class="lineandserviceprofile">
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_LINEPROFILE]}
                        <br>
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_SERVICEPROFILE]}
                    </td>
                    <td class="modelandversion">
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_EQUIPID]|default:'-'}
                        <br>
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_VERSION]|default:'-'}
                    </td>

                    <td class="activeandstatus">
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
                    </td>

                    {capture name=title}
                        Ostatnio wyłączony: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNTIME]|default:'-'}<br>
                        Powód: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE_TEXT]|default:'-'} ({$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDOWNCAUSE]|default:'-'})<br>
                        Ostatnio włączony: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTUPTIME]|default:'-'}<br>
                        Ostatni dying-gasp: {$ont[XponLmsPlugin\Model\OntModel::KEY_LASTDYINGGASPTIME]|default:'-'}<br>
                    {/capture}
                    <td class="stateandreason" title="{$smarty.capture.title}">
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
                    </td>

                    <td class="opticanddistance">
                        {$ont.ontrx|default:"-"} / {$ont.oltrx|default:"-"}
                        <br>
                        {($ont[XponLmsPlugin\Model\OntModel::KEY_DISTANCE]) ? "{$ont[XponLmsPlugin\Model\OntModel::KEY_DISTANCE]} m" : "-"}
                    </td>

                    <td class="control text-right">
                        <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForOnt($ont, XponLmsPlugin\Controller\Page\OntEditPageController::class)}"
                           class="lms-ui-button lms-ui-link-button"
                           title="Edytuj ONT">
                            <i class="lms-ui-icon-edit"></i>
                        </a>
                    </td>
                </tr>

            {foreachelse}
                <tr>
                    <td colspan="{$columnsTotal}" class="empty-table">
                        <p>Brak ONT</p>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>

    <script id="xpon-js-ontlist" type="text/javascript" language="javascript">
        $(function () {

        });
    </script>

{/block}
