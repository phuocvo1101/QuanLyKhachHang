<script type="text/javascript">
    function closeform1()
    {
        window.location="index.php?controller=order&action=index";
    }
</script>

<form action="index.php?controller=order&action=create" method="post">
    <div id="button">
        <ul>
            <li><input type="submit" name="submitCreate" id="submitCreate" value="Luu Va Thoat" /></li>
            <li><input type="button" name="dong" id="dong" onclick="closeform1();" value="Dong" /></li>
        </ul>

    </div>
    <div><br /></div>
    <div>
        <p><label id="tieude">Them Don Hang</label></p>
    </div>
     <div style="color:red;">
         {if isset($errors)}
             <ul>
                 {foreach $errors as $item}
                     <li>{$item}</li>
                 {/foreach}
             </ul>
         {/if}
     </div>
    <div id="tablethanhvien">
        <table id="themthanhvien">
            <tr>
                <td align="right">Tên Sản Phẩm:</td>
                <td>
                    <select id="product" name="product">
                        {foreach $products as $item}
                            <option value="{$item->idSanPham}"  {if isset($product) && $product==$item->idSanPham}selected="selected"{/if} >{$item->TenSanPham}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>

            <tr>
                <td align="right">Số Lượng:</td>
                <td><input type="text" value="{if isset($soluong)}{$soluong}{/if}" id="soluong" name="soluong" size="30px" /></td>
            </tr>

            <tr>
                <td align="right">Tên Khách Hàng:</td>
                <td>
                    <select id="customer" name="customer">
                        {foreach $customers as $item}
                            <option value="{$item->idKH}"  {if isset($customer) && $customer==$item->idKH}selected="selected"{/if} >{$item->TenKH}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>

            <tr>
                <td align="right">Tên User:</td>
                <td>
                    <select id="user" name="user">
                        {foreach $users as $item}
                            <option value="{$item->id}"  {if isset($user) && $user==$item->id}selected="selected"{/if} >{$item->username}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>


        </table>
    </div>

</form>