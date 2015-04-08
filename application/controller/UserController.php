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
       $limit= isset($_REQUEST['limit'])? $_REQUEST['limit'] : 5;
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
        $this->template->fetch('user/index.tpl');
    }
    public function indexAjaxAction()
    {
        $limit= isset($_REQUEST['limit'])? $_REQUEST['limit'] : 5;
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
        return json_encode($result);
        exit();
    }
	
	
}