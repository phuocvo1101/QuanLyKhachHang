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
        $_SESSION['loaiuser'] = $result->loaiuser;
        $_SESSION['username'] = $result->username;
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
        $id=$_SESSION['userid'];
        if(!isset($_POST['submitCreate'])){
           return  $this->template->fetch('user/create.tpl');
        }
        $users= $this->userModel->getUsers();
        $username = isset($_POST['username'])? $_POST['username']:'';
        $password = isset($_POST['password'])?$_POST['password']:'';
        $xnpassword = isset($_POST['xnpassword'])?$_POST['xnpassword']:'';
        $email= isset($_POST['email'])?$_POST['email']:'';
        $fullname= isset($_POST['fullname'])?$_POST['fullname']:'';
        $loaiuser= isset($_POST['loaiuser'])?$_POST['loaiuser']:'';

        $this->template->assign('username',$username);
        $this->template->assign('password',$password);
        $this->template->assign('xnpassword',$xnpassword);
        $this->template->assign('email',$email);
        $this->template->assign('fullname',$fullname);
        $this->template->assign('loaiuser',$loaiuser);
        $arrErorrs= array();
        if($username==''){
            $arrErorrs[] ='Ban Chua Nhap username';
        }
        /*foreach($users as $item){
            $username1=$item->username;
            if($username== $username1){
                $arrErorrs[] ='username đã tồn tại';
            }
        }*/
        $checkusername= $this->userModel->checkUsernameCreate($username);
        if($checkusername==true){
            $arrErorrs[] ='username đã tồn tại';
        }
        if($password==''){
            $arrErorrs[] ='Ban Chua Nhap password';
        }
        if($xnpassword==''){
            $arrErorrs[] ='Ban Chua Nhap xác nhận password';
        }
        if($password !=$xnpassword){
            $arrErorrs[] ='Bạn nhập password và xác nhận password không trùng';
        }
        if($email==''){
            $arrErorrs[] ='Ban Chua Nhap email';
        }
       /* foreach($users as $item){
            if($email==$item->email){
                $arrErorrs[] ='email đã tồn tại';
            }
        }*/
        $checkemail= $this->userModel->checkEmailCreate($email);
        if($checkemail==true){
            $arrErorrs[] ='email đã tồn tại';
        }

        if($fullname==''){
            $arrErorrs[] ='Ban Chua Nhap fullname';
        }
        if($loaiuser==''){
            $arrErorrs[] ='Ban Chua Nhap loại user';
        }
        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/create.tpl');
        }

        $params['username']=$username;
        $params['password']=md5($password);
        $params['fullname']=$fullname;
        $params['email']=$email;
        $params['loaiuser']= $loaiuser;

        $result= $this->userModel->createUser($params);

        if(!$result){
            $arrErorrs[]="Them khong thanh cong";
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/create.tpl');
        }
        header('location:index.php?controller=user&action=index');
        exit();
    }
    public function updateActionThanhVien()
    {

        $id=$_SESSION['userid'];
       // $id= isset($_GET['id'])?$_GET['id']:'';
      /* if(isset($_POST['id'])){
            $id=$_POST['id'];
        }*/

        $user= $this->userModel->getUser($id);
        $users = $this->userModel->getUsers();
        if(!$user){
            header('location:index.php?controller=customer&action=index');
            exit();
        }

        if(!isset($_POST['submitUpdate'])){
            $this->template->assign('username',$user->username);
            //$this->template->assign('password',$user->password);
            $this->template->assign('email',$user->email);
            $this->template->assign('fullname',$user->fullname);
            $this->template->assign('id',$user->id);
            $this->template->assign('loaiuser',$user->loaiuser);
            return $this->template->fetch('user/updatethanhvien.tpl');
        }

        $username = isset($_POST['username'])? $_POST['username']:'';
        $password = isset($_POST['password'])?$_POST['password']:'';
        $xnpassword = isset($_POST['xnpassword'])?$_POST['xnpassword']:'';
        $email= isset($_POST['email'])?$_POST['email']:'';
        $fullname= isset($_POST['fullname'])?$_POST['fullname']:'';
        $loaiuser= isset($_POST['loaiuser'])?$_POST['loaiuser']:'';
        $id= isset($_POST['id'])?$_POST['id']:'';

        $this->template->assign('username',$username);
        //$this->template->assign('password',$password);
        $this->template->assign('email',$email);
        $this->template->assign('fullname',$fullname);
        $this->template->assign('loaiuser',$loaiuser);
        $this->template->assign('id',$user->id);

        $arrErorrs= array();
        if($username==''){
            $arrErorrs[] ='Ban Chua Nhap username';
        }
        $checkusername= $this->userModel->checkUsernameUpdate($username,$id);
        if($checkusername==true){
            $arrErorrs[] ='username đã tồn tại';
        }
        if($username!=$user->username)
        {

            foreach($users as $item){
                $username1=$item->username;
                if($username==$username1){
                    $arrErorrs[] ='username đã tồn tại';
                }
            }
        }
        if($password==''){
            $password=$user->password;
            if($xnpassword !=''){
                if($password !=$xnpassword){
                    $arrErorrs[] ='xác nhận password không đúng';
                }
            }
        }else{
            if($xnpassword==''){
                $arrErorrs[]= 'Bạn Chưa Xác Nhận password';
            }
            if($xnpassword!=''){
                if($password !=$xnpassword){
                    $arrErorrs[] ='xác nhận password không đúng';
                }
            }
        }

        if($email==''){
            $arrErorrs[] ='Ban Chua Nhap email';
        }
        $checkemail= $this->userModel->checkEmailUpdate($email,$id);
        if($checkemail==true){
            $arrErorrs[] ='username đã tồn tại';
        }
        /*if($email!=$user->email)
        {
            foreach($users as $item){
                $email1=$item->email;
                if($email==$email1){
                    $arrErorrs[] ='email đã tồn tại';
                }
            }
        }*/

        if($fullname==''){
            $arrErorrs[] ='Ban Chua Nhap fullname';
        }

        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/updatethanhvien.tpl');
        }
        $params['username'] = $username;
        if($password==$user->password){
            $params['password'] =($password);
        }else{
            $params['password'] = md5($password);
        }

        $params['fullname'] = $fullname;
        $params['email'] = $email;
        $params['loaiuser'] = $loaiuser;
        $params['id'] = $id;

        $result= $this->userModel->updateUser($params);
        if(!$result){
            $arrErorrs[]='Cap Nhap Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/updatethanhvien.tpl');
        }

        header('location:index.php?controller=customer&action=index');
        exit();

    }
    public function updateAction()
    {
        $id= isset($_GET['id'])?$_GET['id']:'';
        if(isset($_POST['id'])){
            $id=$_POST['id'];
        }
        $user= $this->userModel->getUser($id);
        //$users = $this->userModel->getUsers();

        if(!$user){
            header('location:index.php?controller=user&action=index');
            exit();
        }

        if(!isset($_POST['submitUpdate'])){
            $this->template->assign('username',$user->username);
            //$this->template->assign('password',$user->password);
            $this->template->assign('email',$user->email);
            $this->template->assign('fullname',$user->fullname);
            $this->template->assign('id',$user->id);
            $this->template->assign('loaiuser',$user->loaiuser);
            return $this->template->fetch('user/update.tpl');
        }

        $username = isset($_POST['username'])? $_POST['username']:'';
        $password = isset($_POST['password'])?$_POST['password']:'';
        $xnpassword = isset($_POST['xnpassword'])?$_POST['xnpassword']:'';
        $email= isset($_POST['email'])?$_POST['email']:'';
        $fullname= isset($_POST['fullname'])?$_POST['fullname']:'';
        $loaiuser= isset($_POST['loaiuser'])?$_POST['loaiuser']:'';
        $id= isset($_POST['id'])?$_POST['id']:'';

        $this->template->assign('username',$username);
        //$this->template->assign('password',$password);
        $this->template->assign('email',$email);
        $this->template->assign('fullname',$fullname);
        $this->template->assign('loaiuser',$loaiuser);
        $this->template->assign('id',$user->id);

        $arrErorrs= array();
        if($username==''){
            $arrErorrs[] ='Ban Chua Nhap username';
        }
       /* if($username!=$user->username)
        {

            foreach($users as $item){
                $username1=$item->username;
                if($username==$username1){
                    $arrErorrs[] ='username đã tồn tại';
                }
            }
        }*/
        $checkusername= $this->userModel->checkUsernameUpdate($username,$id);
        if($checkusername==true){
            $arrErorrs[] ='username đã tồn tại';
        }
        if($password==''){
            $password=$user->password;
            if($xnpassword !=''){
                if($password !=$xnpassword){
                    $arrErorrs[] ='xác nhận password không đúng';
                }
            }
        }else{
            if($xnpassword==''){
                $arrErorrs[]= 'Bạn Chưa Xác Nhận password';
            }
            if($xnpassword!=''){
                if($password !=$xnpassword){
                    $arrErorrs[] ='xác nhận password không đúng';
                }
            }
        }

        if($email==''){
            $arrErorrs[] ='Ban Chua Nhap email';
        }
        $checkemail= $this->userModel->checkEmailUpdate($email,$id);
        if($checkemail==true){
            $arrErorrs[] ='username đã tồn tại';
        }
        /*if($email!=$user->email)
        {
            foreach($users as $item){
                $email1=$item->email;
                if($email==$email1){
                    $arrErorrs[] ='email đã tồn tại';
                }
            }
        }*/

        if($fullname==''){
            $arrErorrs[] ='Ban Chua Nhap fullname';
        }

        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('user/update.tpl');
        }
        $params['username'] = $username;
        if($password==$user->password){
            $params['password'] =($password);
        }else{
            $params['password'] = md5($password);
        }

        $params['fullname'] = $fullname;
        $params['email'] = $email;
        $params['loaiuser'] = $loaiuser;
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
            $this->userModel->deleteUser($item);
        }
        header('location:index.php?controller=user&action=index');
        return;

    }
	
	
}