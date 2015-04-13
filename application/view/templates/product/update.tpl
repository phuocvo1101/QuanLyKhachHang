<script type="text/javascript">
    function closeform1()
    {
        window.location="index.php?controller=product&action=index";
    }
</script>

<form action="index.php?controller=product&action=update" method="post">
    <div id="button">
        <ul>
            <li><input type="submit" name="submitUpdate" id="submitUpdate" value="Luu Va Thoat" /></li>
            <li><input type="button" name="dong" id="dong" onclick="closeform1();" value="Dong" /></li>
        </ul>

    </div>
    <div><br /></div>
    <div>
        <p><label id="tieude">Cap Nhap Thong Tin Nhom</p>
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
                <td><input type="text" value="{if isset($productname)}{$productname}{/if}" id="productname" name="productname" size="45px" /></td>
            </tr>
            <tr>
                <td align="right">Giá Sản Phẩm:</td>
                <td><input type="text" value="{if isset($price)}{$price|number_format:0}{/if}" id="price" name="price" size="30px" /></td>
            </tr>

            <input type="hidden" name="id" id="id" value="{if isset($idSanPham)}{$idSanPham}{/if}"/>

        </table>
    </div>

</form>