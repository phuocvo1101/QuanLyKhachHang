<?php
include_once(PATH_MODEL.'UserModel.php');
include_once(PATH_LIBRARY.'Pager.php');

class UserController extends  BaseController
{
	private $userModel;
	public function __construct()
	{	
		$this->userModel = new UserModel();
		parent::BaseController();
	
	}
	public function loginAction()
	{
		if(isset($_SESSION['userid'])) {
			header('location:index.php?controller=customer&action=index');
			exit();
		}
		if(!isset($_POST['submitLogin'])) {
			return $this->template->fetch('user/login.tpl');
		}
		
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$result = $this->userModel->checkLogin($username, $password);
		
		if(!isset($result->id)) {
			$this->template->assign('errorMessage', "UserName hoặc password không đúng");
			return $this->template->fetch('user/login.tpl');
		}
		$_SESSION['userid'] = $result->id;
		header('location:index.php?controller=customer&action=index');
		exit();
	}
	
	public function logoutAction()
	{
		session_destroy();
		header('location:index.php?controller=user&action=login');
	}

    public function indexAction()
    {
       $limit= isset($_REQUEST['limit'])? $_REQUEST['limit'] : 4;
        $users= $this->userModel->getUsers();
       $pagernation = new Pagination($limit);
        $start=(int) $pagernation->start();
        $limit=(int)$pagernation->limit;
        $totalRecord= count($users);
        $totalPages = $pagernation->totalPages($totalRecord);

       $listPages= $pagernation->listPages($totalPages);
        $users1= $this->userModel->getUserLimit($start,$limit);

        $this->template->assign('listPages',$listPages);
        $this->template->assign('users',$users1);
        return $this->template->fetch('user/index.tpl');
    }
    public function indexAjaxAction()
    {
        $limit= isset($_REQUEST['limit'])? $_REQUEST['limit'] : 4;
        $users= $this->userModel->getUsers();
        $pagernation = new Pagination($limit);
        $start=(int) $pagernation->start();
        $limit=(int)$pagernation->limit;
        $totalRecord= count($users);
        $totalPages = $pagernation->totalPages($totalRecord);

        $listPages= $pagernation->listPages($totalPages);
        $users1= $this->userModel->getUserLimit($start,$limit);

        $this->template->assign('listPages',$listPages);
        $phantrang = $this->template->fetch('user/listpageindex.tpl');
        $this->template->assign('users',$users1);
        $data = $this->template->fetch('user/dataindex.tpl');

        $result= array('data'=>$data,'phantrang'=>$phantrang);
        echo json_encode($result);
        exit();
    }
    public function createAction()
    {
        if(!isset($_POST['submitCreate'])){
           return  $this->template->fetch('user/create.tpl');
        }
        $username = isset($_POST['username'])? $_POST['username']:'';
        $password = isset($_POST['password'])?$_POST['password']:'';
        $email= isset($_POST['email'])?$_POST['email']:'';
        $fullname= isset($_POST['fullname'])?$_POST['fullname']:'';

        $this->template->assign('username',$username);
        $this->template->assign('password',$password);
        $this->template->assign('email',$email);
        $this->template->assign('fullname',$fullname);
        $arrErorrs= array();
        if($username==''){
            $arrErorrs[] ='Ban Chua Nhap username';
        }
        if($password==''){
            $arrErorrs[] ='Ban Chua Nhap password';
        }
        if($email==''){
            $arrErorrs[] ='Ban Chua Nhap email';
        }
        if($fullname==''){
            $arrErorrs[] ='Ban Chua Nhap fullname';
        }
        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/create.tpl');
        }

        $params['username']=$username;
        $params['password']=md5($password);
        $params['fullname']=$fullname;
        $params['email']=$email;

        $result= $this->userModel->createUser($params);

        if(!$result){
            $arrErorrs[]="Them khong thanh cong";
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/create.tpl');
        }
        header('location:index.php?controller=user&action=index');
        exit();
    }
    public function updateAction()
    {
        $id= isset($_GET['id'])?$_GET['id']:'';
        if(isset($_POST['id'])){
            $id=$_POST['id'];
        }
        $users= $this->userModel->getUser($id);
        if(!$users){
            header('location:index.php?controller=user&action=index');
            exit();
        }

        if(!isset($_POST['submitUpdate'])){
            $this->template->assign('username',$users->username);
            $this->template->assign('password',$users->password);
            $this->template->assign('email',$users->email);
            $this->template->assign('fullname',$users->fullname);
            $this->template->assign('id',$users->id);
            return $this->template->fetch('user/update.tpl');
        }

        $username = isset($_POST['username'])? $_POST['username']:'';
        $password = isset($_POST['password'])?$_POST['password']:'';
        $email= isset($_POST['email'])?$_POST['email']:'';
        $fullname= isset($_POST['fullname'])?$_POST['fullname']:'';
        $id= isset($_POST['id'])?$_POST['id']:'';

        $this->template->assign('username',$username);
        $this->template->assign('password',$password);
        $this->template->assign('email',$email);
        $this->template->assign('fullname',$fullname);
        $this->template->assign('id',$users->id);

        $arrErorrs= array();
        if($username==''){
            $arrErorrs[] ='Ban Chua Nhap username';
        }
        if($password==''){
            $arrErorrs[] ='Ban Chua Nhap password';
        }
        if($email==''){
            $arrErorrs[] ='Ban Chua Nhap email';
        }
        if($fullname==''){
            $arrErorrs[] ='Ban Chua Nhap fullname';
        }
        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/update.tpl');
        }
        $params['username'] = $username;
        if($password==$users->password){
            $params['password'] =($password);
        }else{
            $params['password'] = md5($password);
        }

        $params['fullname'] = $fullname;
        $params['email'] = $email;
        $params['id'] = $id;
        $result= $this->userModel->updateUser($params);
        if(!$result){
            $arrErorrs[]='Cap Nhap Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/update.tpl');
        }
        header('location:index.php?controller=user&action=index');
        exit();

    }
    public function deleteAction()
    {
        $listid= isset($_GET['listid'])?$_GET['listid']:'';
        $arrListid= explode(',',$listid);
        foreach($arrListid as $item){
            $result= $this->userModel->deleteUser($item);
        }
        header('location:index.php?controller=user&action=index');
        return;

    }
	
	
}