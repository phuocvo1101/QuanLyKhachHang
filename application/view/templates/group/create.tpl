<script type="text/javascript">
    function closeform1()
    {
        window.location="index.php?controller=group&action=index";
    }
</script>

<form action="index.php?controller=group&action=create" method="post">
<div id="button">
    <ul>
        <li><input type="submit" name="submitCreate" id="submitCreate" value="Luu Va Thoat" /></li>
        <li><input type="button" name="dong" id="dong" onclick="closeform1();" value="Dong" /></li>
    </ul>

</div>
<div><br /></div>
<div>
    <p><label id="tieude">Quan Ly Danh sách Nhóm</label>: Thêm Nhóm</p>
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
            <td align="right">Tên Nhóm khách hàng:</td>
            <td><input type="text" value="{if isset($groupname)}{$groupname}{/if}" id="groupname" name="groupname" size="45px" /></td>
        </tr>
        <tr>
            <td align="right">Mô Tả:</td>
            <td><input type="text" value="{if isset($decription)}{$decription}{/if}" id="decription" name="decription" size="30px" /></td>
        </tr>
        <tr>
            <td align="right">Username:</td>
            <td>

                <select id="iduser" name="iduser">
                    {foreach $users as $item}
                         <option value="{$item->id}" >{$item->username}</option>
                    {/foreach}
                </select>

            </td>
        </tr>


    </table>
</div>
</div>
</form>