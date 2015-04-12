<?php
class OrderModel extends Database
{
    public function getOrders()
    {
        $query = 'SELECT idDonHang, d.idSanPham, SoLuong, d.idKH,d.idUser,sp.TenSanPham,kh.TenKH,us.username FROM donhang d
         JOIN sanpham sp ON d.idSanPham=sp.idSanPham
          JOIN khachhang kh ON d.idKH=kh.idKH
          JOIN user us ON d.idUser= us.id ORDER BY idDonHang DESC';
        $this->setQuery($query);
        $result= $this->loadAllRows();
        if(!$result){
            return false;
        }
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

    public function getOrdersLimit($start,$limit)
    {
        $query = 'SELECT idDonHang, d.idSanPham, SoLuong, d.idKH,d.idUser,sp.TenSanPham,kh.TenKH,us.username FROM donhang d
         JOIN sanpham sp ON d.idSanPham=sp.idSanPham
          JOIN khachhang kh ON d.idKH=kh.idKH
          JOIN user us ON d.idUser= us.id ORDER BY idDonHang DESC LIMIT ?,?';
        $this->setQuery($query);
        $result= $this->loadAllRows(array(
            array($start,PDO::PARAM_INT),
            array($limit,PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
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