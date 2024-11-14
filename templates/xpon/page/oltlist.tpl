{extends file="xpon/page/xponpagetemplate.tpl"}

{block name="xpon-module-content"}

    {$olts = ${XponLmsPlugin\Controller\Page\OltListPageController::KEY_OLTLIST}}

    <h1>Lista OLT</h1>

    <table id="xpon-oltlist" class="lmsbox lms-ui-background-cycle">

        <thead>
            <tr>
                <td class="col-default-10">
                    Id
                </td>
                <td class="col-default-10">
                    Nazwa
                </td>
                <td class="col-default-10">
                    Opis
                </td>
                <td class="col-default-10">
                    IP
                </td>
                <td class="col-default-10">
                    Liczba ONT
                </td>
            </tr>
        </thead>
        <tbody>
            {foreach $olts as $olt}
                <tr>
                    <td>
                        {$olt[XponLmsPlugin\Model\OltModel::KEY_ID]}
                    </td>
                    <td>
                        {$olt[XponLmsPlugin\Model\OltModel::KEY_NAME]}
                    </td>
                    <td>
                        {$olt[XponLmsPlugin\Model\OltModel::KEY_DESCRIPTION]}
                    </td>
                    <td>
                        {$olt[XponLmsPlugin\Model\OltModel::KEY_IP]}
                    </td>
                    <td>
                        {$olt[XponLmsPlugin\Model\OltModel::KEY_ONTS_COUNT]}
                    </td>
                </tr>
            {/foreach}
        </tbody>

    </table>
{/block}
