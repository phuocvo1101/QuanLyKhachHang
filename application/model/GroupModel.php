<?php
class GroupModel extends Database
{
    public function getGroups($start=null,$limit=null)
    {
        $query='select idNhomKH,TenNHomKH,MoTa,nkh.idUser, u.username
        from nhomkhachhang nkh JOIN user u ON nkh.idUser= u.id';
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $query= $query.' WHERE idUser='.$_SESSION['userid'].'  ORDER BY idNhomKH DESC';
        }else{
            $query= $query.'  ORDER BY idNhomKH DESC';
        }
        if($start!==null && $limit!==null) {

            $query.=" LIMIT ?, ?";
        }

        $this->setquery($query);
        if($start!==null && $limit!==null) {
            $result = $this->loadAllRows(array(
                array($start,PDO::PARAM_INT),
                array($limit,PDO::PARAM_INT)));
        } else {
            $result = $this->loadAllRows();
        }
       // $this->setQuery($query);
        //$result = $this->loadAllRows();
        return $result;
    }
    public function getGroupLimit($start,$limit)
    {
       /* $query='select idNhomKH,TenNHomKH,MoTa,nkh.idUser, u.username
        from nhomkhachhang nkh JOIN user u ON nkh.idUser= u.id ORDER BY idNhomKH desc LIMIT ?,?';
        $this->setQuery($query);
        $result = $this->loadAllRows(array(
            array($start,PDO::PARAM_INT),
            array($limit,PDO::PARAM_INT)
        ));*/
        $result= $this->getGroups($start,$limit);

        return $result;
    }
    public function getGroup($idNhomKH)
    {
        $query='select idNhomKH,TenNHomKH,MoTa,nkh.idUser, u.username
        from nhomkhachhang nkh JOIN user u ON nkh.idUser= u.id WHERE idNhomKH=?';
        $this->setQuery($query);
        $result = $this->loadRow(array(
            array($idNhomKH,PDO::PARAM_INT)
        ));
        return $result;
    }

    public function getUsers()
    {
        $query= 'SELECT id, username, password,fullname,email,loaiuser  from user';
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $query.=' WHERE id='.$_SESSION['userid'];
        }
        $this->setQuery($query);
        $result= $this->loadAllRows();
        return $result;
    }
    public function createGroup($params)
    {
        $query= 'INSERT INTO nhomkhachhang(TenNhomKH,MoTa,idUser) VALUES (?,?,?)';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($params['TenNhomKH'],PDO::PARAM_STR),
            array($params['MoTa'],PDO::PARAM_STR),
            array($params['idUser'],PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function updateGroup($params)
    {
        $query= 'UPDATE nhomkhachhang SET TenNhomKH=?,MoTa=?,idUser=? WHERE idNhomKH=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($params['TenNhomKH'],PDO::PARAM_STR),
            array($params['MoTa'],PDO::PARAM_STR),
            array($params['idUser'],PDO::PARAM_INT),
            array($params['idNhomKH'],PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function deleteGroup($id)
    {
        $querydeleteKH = 'DELETE FROM khachhang WHERE idNhomKH=?';
        $this->setQuery($querydeleteKH);
        $resultdeleteKH= $this->execute(array(
            array($id,PDO::PARAM_INT)
        ));
        $query= 'DELETE FROM nhomkhachhang WHERE idNhomKH=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($id,PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function checkGroupName($groupname)
    {
        $query= 'select * from nhomkhachhang WHERE TenNhomKH=? ';
        $this->setQuery($query);
        $result= $this->loadRow(array(
            array($groupname,PDO::PARAM_STR)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function checkGroupNameUpdate($groupname ,$idNhomKH)
    {
        $query= 'select * from nhomkhachhang WHERE TenNhomKH=? AND idNhomKH<>?';
        $this->setQuery($query);
        $result= $this->loadRow(array(
            array($groupname,PDO::PARAM_STR),
            array($idNhomKH,PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
}