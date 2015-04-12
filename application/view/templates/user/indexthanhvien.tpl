<script type="text/javascript">
    function UpdateThanhVien()
    {
        window.location= 'index.php?controller=user&action=updatethanhvien';
    }
</script>
<form >

    <div id="button">
        <ul>
            <li><input type="button" onclick="UpdateThanhVien();" name="chinhsua" id="chinhsua" value="Chinh Sua" /></li>
        </ul>

    </div>

    <br />
    <div>
        <p align="center"><label id="tieude">Quan Ly Thanh Vien</label>:<label id="tieude1">Thanh Vien</label></p>
    </div>
    <div>
        <table align="center" id="danhsach">
            <thead>
            <tr>
                <td>Tên Đăng Nhập</td>
                <td>FullName</td>
                <td>Email</td>
                <td>Loại User</td>
                <td>ID</td>
            </tr>
            </thead>
            <tbody id="data">
                <tr>
                    <td>{$user->username}</td>
                    <td>{$user->fullname}</td>
                    <td>{$user->email}</td>
                    <td>{$user->loaiuser}</td>
                    <td>{$user->id}</td>


                </tr>
            </tbody>

        </table>
    </div>
</form>