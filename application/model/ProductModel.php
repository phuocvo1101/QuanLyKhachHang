<?php
class ProductModel extends Database
{
    public function getProducts()
    {
        $query='select idSanPham,TenSanPham,GiaSanPham from sanpham';
        $this->setQuery($query);
        $result = $this->loadAllRows();
        return $result;
    }
    public function getProductLimit($start,$limit)
    {
        $query='select idSanPham,TenSanPham,GiaSanPham from sanpham ORDER BY idSanPham desc LIMIT ?,?';
        $this->setQuery($query);
        $result = $this->loadAllRows(array(
            array($start,PDO::PARAM_INT),
            array($limit,PDO::PARAM_INT)
        ));

        return $result;
    }
    public function getProduct($idSanPham)
    {
        $query='select idSanPham,TenSanPham,GiaSanPham from sanpham WHERE idSanPham=?';
        $this->setQuery($query);
        $result = $this->loadRow(array(
            array($idSanPham,PDO::PARAM_INT)
        ));
        return $result;
    }

    public function createProduct($params)
    {
        $query= 'INSERT INTO sanpham(TenSanPham,GiaSanPham) VALUES (?,?)';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($params['TenSanPham'],PDO::PARAM_STR),
            array($params['GiaSanPham'],PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function updateProduct($params)
    {
        $query= 'UPDATE sanpham SET TenSanPham=?,GiaSanPham=? WHERE idSanPham=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($params['TenSanPham'],PDO::PARAM_STR),
            array($params['GiaSanPham'],PDO::PARAM_STR),
            array($params['idSanPham'],PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function deleteProduct($id)
    {
        $query= 'DELETE FROM sanpham WHERE idSanPham=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($id,PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function checkProductName($productname)
    {
        $query= 'select * from sanpham WHERE TenSanPham=? ';
        $this->setQuery($query);
        $result= $this->loadRow(array(
            array($productname,PDO::PARAM_STR)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function checkProductNameUpdate($productname ,$idSanPham)
    {
        $query= 'select * from sanpham WHERE TenSanPham=? AND idSanPham<>?';
        $this->setQuery($query);
        $result= $this->loadRow(array(
            array($productname,PDO::PARAM_STR),
            array($idSanPham,PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    function _toInt($str)
    {
        return (int)preg_replace("/([^0-9\\.])/i", "", $str);
    }
}