<style>
#settings th, td {
    padding: 5px;
}
</style>

{if $updated}
{$updated} product(s) updated.
{/if}

<ul class="nav nav-tabs admin-tabs" role="tablist">
    <li {if $page=='crud'}class="active"{/if}><a href="{$baseUrl}admin/addonmodules.php?module=trial_products&page=crud">Trial products</a></li>
    <li {if $page=='reports'}class="active"{/if}><a href="{$baseUrl}admin/addonmodules.php?module=trial_products&page=reports">Reports</a></li>
</ul>

<div class="tab-content admin-tabs">
    {if $page=='crud'}
        <div class="tab-pane active" id="products">
            {include file=$smarty.current_dir|cat:'/products_crud.tpl'}
        </div>
    {else}
        <div class="tab-pane active" id="reports">
            {include file=$smarty.current_dir|cat:'/reports.tpl'}
        </div>
    {/if}
</div>