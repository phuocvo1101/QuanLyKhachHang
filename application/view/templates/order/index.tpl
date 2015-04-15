<script src="{$PATH_JS}jquery-1.11.2.js"></script>
<script type="text/javascript">


    function getPage(pages,start,limit,search)
    {

        search= $('#search').val();
        $.ajax({

            url : "index.php?controller=order&action=indexAjax",
            type : "post",
            dataType:"json",

            data : {
                pages:pages,
                start:start,
                limit:limit,
                search:search
            },
            success : function (result){
                // alert('abc');die();
                $('#data').html(result.data);
                $('#phantrang').html(result.phantrang);
            }
        });
    }
    function themmoicustomer()
    {
        window.location= 'index.php?controller=order&action=create';
    }

    $(function(){
        $('#chinhsua').click(function(){
            var arr = [];
            $("input:checked").each(function(){
                arr.push($(this).val());
            });
            if(arr.length>0) {
                window.location = "index.php?controller=order&action=update&id="+arr[0];
            }

        });

        $('#Xoa').click(function(){
            var str="";
            $("input:checked").each(function(){
                str+=$(this).val()+",";
            });
            if(str!="") {
                str = str.substr(0,str.length-1);

                window.location = "index.php?controller=order&action=delete&listid="+str;
            }

        });
        $('#ok').click(function(){
           getPage();
        });

    });

</script>

<form >
    <div id="button">
        <ul>
            <li><input type="button" onclick="themmoicustomer();" name="themmoi" id="themmoi" value="Them Moi +" /></li>
            <li><input type="button" name="chinhsua" id="chinhsua" value="Chinh Sua" /></li>
            <li><input type="button" name="Xoa" id="Xoa" value="Xoa" /></li>
        </ul>

    </div>
    <br />

    <div>
        <p align="center"><label id="tieude">Quản Lý Đơn Hàng</label>:<label id="tieude1">Danh sách Đơn Hàng</label></p>
    </div>

    <div>
        <table align="center">
            <tr>
                <td><input type="text" name="search" id="search" placeholder="search: productname, customername" size="35"/></td>
                <td><input type="button" name="ok" id="ok" value="search"></td>
            </tr>
        </table>
    </div>

    <div>
        <table align="center" id="danhsach">
            <thead>
            <tr>
                <td><input type="checkbox" /></td>
                <td>id Đơn Hàng</td>
                <td>Tên Sản Phẩm</td>
                <td>Số Lượng</td>
                <td>Tên Khách Hàng</td>
                <td>Tên User</td>
            </tr>
            </thead>
            <tbody id="data">
            {if isset($orders)}
                {foreach $orders as $item}
                    <tr>
                        <td><input type="checkbox" value="{$item->idDonHang}" /></td>
                        <td>{$item->idDonHang}</td>
                        <td>{$item->TenSanPham}</td>
                        <td>{$item->SoLuong}</td>
                        <td>{$item->TenKH}</td>
                        <td>{$item->username}</td>
                    </tr>
                {/foreach}
            {/if}
            </tbody>
        </table>
    </div>
    <p></p>
    <div id="phantrang">
        <table align="center" border="1px">
            <tr>
                <td>{$listPages}</td>
            </tr>
        </table>
    </div>

</form>