
<script src="{$PATH_JS}jquery-1.11.2.js"></script>
<script type="text/javascript">


    function getPage(pages,start,limit,search)
    {
        var search=$("#search").val();
        $.ajax({

            url : "index.php?controller=group&action=indexAjax",
            type : "post",
            dataType:"json",

            data : {
                pages:pages,
                start:start,
                limit:limit,
                search:search
            },
            success : function (result){

                $('#data').html(result.data);
                $('#phantrang').html(result.phantrang);
            }
        });
    }
    function themmoigroup()
    {
        window.location= 'index.php?controller=group&action=create';
    }
    $(function(){
        $('#chinhsua').click(function(){
            var arr=[];
            $('input:checked').each(function(){
                arr.push($(this).val());
            });
            if(arr !=''){
               window.location= 'index.php?controller=group&action=update&id='+arr[0];
            }
        });
        $('#Xoa').click(function(){
            str=''
            $('input:checked').each(function(){
                str+= $(this).val()+',';
            });
            if(str!=''){
                str= str.substr(0,str.length-1);
                window.location= "index.php?controller=group&action=delete&listid="+str;
            }
        });
        $("#ok").click(function(){
            getPage();
        });
    });
</script>
<form >

    <div id="button">
        <ul>
            <li><input type="button" onclick="themmoigroup();" name="themmoi" id="themmoi" value="Them Moi +" /></li>
            <li><input type="button" name="chinhsua" id="chinhsua" value="Chinh Sua" /></li>
            <li><input type="button" name="Xoa" id="Xoa" value="Xoa" /></li>
        </ul>

    </div>

    <br />
    <div>
        <p align="center"><label id="tieude">Quản Lý Nhóm Khách Hàng</label>:<label id="tieude1">Danh Sách Nhóm Khách Hàng</label></p>
    </div>

    <div align="center">
        <table>
            <tr>
                <td> <input type="text" name="search" id="search" placeholder="search: customergroup or username" size="40px" /></td>
                <td> <input type="button" name="ok" id="ok" value="search" /></td>
            </tr>
        </table>

    </div>

    <div>
        <table align="center" id="danhsach">
            <thead>
            <tr>
                <td><input type="checkbox" /></td>
                <td>Tên Nhóm Khách Hàng</td>
                <td>Mô Tả</td>
                <td>ID Nhóm Khách Hàng</td>
                <td>Username</td>
            </tr>
            </thead>
            <tbody id="data">
            {foreach $groups as $item}
                <tr>

                    <td><input type="checkbox" value="{$item->idNhomKH}" /></td>
                    <td>{$item->TenNHomKH}</td>
                    <td>{$item->MoTa}</td>
                    <td>{$item->idNhomKH}</td>
                    <td>{$item->username}</td>


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