<div>
    <form action="{$baseUrl}admin/addonmodules.php?module=trial_products&page=reports" method="POST">
        <label for="client-email">Email Address</label>
        <input id="client-email" name="email" class="form-control input-300" value="{$email}" type="text">
        <div style="margin-top: 10px">
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="submit" name="export-csv" class="btn btn-primary">Export To CSV</button>
        </div>
    </form>
</div>


<div style="margin-top: 10px">
    {$count} Records Total, Page {$currentPage} of {$pages}
</div>

<table class="datatable">
    <tr>
    {foreach from=$reportData[0]|@array_keys item=column_name}
        <th>{$column_name}</th>
    {/foreach}
    </tr>
    {foreach from=$reportData item=row}
        <tr>
            {foreach from=$row item=field}
                <td>{$field}</td>
            {/foreach}
        </tr>
    {/foreach}
</table>

{if $pages!=1}
<div class="text-center">
    <div style="display: inline-block;">
        <ul class="pagination">
            {foreach from=$paginationList item=npage}
                <li {if $currentPage==$npage}class="active"{/if}><a href="{$baseUrl}admin/addonmodules.php?module=trial_products&page=reports&report_page={$npage}{if $email}&email={$email}{/if}">{$npage}</a></li>
            {/foreach}
        </ul>
    </div>
</div>
{/if}