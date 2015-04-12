<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Danh Sach Thanh Vien</title>
<link rel="stylesheet" href="dinhdang.css" />

</head>

<body >
	<div style="background:white;min-height:200px;" id="contrainer">
	<div id="noidung">	
		<div id="top">	
			<ul>
				<li>User: </li>
				<li style="color:#FF0000"><a href="index.php?controller=user&action=updatethanhvien"> {if isset($username1)}{$username1}{/if}</a></li>
				<li><a href="index.php?controller=user&action=logout">Dang Xuat<a/></li>
			</ul>
		</div>
		<div id="menu">
			<ul>
                {if isset($loaiuser) && {$loaiuser}==admin}
                    <li><a href="index.php?controller=user&action=index">Quan ly Thanh Vien</a>
                        <ul>
                            <li><a href="index.php?controller=user&action=create">Them Moi Thanh Vien</a></li>
                            <li><a href="#">Them Thong Tin Thanh Vien</a></li>
                        </ul>
                    </li>
                {/if}

				<li><a href="index.php?controller=group&action=index">Quan Ly Nhom Khach Hang</a>
					<ul>
						<li><a href="index.php?controller=group&action=create">Them Moi Nhom Khach Hang</a></li>
					</ul>
				</li>
				<li><a href="index.php?controller=customer&action=index">Quan Ly Khach Hang</a>
					<ul>
						<li><a href="index.php?controller=customer&action=create">Them Moi Khach Hang</a></li>
					</ul>
				</li>
                <li><a href="index.php?controller=order&action=index">Quan Ly Don Hang</a>
                    <ul>
                        <li><a href="index.php?controller=order&action=create">Thêm Mới Đơn Hàng</a></li>
                    </ul>
                </li>
			</ul>
		</div>

	<div >
		{$content}
	</div>
</div>
</body>
</html>


