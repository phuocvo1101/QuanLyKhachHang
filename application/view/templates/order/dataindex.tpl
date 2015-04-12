{if isset($orders)}
    {foreach $orders as $item}
        <tr>
            <td><input type="checkbox" value="{$item->idDonHang}" /></td>
            <td>{$item->idDonHang}</td>
            <td>{$item->TenSanPham}</td>
            <td>{$item->SoLuong}</td>
            <td>{$item->TenKH}</td>
            <td>{$item->username}</td>
        </tr>
    {/foreach}
{/if}