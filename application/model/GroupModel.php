<?php
class GroupModel extends Database
{
    public function getGroups($search="")
    {
        $arrSearch=array();
        $struser='';
        $strlike="";
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $struser="WHERE u.id = ?";
            $arrSearch[]= array($_SESSION['userid'], PDO::PARAM_INT);

            if(!empty($search)){
                $strlike= "AND TenNHomKH LIKE ?";
                $arrSearch[]=array('%'.$search.'%',PDO::PARAM_STR);
            }


        }
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='admin'){

            if(!empty($search)){
                $strlike= "WHERE TenNHomKH LIKE ? OR u.username LIKE ?";
                $arrSearch[]=array('%'.$search.'%',PDO::PARAM_STR);
                $arrSearch[]=array('%'.$search.'%',PDO::PARAM_STR);
            }

        }


        $query="select idNhomKH,TenNHomKH,MoTa,nkh.idUser, u.username
                from nhomkhachhang nkh JOIN user u ON nkh.idUser= u.id ".$struser." ".$strlike.
                " ORDER BY idNhomKH DESC";
        $this->setQuery($query);
        $result= $this->loadAllRows($arrSearch);
        return $result;

    }
    public function getGroupLimit($start,$limit,$search='')
    {
        $arrSearch=array();
        $struser='';
        $strlike="";
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='thanhvien'){
            $struser="WHERE u.id = ?";
            $arrSearch[] = array($_SESSION['userid'],PDO::PARAM_INT);

            if(!empty($search)){
                $strlike= "AND TenNHomKH LIKE ?";
                $arrSearch[]=array('%'.$search.'%',PDO::PARAM_STR);
            }


        }
        if(isset($_SESSION['loaiuser']) && $_SESSION['loaiuser']=='admin'){

            if(!empty($search)){
                $strlike= "WHERE TenNHomKH LIKE ? OR u.username LIKE ?";
                $arrSearch[]=array('%'.$search.'%',PDO::PARAM_STR);
                $arrSearch[]=array('%'.$search.'%',PDO::PARAM_STR);
            }

        }


        $query="select idNhomKH,TenNHomKH,MoTa,nkh.idUser, u.username
                from nhomkhachhang nkh JOIN user u ON nkh.idUser= u.id ".$struser." ".$strlike.
            " ORDER BY idNhomKH DESC LIMIT ?,?";

        $arrSearch[] =array($start,PDO::PARAM_INT);
        $arrSearch[] =array($limit,PDO::PARAM_INT);

        $this->setquery($query);
        $result= $this->loadAllRows($arrSearch);
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