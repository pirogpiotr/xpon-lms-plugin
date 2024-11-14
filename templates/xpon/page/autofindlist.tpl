{extends file="xpon/page/xponpagetemplate.tpl"}

{block name="xpon-module-content"}
    {$columnsTotal = 10}

    <h1>Lista ONT Autofind</h1>
    <table id="xpon-autofind" class="lmsbox lms-ui-background-cycle">
        <thead>
            <tr>
                <td class="lp">
                    Lp
                </td>
                <td class="olt">
                    Olt
                </td>
                <td class="port">
                    Port
                </td>
                <td class="sn">
                    SN
                </td>
                <td class="model">
                    Model
                </td>
                <td class="softwareversion">
                    Wersja Software
                </td>
                <td class="hardwareversion">
                    Wersja Hardware
                </td>
                <td class="vendorid">
                    Vendor Id
                </td>
                <td class="findtime">
                    Czas znalezienia
                </td>
                <td class="control text-right nobr">
                    Razem: {${XponLmsPlugin\Controller\Page\OntAutofindPageController::KEY_AUTOFIND}|count}
                </td>
            </tr>
        </thead>

        <tbody>
            {foreach ${XponLmsPlugin\Controller\Page\OntAutofindPageController::KEY_AUTOFIND} as $autofind}
                <tr class="highlight" {foreach $autofind as $key => $val} data-{$key}="{$val}" {/foreach}>
                    <td class="lp">
                        {$autofind@iteration}
                    </td>
                    <td class="olt">
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_OLT_ID]}
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_OLT_NAME]}
                    </td>
                    <td class="port">
                        <span>{$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_FRAME]}/{$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_SLOT]}/{$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_PORT]}.{$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_ID]}</span>
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_PORT_DESCRIPTION]|default:''}
                    </td>
                    <td>
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_SN]}
                    </td>
                    <td>
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_EQUIPID]}
                    </td>
                    <td>
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_VERSION]}
                    </td>
                    <td>
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_HWVERSION]}
                    </td>
                    <td>
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_VENDORID]}
                    </td>
                    <td>
                        {$autofind[XponLmsPlugin\Model\OntAutofindModel::KEY_FINDTIME]}
                    </td>

                    <td class="lms-ui-buttons text-right">
                        <button class="lms-ui-button xpon-button-autofind-add">
                            <i class="lms-ui-icon-add"></i><span class="lms-ui-label">Dodaj</span>
                        </button>
                    </td>

                </tr>
            {foreachelse}
                <tr>
                    <td colspan="{$columnsTotal}" class="text-center">
                        <div>
                            <h3>Nie znaleziono ONT</h3>
                        </div>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>

    {if $errors = ${XponLmsPlugin\Controller\Page\OntAutofindPageController::KEY_ERRORS}}
        <div id="xpon-errors">
            <div id="lms-ui-dberrors">
                <div>
                    <img src="img/warning.png">
                </div>
                <div>
                    <h2 class="lms-ui-alert">Wystąpiły błedy</h2>
                    {foreach $errors as $error}
                        {$txt = []}
                        {$txt[] = "OLT: {$error[XponLmsPlugin\Lib\XponApiHelper::KEY_ERROR_OLTID]}"}
                        {if $error[XponLmsPlugin\Lib\XponApiHelper::KEY_ERROR_CLASS]|default:''}
                            {$txt[] = "klasa: {$error[XponLmsPlugin\Lib\XponApiHelper::KEY_ERROR_CLASS]}"}
                        {/if}
                        {if $error[XponLmsPlugin\Lib\XponApiHelper::KEY_ERROR_MESSAGE]|default:''}
                            {$txt[] = "komunikat: {$error[XponLmsPlugin\Lib\XponApiHelper::KEY_ERROR_MESSAGE]}"}
                        {/if}
                        <p>{', '|implode:$txt}</p>
                    {/foreach}
                </div>
            </div>
        </div>
    {/if}

    <!--suppress JSUnfilteredForInLoop -->
    <script type="text/javascript" language="javascript">
        $(function () {
            $('#xpon-autofind .xpon-button-autofind-add').on('click', function () {
                let data = $(this).closest('tr').data();
                XponLmsPlugin.redirectWithPostForm(
                    "{XponLmsPlugin\Lib\UrlGenerator::getUrlForPage(XponLmsPlugin\Controller\Page\OntAddPageController::class)}",
                    data,
                    '{XponLmsPlugin\Controller\Page\OntAddPageController::KEY_ONT_FORMDATA}'
                );
            });
        });
    </script>
{/block}
