<script type="text/javascript">
    function closeform1()
    {
        window.location="index.php?controller=customer&action=index";
    }
</script>

<form action="index.php?controller=user&action=create" method="post">
    <div id="button">
        <ul>
            <li><input type="submit" name="submitCreate" id="submitCreate" value="Luu Va Thoat" /></li>
            <li><input type="button" name="dong" id="dong" onclick="closeform1();" value="Dong" /></li>
        </ul>

    </div>
    <div><br /></div>
    <div>
        <p><label id="tieude">Quan Ly Danh Sách Thành Viên</label>: Thêm Danh Sách Thành Viên</p>
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
                <td><input type="password"  value="{if isset($password)}{$password}{/if}"   name="password" id="password" /></td>
            </tr>
            <tr>
                <td align="right">FullName:</td>
                <td><input type="text" value="{if isset($fullname)}{$fullname}{/if}" id="fullname" name="fullname" size="45px" /></td>
            </tr>
            <tr>
                <td align="right">Email:</td>
                <td><input type="text" value="{if isset($email)}{$email}{/if}" id="email" name="email" size="30px" /></td>
            </tr>


        </table>
    </div>

</form>