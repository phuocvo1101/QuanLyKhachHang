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
        $query= 'SELECT username, password,fullname, email from user';
        $this->setQuery($query);
        $result= $this->loadAllRows();
        return $result;
    }

    public function getUserLimit($start,$limit)
    {
        $query= 'SELECT username, password,fullname, email from user order by id LIMIT ?,?';
        $this->setquery($query);
        $result= $this->loadAllRows(array(array($start,PDO::PARAM_INT),array($limit,PDO::PARAM_INT)));
        return $result;
    }
}