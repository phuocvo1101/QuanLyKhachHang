
<script src="{$PATH_JS}jquery-1.11.2.js"></script>
<script type="text/javascript">


    function getPage(pages,start,limit)
    {

        $.ajax({
            url : "index.php?controller=user&action=indexAjax",
            type : "post",
            dataType:"json",

            data : {
                pages:pages,
                start:start,
                limit:limit
            },
            success : function (result){
                //alert('abc');die();
                $('#data').html(result.data);
                $('#phantrang').html(result.phantrang);
            }
        });
    }
</script>
<form >
    <div id="button">
        <ul>
            <li><input type="button" name="themmoi" id="themmoi" value="Them Moi +" /></li>
            <li><input type="button" name="chinhsua" id="chinhsua" value="Chinh Sua" /></li>
            <li><input type="button" name="Xoa" id="Xoa" value="Xoa" /></li>
        </ul>

    </div>

    <br />
    <div>
        <p align="center"><label id="tieude">Quan Ly Thanh Vien</label>:<label id="tieude1">Danh Sach Thanh Vien</label></p>
    </div>
    <div>
        <table align="center" id="danhsach">
            <thead>
            <tr>
                <td><input type="checkbox" /></td>
                <td>Tên Đăng Nhập</td>
                <td>Mật Khẩu</td>
                <td>FullName</td>
                <td>Email</td>
                <td>ID</td>
            </tr>
            </thead>
            <tbody id="data">
            {foreach $users as $item}
                <tr>

                    <td><input type="checkbox" /></td>
                    <td>{$item->username}</td>
                    <td>{$item->password}</td>
                    <td>{$item->fullname}</td>
                    <td>{$item->email}</td>
                    <td>{$item->id}</td>


                </tr>
            {/foreach}
            </tbody>

        </table>
    </div>
    <p></p>
    <div id="phantrang">
        <table align="center" border="1px">
            <tr>
               <td>
                   {$listPages}
               </td>
            </tr>
        </table>
    </div>

</form>