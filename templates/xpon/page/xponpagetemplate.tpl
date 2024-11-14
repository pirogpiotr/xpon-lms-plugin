{extends file="layout.html"}

{block name="extra-css-styles" append}
    <link rel="stylesheet" type="text/css" href="{XponLmsPlugin\Lib\UrlGenerator::getPublic('css/xponlmsplugin.css')}">
    <script type="text/javascript" language="javascript" src="{XponLmsPlugin\Lib\UrlGenerator::getPublic('js/xponlmsplugin.js')}"></script>
{/block}

{block name="module_content"}
    {$xajax|default:"<!-- xpon - no xajax -->"}
    {block name="xpon-module-content"}{/block}
{/block}

{block name="footer"}
{/block}
