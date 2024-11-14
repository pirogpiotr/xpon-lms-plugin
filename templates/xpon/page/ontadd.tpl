{extends file="xpon/page/xponpagetemplate.tpl"}

{block name="xpon-module-content"}
    {$ont=${XponLmsPlugin\Controller\Page\OntInfoPageController::KEY_ONT}|default:[]}

    <h1>Dodawanie ONT</h1>

    {capture buttons}
        <button id="xpon-button-ont-add" type="button" class="lms-ui-button">
            <i class="lms-ui-icon-add"></i><span class="lms-ui-label">Dodaj ONT</span>
        </button>


        <a href="{XponLmsPlugin\Lib\UrlGenerator::getUrlForPage(XponLmsPlugin\Controller\Page\OntAutofindPageController::class)}"
           class="lms-ui-button lms-ui-link-button">
            <i class="lms-ui-icon-cancel"></i><span class="lms-ui-label">Anuluj</span>
        </a>
    {/capture}

    {include
        file="xpon/component/onteditform.tpl"
        ont=$ont
        buttons=$smarty.capture.buttons
        olts=${XponLmsPlugin\Controller\Page\OltListPageController::KEY_OLTLIST}|default:[]
        setupprofiles=${XponLmsPlugin\Controller\Page\OntEditPageController::KEY_SETUPPROFILES}|default:[]
        attributes=${XponLmsPlugin\Controller\Page\OntEditPageController::KEY_ONTATTRIBUTES}|default:[]
    }

    <script type="text/javascript" language="javascript">
        $(function () {
            $('#xpon-button-ont-add').on('click', function () {
                xajax_ontAdd(xajax.getFormValues('xpon-onteditform'));
            });
        });
    </script>
{/block}
