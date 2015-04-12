
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

                $('#data').html(result.data);
                $('#phantrang').html(result.phantrang);
            }
        });
    }
    function themmoiuser()
    {
        window.location= 'index.php?controller=user&action=create';
    }
    $(function(){
        $('#chinhsua').click(function(){
            var arr=[];
            $('input:checked').each(function(){
                arr.push($(this).val());
            });
            if(arr !=''){
               window.location= 'index.php?controller=user&action=update&id='+arr[0];
            }
        });
        $('#Xoa').click(function(){
            str=''
            $('input:checked').each(function(){
                str+= $(this).val()+',';
            });
            if(str!=''){
                str= str.substr(0,str.length-1);
                window.location= "index.php?controller=user&action=delete&listid="+str;
            }
        });
    });
</script>
<form >

    <div id="button">
        <ul>
            <li><input type="button" onclick="themmoiuser();" name="themmoi" id="themmoi" value="Them Moi +" /></li>
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
                <td>FullName</td>
                <td>Email</td>
                <td>Loại User</td>
                <td>ID</td>
            </tr>
            </thead>
            <tbody id="data">
            {foreach $users as $item}
                <tr>

                    <td><input type="checkbox" value="{$item->id}" /></td>
                    <td>{$item->username}</td>
                    <td>{$item->fullname}</td>
                    <td>{$item->email}</td>
                    <td>{$item->loaiuser}</td>
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