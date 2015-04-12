{foreach $groups as $item}
    <tr>

        <td><input type="checkbox" value="{$item->idNhomKH}" /></td>
        <td>{$item->TenNHomKH}</td>
        <td>{$item->MoTa}</td>
        <td>{$item->idNhomKH}</td>
        <td>{$item->username}</td>


    </tr>
{/foreach}