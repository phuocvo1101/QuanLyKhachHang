<script type="text/javascript">
    function closeform()
    {
        window.location="index.php?controller=customer&action=index";
    }
</script>
<form action="index.php?controller=customer&action=update" method="post">
<div id="button">
    <ul>
        <li><input type="submit" name="submitUpdate" id="submitUpdate" value="Luu Va Thoat" /></li>
        <li><input type="button" name="dong" id="dong" onclick="closeform();" value="Dong" /></li>
    </ul>

</div>
<div><br /></div>
<div>
    <p><label id="tieude">Quan Ly Danh sách khách hàng</label>: Danh Sach Khách hàng</p>
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
            <td align="right">Tên khách hàng:</td>
            <td><input type="text" value="{if isset($customername)}{$customername}{/if}" id="customername" name="customername" size="45px" /></td>
        </tr>
        <tr>
            <td align="right">Phái:</td>
            <td><input type="checkbox"  {if isset($sex) && $sex==1}checked="checked"{/if}  name="sex" id="sex" /> Nam</td>
        </tr>
        <tr>
            <td align="right">Email:</td>
            <td><input type="text" value="{if isset($email)}{$email}{/if}" id="email" name="email" size="30px" /></td>
        </tr>
        <tr>
            <td align="right">Địa chỉ:</td>
            <td><input type="text"  value="{if isset($address)}{$address}{/if}" id="address" name="address" size="45px" /></td>
        </tr>
        <tr>
            <td align="right">Điện thoại:</td>
            <td><input type="text"  value="{if isset($phonenumber)}{$phonenumber}{/if}"  id="phonenumber" name="phonenumber" size="45px" /></td>
        </tr>
        <tr>
            <td align="right">Quận/Huyện:</td>
            <td>
                <select id="district" name="district">
                    {foreach $districts as $item}
                        <option value="{$item->idQuanHuyen}"  {if isset($district) && $district==$item->idQuanHuyen}selected="selected"{/if} >{$item->TenQuanHuyen}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">Nhóm Khách Hàng:</td>
            <td>

                <select id="nhomKH" name="nhomKH">
                    {foreach $nhomKHs as $item}
                        <option value="{$item->idNhomKH}" >{$item->TenNhomKH}</option>
                    {/foreach}
                </select>

            </td>
        </tr>

        <input type="hidden" name="id" value="{if isset($id)}{$id}{/if}"/>
    </table>
</div>
</div>
</form>