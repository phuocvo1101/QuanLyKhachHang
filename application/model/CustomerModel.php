<?php
class CustomerModel extends Database
{

	public function getCustomers($start=null,$limit=null)
	{

		$query="SELECT idKH,TenKH, Phai, DiaChi, DienThoai, Email, kh.idQuanHuyen,q.TenQuanHuyen,kh.idNhomKH,nkh.TenNhomKH
		FROM khachhang kh
		INNER JOIN quan q ON kh.idQuanHuyen=q.idQuanHuyen
		INNER JOIN nhomkhachhang nkh ON kh.idNhomKH= nkh.idNhomKH
		ORDER BY idKH DESC";
        if($start!==null && $limit!==null) {

            $query.=" LIMIT ?, ?";
        }

        $this->setquery($query);
        if($start!==null && $limit!==null) {
            $result = $this->loadAllRows(array(array($start,PDO::PARAM_INT),array($limit,PDO::PARAM_INT)));
        } else {
            $result = $this->loadAllRows();
        }


        return $result;
	}

    public function getCustomerslimit($start,$limit)
    {


        $result = $this->getCustomers($start,$limit);

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
        $query="SELECT idNhomKH,TenNhomKH FROM nhomkhachhang  ORDER BY idNhomKH DESC";
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