{block name="module_content" prepend}
    <script type="text/javascript" language="javascript">
        console.log('XponLmsPlugin: loading css...');
        $("head").append('<link rel="stylesheet" type="text/css" href="{XponLmsPlugin\Lib\UrlGenerator::getPublic('css/xponlmsplugin.css')}">');
    </script>

    <script type="text/javascript" language="javascript" src="{XponLmsPlugin\Lib\UrlGenerator::getPublic('js/xponlmsplugin.js')}"></script>
{/block}
