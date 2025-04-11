{$containerId = 'tab_container-xpon-ontlist'}
{tab_container id=$containerId label="Lista ONT"}

    {$ontsWasLoaded = isset($onts)}
    {$onts = ${XponLmsPlugin\Controller\Page\OntListPageController::KEY_ONTLIST}|default:[]}

    {if isset($xponRunXajax) && $xponRunXajax}
        {$xajax}
    {/if}

    {tab_header content_id="xpon-ontlist"}
        {tab_header_cell icon="lms-ui-icon-netdev"}
            <span id="xpon-ontlist-title">
                <strong>Lista ONT klienta ({if $ontsWasLoaded}{$onts|size}{else}?{/if})</strong>
            </span>
        {/tab_header_cell}
    {/tab_header}

    {tab_contents id="xpon-ontlist"}

        {tab_table}
            <div id="xpon-ontlist-content" class="lms-ui-tab-hourglass">
                {if $ontsWasLoaded}
                    {include file="xpon/component/ontstab-content.tpl" onts=$onts ontsWasLoaded=$ontsWasLoaded}
                {else}
                    <i></i>
                {/if}
            </div>
        {/tab_table}

    {/tab_contents}

    <script type="text/javascript">
        (function () {
            let config = {
                ontsWasLoaded: {$ontsWasLoaded|default:false|json_encode},
                containerId: '{$containerId}',
                customerinfo: {$customerinfo|default:null|json_encode},
                nodeinfo: {$nodeinfo|default:null|json_encode},
            };

            const controller = new XponLmsPlugin.OntsTabController(config);
            controller
                .run();
        }());
    </script>

{/tab_container}
