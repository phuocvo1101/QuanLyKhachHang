<?php
class UserModel extends Database
{

	public function checkLogin($username,$password)
	{
		$password = md5($password);
	
		$query = 'SELECT username,password,id,email,fullname,loaiuser FROM user WHERE username=? and password=?';
		$this->setQuery($query);
		$result = $this->loadRow(array(array($username,PDO::PARAM_STR),array($password,PDO::PARAM_STR)));
		
		return $result;
	}
    public function getUsers()
    {
        $query= 'SELECT id, username, password,fullname,email,loaiuser  from user';
        $this->setQuery($query);
        $result= $this->loadAllRows();
        return $result;
    }
    public function getUser($id)
    {
        $query='SELECT id, username, password,fullname, email, loaiuser  from user WHERE id=?';
        $this->setQuery($query);
        $result= $this->loadRow(array(
            array($id,PDO::PARAM_INT)
        ));
        return $result;
    }

    public function getUserLimit($start,$limit)
    {
        $query= 'SELECT id, username, password,fullname,loaiuser,  email from user order by id desc LIMIT ?,?';
        $this->setquery($query);
        $result= $this->loadAllRows(array(array($start,PDO::PARAM_INT),array($limit,PDO::PARAM_INT)));
        return $result;
    }
    public function createUser($params)
    {

        $query = 'INSERT INTO user(username, password,fullname, email,loaiuser ) values (?,?,?,?,?)';
        $this->setQuery($query);
        $result= $this->execute(array(
            array($params['username'],PDO::PARAM_STR),
            array($params['password'],PDO::PARAM_STR),
            array($params['fullname'],PDO::PARAM_STR),
            array($params['email'],PDO::PARAM_STR),
            array($params['loaiuser'],PDO::PARAM_STR)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function updateUser($params)
    {
        $query = 'UPDATE user SET username=?,password=?,fullname=?, email=?,loaiuser=? WHERE id=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($params['username'],PDO::PARAM_STR),
            array($params['password'],PDO::PARAM_STR),
            array($params['fullname'],PDO::PARAM_STR),
            array($params['email'],PDO::PARAM_STR),
            array($params['loaiuser'],PDO::PARAM_STR),
            array($params['id'],PDO::PARAM_INT)

        ));
        if(!$result){
            return false;
        }
        return true;
    }

    public function checkUsernameCreate($name)
    {
        $query='SELECT * FROM USER WHERE username=?';
        $this->setQuery($query);
        $result=$this->loadRow(array(
            array($name,PDO::PARAM_STR)
        ));

       if(!$result)
        {
            return false;
        }
        return true;
    }

    public function checkEmailCreate($email)
    {
        $query='SELECT * FROM USER WHERE email=?';
        $this->setQuery($query);
        $result=$this->loadRow(array(
            array($email,PDO::PARAM_STR)
        ));

        if(!$result)
        {
            return false;
        }
        return true;
    }


    public function checkUsernameUpdate($username, $id)
    {
        $query='SELECT * FROM USER WHERE username=? AND id<>?';
        $this->setQuery($query);
        $result=$this->loadRow(array(
            array($username,PDO::PARAM_STR),
            array($id,PDO::PARAM_INT)
        ));

        if(!$result)
        {
            return false;
        }
        return true;
    }

    public function checkEmailUpdate($email, $id)
    {
        $query='SELECT * FROM USER WHERE email=? AND id<>?';
        $this->setQuery($query);
        $result=$this->loadRow(array(
            array($email,PDO::PARAM_STR),
            array($id,PDO::PARAM_INT)
        ));

        if(!$result)
        {
            return false;
        }
        return true;
    }


    public function deleteUser($id)
    {
        $queryGroupCustomer = 'SELECT idNhomKH FROM nhomkhachhang WHERE idUser=?';
        $this->setQuery($queryGroupCustomer);
        $groupCustomers = $this->loadAllRows(array(
            array($id,PDO::PARAM_INT)
        ));
        foreach($groupCustomers as $itemGroup) {
            $queryDeleteCustomer = 'DELETE FROM khachhang WHERE idNhomKH=?';
            $this->setQuery($queryDeleteCustomer);
            $resultCustomer = $this->execute(array(
                array($itemGroup->idNhomKH,PDO::PARAM_INT)
            ));

            $queryDeleteGroup = 'DELETE FROM nhomkhachhang WHERE idNhomKH=?';
            $this->setQuery($queryDeleteGroup);
            $resultGroup = $this->execute(array(
                array($itemGroup->idNhomKH,PDO::PARAM_INT)
            ));
        }

        $queryOrder = 'DELETE FROM donhang WHERE idUser=? ';
        $this->setQuery($queryOrder);
        $resultOrder = $this->execute(array(
            array($id,PDO::PARAM_INT)
        ));

        $query='DELETE FROM user WHERE id=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($id,PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }

}