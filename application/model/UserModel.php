<?php
class UserModel extends Database
{

	public function checkLogin($username,$password)
	{
		$password = md5($password);
	
		$query = 'SELECT username,password,id,email,fullname FROM user WHERE username=? and password=?';
		$this->setQuery($query);
		$result = $this->loadRow(array(array($username,PDO::PARAM_STR),array($password,PDO::PARAM_STR)));
		
		return $result;
	}
    public function getUsers()
    {
        $query= 'SELECT id, username, password,fullname, email from user';
        $this->setQuery($query);
        $result= $this->loadAllRows();
        return $result;
    }
    public function getUser($id)
    {
        $query='SELECT id, username, password,fullname, email from user WHERE id=?';
        $this->setQuery($query);
        $result= $this->loadRow(array(
            array($id,PDO::PARAM_INT)
        ));
        return $result;
    }

    public function getUserLimit($start,$limit)
    {
        $query= 'SELECT id, username, password,fullname, email from user order by id LIMIT ?,?';
        $this->setquery($query);
        $result= $this->loadAllRows(array(array($start,PDO::PARAM_INT),array($limit,PDO::PARAM_INT)));
        return $result;
    }
    public function createUser($params)
    {

        $query = 'INSERT INTO user(username, password,fullname, email) values (?,?,?,?)';
        $this->setQuery($query);
        $result= $this->execute(array(
            array($params['username'],PDO::PARAM_STR),
            array($params['password'],PDO::PARAM_STR),
            array($params['fullname'],PDO::PARAM_STR),
            array($params['email'],PDO::PARAM_STR)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function updateUser($params)
    {
        $query = 'UPDATE user SET username=?, password=?,fullname=?, email=? WHERE id=?';
        $this->setQuery($query);
        $result = $this->execute(array(
            array($params['username'],PDO::PARAM_STR),
            array($params['password'],PDO::PARAM_STR),
            array($params['fullname'],PDO::PARAM_STR),
            array($params['email'],PDO::PARAM_STR),
            array($params['id'],PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
    public function deleteUser($id)
    {
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