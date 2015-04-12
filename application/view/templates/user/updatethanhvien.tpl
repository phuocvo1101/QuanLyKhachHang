<script type="text/javascript">
    function closeform1()
    {
        window.location="index.php?controller=customer&action=index";
    }
</script>

<form action="index.php?controller=user&action=updatethanhvien" method="post">
    <div id="button">
        <ul>
            <li><input type="submit" name="submitUpdate" id="submitUpdate" value="Luu Va Thoat" /></li>
            <li><input type="button" name="dong" id="dong" onclick="closeform1();" value="Dong" /></li>
        </ul>

    </div>
    <div><br /></div>
    <div>
        <p><label id="tieude">Thông Tin Thành Viên</label></p>
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
                <td align="right">UserName:</td>
                <td><input type="text" value="{if isset($username)}{$username}{/if}" id="username" name="username" size="45px" /></td>
            </tr>
            <tr>
                <td align="right">PassWord:</td>
                <td><input type="password"    name="password" id="password" /></td>
            </tr>
            <tr>
                <td align="right">Xác Nhận PassWord:</td>
                <td><input type="password"   name="xnpassword" id="xnpassword" /></td>
            </tr>
            <tr>
                <td align="right">FullName:</td>
                <td><input type="text" value="{if isset($fullname)}{$fullname}{/if}" id="fullname" name="fullname" size="45px" /></td>
            </tr>
            <tr>
                <td align="right">Email:</td>
                <td><input type="text" value="{if isset($email)}{$email}{/if}" id="email" name="email" size="30px" /></td>
            </tr>
            <tr>
                <td align="right">Loại User:</td>
                <td>
                    <select id="loaiuser" name="loaiuser">
                        <option value="admin" {if isset($loaiuser) && $loaiuser=='admin'}selected="selected"{/if}>admin</option>
                        <option value="thanhvien" {if isset($loaiuser) && $loaiuser=='thanhvien'}selected="selected"{/if}>Thanh Vien</option>
                    </select>
                </td>
            </tr>

            <input type="hidden" id="id" name="id"  value="{if isset($id)}{$id}{/if}"/>

        </table>
    </div>

</form>