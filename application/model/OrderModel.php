<?php
class OrderModel extends Database
{
    public function getOrders($search='')
    {
        $arrsearch= array();
        $strlike='';
        $struser='';
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $struser=' WHERE d.idUser= ? ';
            $arrsearch[]= array($_SESSION['userid'],PDO::PARAM_INT);
            if(!empty($search)){
                $strlike= ' AND kh.TenKH LIKE ? OR sp.TenSanPham LIKE ? ';
            }
        }

        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='admin'){

            if(!empty($search)){
                $strlike= ' Where kh.TenKH LIKE ? OR sp.TenSanPham LIKE ? ';
            }
        }

        $query = 'SELECT idDonHang, d.idSanPham, SoLuong, d.idKH,d.idUser,sp.TenSanPham,kh.TenKH,us.username FROM donhang d
         JOIN sanpham sp ON d.idSanPham=sp.idSanPham
          JOIN khachhang kh ON d.idKH=kh.idKH
          JOIN user us ON d.idUser= us.id '.$struser." ".$strlike." ORDER BY idDonHang DESC";

        if(!empty($search)){
            $arrsearch[]= array('%'.$search.'%',PDO::PARAM_STR);
            $arrsearch[]= array('%'.$search.'%',PDO::PARAM_STR);
        }

        $this->setquery($query);

        $result = $this->loadAllRows($arrsearch);
        //var_dump($result);die();
        return $result;


    }
    public function getOrder($id)
    {
        $query = 'SELECT idDonHang, d.idSanPham, SoLuong, d.idKH,d.idUser,sp.TenSanPham,kh.TenKH,us.username FROM donhang d
         JOIN sanpham sp ON d.idSanPham=sp.idSanPham
          JOIN khachhang kh ON d.idKH=kh.idKH
          JOIN user us ON d.idUser= us.id  WHERE idDonHang=?';
        $this->setQuery($query);
        $result= $this->loadRow(array(
            array($id,PDO::PARAM_INT)
        ));

        if(!$result){
            return false;
        }
        return $result;

    }

    public function getOrdersLimit($start,$limit,$search='')
    {

        $arrsearch= array();
        $strlike='';
        $struser='';
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $struser=' WHERE d.idUser= ? ';
            $arrsearch[]= array($_SESSION['userid'],PDO::PARAM_INT);
            if(!empty($search)){
                $strlike= 'AND kh.TenKH LIKE ? OR sp.TenSanPham LIKE ? ';
            }
        }

        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='admin'){

            if(!empty($search)){
                $strlike= ' Where kh.TenKH LIKE ? OR sp.TenSanPham LIKE ? ';
            }
        }

        $query = 'SELECT idDonHang, d.idSanPham, SoLuong, d.idKH,d.idUser,sp.TenSanPham,kh.TenKH,us.username FROM donhang d
         JOIN sanpham sp ON d.idSanPham=sp.idSanPham
          JOIN khachhang kh ON d.idKH=kh.idKH
          JOIN user us ON d.idUser= us.id '.$struser." ".$strlike."ORDER BY idDonHang DESC LIMIT ?,?";

        if(!empty($search)){
            $arrsearch[]= array('%'.$search.'%',PDO::PARAM_STR);
            $arrsearch[]= array('%'.$search.'%',PDO::PARAM_STR);
        }
        $arrsearch[]= array($start,PDO::PARAM_INT);
        $arrsearch[]= array($limit,PDO::PARAM_INT);

        $this->setquery($query);

        $result = $this->loadAllRows($arrsearch);
        return $result;

    }
    public function getProducts()
    {
        $query = 'SELECT idSanPham, TenSanPham FROM sanpham';
        $this->setQuery($query);
        $result= $this->loadAllRows();
        if(!$result){
            return false;
        }
        return $result;
    }
    public function getCustomers()
    {
        $query = 'SELECT idKH, TenKH FROM khachhang';
        $this->setQuery($query);
        $result= $this->loadAllRows();
        if(!$result){
            return false;
        }
        return $result;
    }
    public function getUsers()
    {
        $query = 'SELECT id, username FROM user';
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $query.=' WHERE id='.$_SESSION['userid'];
        }
        $this->setQuery($query);
        $result= $this->loadAllRows();
        if(!$result){
            return false;
        }
        return $result;
    }

    public function createOrder($params)
    {
        $query ='INSERT INTO donhang(idSanPham,SoLuong,idKH,idUser) VALUES (?,?,?,?)';
        $this->setQuery($query);
        $result= $this->execute(array(
            array($params['idSanPham'],PDO::PARAM_INT),
            array($params['SoLuong'],PDO::PARAM_INT),
            array($params['idKH'],PDO::PARAM_INT),
            array($params['idUser'],PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function UpdateOrder($params)
    {
        $query ='UPDATE donhang SET idSanPham=?,SoLuong=?,idKH=?,idUser=? WHERE idDonHang=?';
        $this->setQuery($query);
        $result= $this->execute(array(
            array($params['idSanPham'],PDO::PARAM_INT),
            array($params['SoLuong'],PDO::PARAM_INT),
            array($params['idKH'],PDO::PARAM_INT),
            array($params['idUser'],PDO::PARAM_INT),
             array($params['idDonHang'],PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function DeleteOrder($idDonHang)
    {
        $query ='DELETE FROM donhang WHERE idDonHang=?';
        $this->setQuery($query);
        $result= $this->execute(array(
            array($idDonHang,PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
}