{extends file="xpon/page/xponpagetemplate.tpl"}

{block name="xpon-module-content"}
    {$ont = ${XponLmsPlugin\Controller\Page\OntInfoPageController::KEY_ONT}|default:[]}

    <h1>Edycja ONT</h1>

    {capture buttons}
        <button id="xpon-button-ont-update" type="button" class="lms-ui-button">
            <i class="lms-ui-icon-configuration"></i><span class="lms-ui-label">Zapisz&Konfiguruj</span>
        </button>

        <button id="xpon-button-ont-update-save-only" type="button" class="lms-ui-button">
            <i class="lms-ui-icon-save"></i><span class="lms-ui-label">Tylko Zapisz</span>
        </button>

        <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForOnt($ont, XponLmsPlugin\Controller\Page\OntInfoPageController::class)}"
           class="lms-ui-button lms-ui-link-button">
            <i class="lms-ui-icon-cancel"></i><span class="lms-ui-label">Anuluj</span>
        </a>
    {/capture}

    {include
        file="xpon/component/onteditform.tpl"
        ont=$ont
        buttons=$smarty.capture.buttons
        setupprofiles=${XponLmsPlugin\Controller\Page\OntEditPageController::KEY_SETUPPROFILES}|default:[]
        attributes=${XponLmsPlugin\Controller\Page\OntEditPageController::KEY_ONTATTRIBUTES}|default:[]
    }

    <script type="text/javascript" language="javascript">
        $(function () {
            $('#xpon-button-ont-update').on('click', function () {
                xajax_ontUpdate(xajax.getFormValues('xpon-onteditform'));
            });

            $('#xpon-button-ont-update-save-only').on('click', function () {
                xajax_ontUpdateSaveOnly(xajax.getFormValues('xpon-onteditform'));
            });
        });
    </script>
{/block}
