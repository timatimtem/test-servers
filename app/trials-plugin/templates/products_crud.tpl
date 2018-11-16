<form action="" method="POST" style="padding-bottom: 20px">
    <table class="form" id="data-form">
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Free period</th>
            <th></th>
        </tr>
        {foreach from=$trialProducts item=product}
            <tr>
                <td>
                    {$product->name}
                </td>
                <td class="fieldarea">
                    <input class="form-control" size="3" name="products[{$product->id}][category]" value="{$product->category}" type="text">
                </td>
                <td class="fieldarea">
                    <input class="form-control" size="3" name="products[{$product->id}][free_period]" value="{$product->free_period}" type="text">
                </td>
                <td>
                    <button type="submit" class="btn btn-default btnremove">Remove</button>
                </td>
            </tr>
        {/foreach}
    </table>

    <button type="submit" class="btn btn-primary">Save</button>
</form>

<form action="" method="POST">
    <table class="form">
        <tr>
            <td>
                Product
            </td>
            <td class="fieldarea">
                <select name="new[id]">
                    {foreach from=$productsGrouped item="productsInGroup" key="groupTitle"}
                        <optgroup label="{$groupTitle}">
                            {foreach from=$productsInGroup item="product"}
                                <option value="{$product->id}">{$product->name}</option>
                            {/foreach}
                        </optgroup>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Category
            </td>
            <td class="fieldarea">
                <input class="form-control" name="new[category]">
            </td>
        </tr>
        <tr>
            <td>
                Free period
            </td>
            <td class="fieldarea">
                <input class="form-control" size="3" name="new[free_period]" type="text">
            </td>
        </tr>
    </table>

    <button type="submit" class="btn btn-primary btnadd">Add new</button>
</form>

<script>
    $('#data-form').on('click', '.btnremove', function(e) {
        var row = $(e.target).closest('tr');
        row.css('display', 'none');
        row.find('.form-control').val(-1);
    });
</script>