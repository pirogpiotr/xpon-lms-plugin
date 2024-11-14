{extends file="xpon/page/xponpagetemplate.tpl"}

{block name="xpon-module-content"}
    <h1>Informacje o ONT</h1>

    {include file="xpon/page/ontinfo/ontinfo-base.tpl" ont=${XponLmsPlugin\Controller\Page\OntInfoPageController::KEY_ONT}}

    {include file="xpon/page/ontinfo/ontinfo-wans.tpl" wans=${XponLmsPlugin\Controller\Page\OntInfoPageController::KEY_ONT_WANS}}

    {include file="xpon/page/ontinfo/ontinfo-serviceports.tpl" serviceports=${XponLmsPlugin\Controller\Page\OntInfoPageController::KEY_ONT_SERVICE_PORTS}}

    {include file="xpon/page/ontinfo/ontinfo-ports-eth.tpl" eths=${XponLmsPlugin\Controller\Page\OntInfoPageController::KEY_ONT_PORTS_ETH}}

    {$ont = ${XponLmsPlugin\Controller\Page\OntInfoPageController::KEY_ONT}}

    <script id="xpon-js-ontinfo" type="text/javascript" language="javascript">
        $(function () {
            let ont = {$ont|json_encode};
        });
    </script>

{/block}
