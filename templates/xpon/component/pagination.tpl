{if !isset($pager) || !is_a($pager, XponLmsPlugin\Lib\Pager::class)}
    <h3 style="font-weight: bold; color: red;">Error: pagination - pager is not set or has invalid type!</h3>
{else}
    Strona:
    <a href="{$pager->getUrlForPageNumber($pager->getPage() - 1)}">
        <i class="lms-ui-icon-previous" style="vertical-align: bottom;"></i>
    </a>
    <select onChange="window.location.assign(this.value);" style="vertical-align: baseline;">
        {for $counter = 1; $counter <= $pager->getPages(); $counter++}
            <option value="{$pager->getUrlForPageNumber($counter)}" {if $counter == $pager->getPage()}selected{/if}>{$counter}</option>
        {/for}
    </select>
    / {$pager->getPages()}
    <a href="{$pager->getUrlForPageNumber($pager->getPage() + 1)}">
        <i class="lms-ui-icon-next" style="vertical-align: bottom;"></i>
    </a>
    &nbsp;
    (rekordy {($pager->getPage() - 1) * $pager->getLimit() + 1} - {$pager->getPage() * $pager->getLimit()})

{/if}
