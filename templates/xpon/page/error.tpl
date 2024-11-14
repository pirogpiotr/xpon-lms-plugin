{extends file="xpon/page/xponpagetemplate.tpl"}

{block "xpon-module-content"}
    <h2>{XponLms::PLUGIN_NAME}</h2>
    <h3>Wystąpił błąd:</h3>
    <div style="font-size: 200%">

        {$page = ${XponLmsPlugin\Lib\Page::KEY_PAGE}}

        Error Message: <b>{$page->getErrorMessage()}</b><br>

        {if $page->getException()}
            {$e = $page->getException()}
            Exception class: <b>{get_class($e)}</b><br>
            Exception message: <b>{$e->getMessage()}</b><br>
            Exception code: <b>{$e->getCode()}</b><br>
            Exception file: <b>{$e->getFile()}:{$e->getLine()}</b><br>
            {if XponLms::DEVEL}
                Exception trace: <pre>{$e->getTraceAsString()}</pre><br>
            {/if}
        {else}
            no exception<br>
        {/if}

    </div>
{/block}
