<?php
include_once (PATH_LIBRARY.'Pager.php');
include_once (PATH_MODEL.'GroupModel.php');
class GroupController extends BaseController
{
    private $groupModel;
    public function GroupController()
    {
        $this->groupModel = new GroupModel();
        parent::BaseController();
    }
    public function indexAction()
    {
        $limit= isset($_REQUEST['limit'])? $_REQUEST['limit']: 2;
        $groups= $this->groupModel->getGroups();
        $totalRecord = count($groups);
        $pagination = new Pagination($limit);
        $start = (int)$pagination->start();
        $limit= (int)$pagination->limit;
        $totalPages= $pagination->totalPages($totalRecord);

        $groups1 = $this->groupModel->getGroupLimit($start,$limit);

        $listPages= $pagination->listPages($totalPages);

        $this->template->assign('groups',$groups1);
        $this->template->assign('listPages',$listPages);
        return $this->template->fetch('group/index.tpl');
    }
    public function indexAjaxAction()
    {

        $limit= isset($_REQUEST['limit'])? $_REQUEST['limit']: 2;
        $groups= $this->groupModel->getGroups();
        $totalRecord = count($groups);
        $pagination = new Pagination($limit);
        $start = (int)$pagination->start();
        $limit= (int)$pagination->limit;
        $totalPages= $pagination->totalPages($totalRecord);

        $groups1 = $this->groupModel->getGroupLimit($start,$limit);

        $listPages= $pagination->listPages($totalPages);

        $this->template->assign('groups',$groups1);
        $this->template->assign('listPages',$listPages);

        $data= $this->template->fetch('group/dataindex.tpl');
        $phantrang = $this->template->fetch('group/listpageindex.tpl');

        $result = array("data"=>$data,"phantrang"=>$phantrang);

        echo json_encode($result);
        exit();

    }
    public function createAction()
    {
        $users = $this->groupModel->getUsers();
        $this->template->assign('users',$users);
        if(!isset($_POST['submitCreate'])){
           return $this->template->fetch('group/create.tpl');
        }
        $groupname= isset($_POST['groupname'])? $_POST['groupname']:'';
        $decription= isset($_POST['decription'])?$_POST['decription']:'';
        $iduser= isset($_POST['iduser'])?$_POST['iduser']:0;

        $this->template->assign('groupname',$groupname);
        $this->template->assign('decription',$decription);
        $this->template->assign('iduser',$iduser);

        $arrErorrs = array();

        if($groupname==''){
            $arrErorrs[]='Ban Chua Nhap groupname';
        }
        $checkgroupname= $this->groupModel->checkGroupName($groupname);
        if($checkgroupname){
            $arrErorrs[]= 'groupname da ton tai';
        }
        if($iduser==0){
            $arrErorrs[]='Ban Chua Nhap Username';
        }
        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('group/create.tpl');
        }
        $params['TenNhomKH']=$groupname;
        $params['MoTa']=$decription;
        $params['idUser']= $iduser;

        $result = $this->groupModel->createGroup($params);
        if(!$result){
            $arrErorrs[]='Them Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('group/create.tpl');
        }
        header('location:index.php?controller=group&action=index');
        exit();
    }
    public function updateAction()
    {
        $idNhomKH= isset($_GET['id'])?$_GET['id']:'';
        if(isset($_POST['id'])){
            $idNhomKH= $_POST['id'];

        }
        $group= $this->groupModel->getGroup($idNhomKH);
        $users = $this->groupModel->getUsers();
        $this->template->assign('users',$users);
        if(!isset($_POST['submitUpdate'])){
            $this->template->assign('groupname',$group->TenNHomKH);
            $this->template->assign('decription',$group->MoTa);
            $this->template->assign('idNhomKH',$idNhomKH);
            return $this->template->fetch('group/update.tpl');
        }

        $groupname= isset($_POST['groupname'])?$_POST['groupname']:'';
        $decription=isset($_POST['decription'])?$_POST['decription']:'';
        $iduser= isset($_POST['iduser'])?$_POST['iduser']:0;

        $this->template->assign('groupname',$group->TenNHomKH);
        $this->template->assign('decription',$group->MoTa);
        $this->template->assign('idNhomKH',$idNhomKH);
        $arrErorrs = array();

        if($groupname==''){
            $arrErorrs[]='Ban Chua Nhap groupname';
        }
        $checkgroupname= $this->groupModel->checkGroupNameUpdate($groupname,$idNhomKH);
        if($checkgroupname){
            $arrErorrs[]= 'groupname da ton tai';
        }
        if($iduser==0){
            $arrErorrs[]='Ban Chua Nhap Username';
        }

        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('group/update.tpl');
        }
        $params['TenNhomKH']=$groupname;
        $params['MoTa']=$decription;
        $params['idUser']= $iduser;
        $params['idNhomKH']= $idNhomKH;
        $result = $this->groupModel->updateGroup($params);
        if(!$result){
            $arrErorrs[]='Cap Nhap Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('group/update.tpl');
        }
        header('location:index.php?controller=group&action=index');
        exit();


    }
    public function deleteAction()
    {
        $listid= isset($_GET['listid'])?$_GET['listid']:'';
        if($listid==''){
            header('location:index.php?controller=group&action=index');
            exit();
        }

        $arrList= explode(',',$listid);

        foreach($arrList as $item){
           $this->groupModel->deleteGroup($item);
        }
        header('location:index.php?controller=group&action=index');
        exit();

    }
}