<?php
class CustomerModel extends Database
{

	public function getCustomers($search='')
	{

        $arrSearch=array();

        $strUser='';
        $strLike = '';
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $strUser='WHERE u.id = ?';
            if(!empty($search)){
                $strLike = 'AND (kh.TenKH like ? OR kh.DienThoai LIKE ? or kh.DiaChi LIKE ?)';
            }
            $arrSearch[] = array($_SESSION['userid'],PDO::PARAM_INT);

        }

        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='admin'){
            $strUser='';
            if(!empty($search)){
                $strLike = 'WHERE kh.TenKH like ? OR kh.DienThoai LIKE ? or kh.DiaChi LIKE ?';
            }

        }

        $query="
                SELECT kh.idKH,kh.TenKH, Phai, kh.DiaChi, kh.DienThoai, kh.Email, kh.idQuanHuyen,q.TenQuanHuyen,kh.idNhomKH,nkh.TenNhomKH
                FROM khachhang kh
                INNER JOIN quan q ON kh.idQuanHuyen=q.idQuanHuyen
                INNER JOIN nhomkhachhang nkh ON kh.idNhomKH= nkh.idNhomKH
                INNER JOIN user u ON nkh.idUser= u.id ".$strUser." ".$strLike."
                ORDER BY kh.idKH desc";

        if(!empty($search)) {
            $arrSearch[] = array('%'.$search.'%',PDO::PARAM_STR);
            $arrSearch[] = array('%'.$search.'%',PDO::PARAM_STR);
            $arrSearch[] = array('%'.$search.'%',PDO::PARAM_STR);
        }

        $this->setQuery($query);
        $result= $this->loadAllRows($arrSearch);

        return $result;

	}

    public function getCustomerslimit($start,$limit,$search='')
    {

        $arrSearch=array();

        $strLike = '';
        $strUser='';
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $strUser='WHERE u.id = ?';
            if(!empty($search)){
                $strLike = 'AND (kh.TenKH like ? OR kh.DienThoai LIKE ? or kh.DiaChi LIKE ?)';
            }
            $arrSearch[] = array($_SESSION['userid'],PDO::PARAM_INT);

        }

        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='admin'){
            $strUser='';
            if(!empty($search)){
                $strLike = 'WHERE kh.TenKH like ? OR kh.DienThoai LIKE ? or kh.DiaChi LIKE ?';
            }

        }

        $query="SELECT kh.idKH,kh.TenKH, Phai, kh.DiaChi, kh.DienThoai, kh.Email, kh.idQuanHuyen,q.TenQuanHuyen,kh.idNhomKH,nkh.TenNhomKH
                FROM khachhang kh
                INNER JOIN quan q ON kh.idQuanHuyen=q.idQuanHuyen
                INNER JOIN nhomkhachhang nkh ON kh.idNhomKH= nkh.idNhomKH
                INNER JOIN user u ON nkh.idUser= u.id ".$strUser." ".$strLike."
                ORDER BY kh.idKH desc
                LIMIT ?,? ";

        if(!empty($search)) {
            $arrSearch[] = array('%'.$search.'%',PDO::PARAM_STR);
            $arrSearch[] = array('%'.$search.'%',PDO::PARAM_STR);
            $arrSearch[] = array('%'.$search.'%',PDO::PARAM_STR);
        }

        $arrSearch[] =array($start,PDO::PARAM_INT);
        $arrSearch[] =array($limit,PDO::PARAM_INT);
        $this->setQuery($query);
        $result= $this->loadAllRows($arrSearch);
        return $result;

    }

    public function  getDistricts()
    {
        $query="SELECT idQuanHuyen,TenQuanHuyen FROM quan  ORDER BY idQuanHuyen DESC";
        $this->setquery($query);
        $result = $this->loadAllRows();

        return $result;
    }
    public function getNhomKhachHang()
    {
        $queryNhomKH= 'SELECT * FROM nhomkhachhang WHERE idUser='.$_SESSION['userid'];
        $this->setQuery($queryNhomKH);
        $resultNhomKH= $this->loadAllRows();

        $arr= array();
        foreach($resultNhomKH as $item){
            $arr[]= $item->idNhomKH;
        }
        $str=implode(',',$arr);
        $query="SELECT idNhomKH,TenNhomKH FROM nhomkhachhang";
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $query.=' WHERE idNhomKH IN('.$str.')';
        }
        $this->setquery($query);
        $result = $this->loadAllRows();

        return $result;
    }

	public function getCustomer($idKH)
	{
        $query="SELECT idKH,TenKH, Phai, DiaChi, DienThoai, Email, kh.idQuanHuyen,q.TenQuanHuyen
		FROM khachhang kh
		INNER JOIN quan q ON kh.idQuanHuyen=q.idQuanHuyen
		WHERE kh.idKH=".$idKH;
        $this->setquery($query);
        $result = $this->loadRow();

        return $result;
	}
	
	public function creatCustomer($params)
	{
		$query='INSERT INTO khachhang(TenKH,Phai,DiaChi,DienThoai,Email,idQuanHuyen,idNhomKH) VALUES(?,?,?,?,?,?,?)';
        $this->setQuery($query);

        $result = $this->execute(array(
           array($params['TenKH'],PDO::PARAM_STR),
            array($params['Phai'],PDO::PARAM_INT),
            array($params['DiaChi'],PDO::PARAM_STR),
            array($params['DienThoai'],PDO::PARAM_STR),
            array($params['Email'],PDO::PARAM_STR),
            array($params['idQuanHuyen'],PDO::PARAM_INT),
            array($params['idNhomKH'],PDO::PARAM_INT)
        ));
        if(!$result) {
            return false;
        }
        return true;
	}
	
	public function updateCustomer($params)
	{
        $query='UPDATE khachhang SET TenKH=?,Phai=?,DiaChi=?,DienThoai=?,Email=?,idQuanHuyen=?, idNhomKH=?  WHERE idKH=?';
        $this->setQuery($query);

        $result = $this->execute(array(
            array($params['TenKH'],PDO::PARAM_STR),
            array($params['Phai'],PDO::PARAM_INT),
            array($params['DiaChi'],PDO::PARAM_STR),
            array($params['DienThoai'],PDO::PARAM_STR),
            array($params['Email'],PDO::PARAM_STR),
            array($params['idQuanHuyen'],PDO::PARAM_INT),
            array($params['idNhomKH'],PDO::PARAM_INT),
            array($params['idKH'],PDO::PARAM_INT)
        ));

        if(!$result) {
            return false;
        }
        return true;
	}
	
	public function deleteCustomer($id)
	{
        $query='DELETE FROM khachhang WHERE idKH=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($id,PDO::PARAM_INT)
        ));
        if(!$result) {
            return false;
        }
		return true;
	}
}