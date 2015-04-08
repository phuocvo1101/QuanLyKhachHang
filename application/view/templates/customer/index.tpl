<script src="{$PATH_JS}jquery-1.11.2.js"></script>
<script type="text/javascript">


    function getPage(pages,start,limit)
    {

        $.ajax({
            url : "index.php?controller=customer&action=indexAjax",
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


    $(function(){
        $('#chinhsua').click(function(){
            var arr = [];
            $("input:checked").each(function(){
                arr.push($(this).val());
            });
            if(arr.length>0) {
                window.location = "index.php?controller=customer&action=update&id="+arr[0];
            }

        });

        $('#Xoa').click(function(){
            var str="";
            $("input:checked").each(function(){
                str+=$(this).val()+",";
            });
            if(str!="") {
                str = str.substr(0,str.length-1);

                window.location = "index.php?controller=customer&action=delete&listid="+str;
            }

        });

    });

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
			<p align="center"><label id="tieude">Quan Ly Khách Hàng</label>:<label id="tieude1">Danh sách khách hàng</label></p>
		</div>
		<div>
			<table align="center" id="danhsach">
                <thead>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Tên khách hàng</td>
					<td>Phái</td>
					<td>Địa chỉ</td>
					<td>Điện thoại</td>
                    <td>Email</td>
                    <td>Quận/Huyện</td>
                    <td>User</td>
					<td>ID</td>
				</tr>
                </thead>
                <tbody id="data">
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
                            <td>{$customer->idUser}</td>
                            <td>{$customer->idKH}</td>
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
					<td>{$listPage}</td>
				</tr>
			</table>
		</div>

	</form>