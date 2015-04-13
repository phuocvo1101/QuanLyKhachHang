{foreach $products as $item}
    <tr>

        <td><input type="checkbox" value="{$item->idSanPham}" /></td>
        <td>{$item->TenSanPham}</td>
        <td>{$item->GiaSanPham|number_format:0}</td>
        <td>{$item->idSanPham}</td>

    </tr>
{/foreach}