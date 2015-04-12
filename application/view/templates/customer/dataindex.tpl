{if isset($customers)}
    {foreach $customers as $key=>$customer}
        <tr>
            <td><input name="slcheckbox" type="checkbox" id="cus-{$customer->idKH}" value="{$customer->idKH}" /></td>
            <td>{$customer->TenKH}</td>
            <td>
                {if $customer->Phai==1}
                    Nam
                {else}
                    Nữ
                {/if}

            <td>{$customer->DiaChi}</td>
            <td>{$customer->DienThoai}</td>
            <td>{$customer->Email}</td>
            <td>{$customer->TenQuanHuyen}</td>
            <td>{$customer->TenNhomKH}</td>
            <td>{$customer->idKH}</td>
        </tr>
    {/foreach}
{/if}