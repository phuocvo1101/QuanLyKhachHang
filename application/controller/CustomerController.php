<?php
include_once(PATH_MODEL.'CustomerModel.php');
include_once(PATH_LIBRARY.'Pager.php');

class CustomerController extends  BaseController
{
    private $customerModel;
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        parent::BaseController();

    }
	
	public function indexAction()
	{

        $customers = $this->customerModel->getCustomers();

        $limit = isset($_REQUEST['limit']) ?  $_REQUEST['limit'] : 10;

        $Pagination = new Pagination($limit);//,$base_url
        $totalRecord = count($customers); // Tổng số user có trong database
        $totalPages = $Pagination->totalPages($totalRecord); // Tổng số trang tìm được
        $limit = (int)$Pagination->limit; // Số record hiển thị trên một trang
        $stat = (int)$Pagination->start(); // Vị trí của record

        $customers1 = $this->customerModel->getCustomerslimit($stat,$limit);
        $listPage= $Pagination->listPages($totalPages);


        $this->template->assign('customers',$customers1);

            $this->template->assign('listPage',$listPage);


        $this->template->assign('listPage',$listPage);

		return $this->template->fetch('customer/index.tpl');
	}

    public function indexAjaxAction()
    {

        $search = isset($_POST['search'])?$_POST['search']:'';
        $customers = $this->customerModel->getCustomers($search);
        $limit = isset($_REQUEST['limit']) ?  $_REQUEST['limit'] : 10;

        $Pagination = new Pagination($limit);//,$base_url
        $totalRecord = count($customers); // Tổng số user có trong database
        $totalPages = $Pagination->totalPages($totalRecord); // Tổng số trang tìm được
        $limit = (int)$Pagination->limit; // Số record hiển thị trên một trang
        $stat = (int)$Pagination->start(); // Vị trí của record

        $customers1 = $this->customerModel->getCustomerslimit($stat,$limit,$search);
        $listPage= $Pagination->listPages($totalPages);

        $this->template->assign('customers',$customers1);
        $data = $this->template->fetch('customer/dataindex.tpl');

        $this->template->assign('listPage',$listPage);
        if($listPage==''){
            $phantrang='';
        }else{
            $phantrang = $this->template->fetch('customer/listpageindex.tpl');
        }


        $result = array('data'=>$data,'phantrang'=>$phantrang);

        $strResult = json_encode($result);

        echo $strResult;
        exit();
    }

    public function createAction()
    {
       $districts = $this->customerModel->getDistricts();
        $this->template->assign('districts',$districts);
        $nhomKHs = $this->customerModel->getNhomKhachHang();
        $this->template->assign('nhomKHs',$nhomKHs);
        if(!isset($_POST['submitCreate'])) {

            return $this->template->fetch('customer/create.tpl');
        }

        $customername =  isset($_POST['customername']) ? $_POST['customername'] : '';
        $sex =  isset($_POST['sex']) && $_POST['sex']=='on'? 1 : 0;
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : 0;
        $nhomKH = isset($_POST['nhomKH']) ? $_POST['nhomKH'] : 0;

        $this->template->assign('customername',$customername);
        $this->template->assign('sex',$sex);
        $this->template->assign('email',$email);
        $this->template->assign('address',$address);
        $this->template->assign('phonenumber',$phonenumber);
        $this->template->assign('district',$district);
        $this->template->assign('nhomKH',$nhomKH);
        $arrError = array();
        if($customername=='') {
            $arrError[] = 'Bạn chưa nhập username';
        }

        if($email=='') {
            $arrError[] = 'Bạn chưa nhập email';
        }

        if($address=='') {
            $arrError[] = 'Bạn chưa nhập địa chỉ';
        }

        if($phonenumber=='') {
            $arrError[] = 'Bạn chưa nhập số điện thoại';
        }

        if($district==0) {
            $arrError[] = 'Bạn chưa chọn quận/huyện';

        }
        if($nhomKH==0) {
            $arrError[] = 'Bạn chưa chọn Nhóm Khách Hàng';
        }
        if(!empty($arrError)) {
            $this->template->assign('errors',$arrError);
            return $this->template->fetch('customer/create.tpl');
        }

        // create one customer

        $params['TenKH'] = $customername;
        $params['Phai'] = $sex;
        $params['DiaChi'] = $address;
        $params['DienThoai'] = $phonenumber;
        $params['Email'] = $email;
        $params['idQuanHuyen'] = $district;
        $params['idNhomKH']= $nhomKH;

        $result = $this->customerModel->creatCustomer($params);
        if(!result) {
            $arrError[] = 'Thêm khách hàng không thành công';
            $this->template->assign('errors',$arrError);
            return $this->template->fetch('customer/create.tpl');
        }

        header('location:index.php?controller=customer&action=index');
        exit();

    }

    public function updateAction()
    {

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        $customer = $this->customerModel->getCustomer($id);
        if($customer==null) {
            header('location:index.php?controller=customer&action=index');
            return;
        }
        $districts = $this->customerModel->getDistricts();
        $this->template->assign('districts',$districts);

        $nhomKHs = $this->customerModel->getNhomKhachHang();
        $this->template->assign('nhomKHs',$nhomKHs);

        if(!isset($_POST['submitUpdate'])) {
            $this->template->assign('id',$id);
            $this->template->assign('customername',$customer->TenKH);
            $this->template->assign('sex',$customer->Phai);
            $this->template->assign('email',$customer->Email);
            $this->template->assign('address',$customer->DiaChi);
            $this->template->assign('phonenumber',$customer->DienThoai);
            $this->template->assign('district',$customer->idQuanHuyen);
            return $this->template->fetch('customer/update.tpl');
        }

        $customername =  isset($_POST['customername']) ? $_POST['customername'] : '';
        $sex =  isset($_POST['sex']) && $_POST['sex']=='on'? 1 : 0;
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
        $district = isset($_POST['district']) ? $_POST['district'] : 0;
        $nhomKH = isset($_POST['nhomKH']) ? $_POST['nhomKH'] : 0;

        $this->template->assign('customername',$customername);
        $this->template->assign('sex',$sex);
        $this->template->assign('email',$email);
        $this->template->assign('address',$address);
        $this->template->assign('phonenumber',$phonenumber);
        $this->template->assign('district',$district);
        $this->template->assign('nhomKH',$nhomKH);

        $arrError = array();
        if($customername=='') {
            $arrError[] = 'Bạn chưa nhập username';
        }

        if($email=='') {
            $arrError[] = 'Bạn chưa nhập email';
        }

        if($address=='') {
            $arrError[] = 'Bạn chưa nhập địa chỉ';
        }

        if($phonenumber=='') {
            $arrError[] = 'Bạn chưa nhập số điện thoại';
        }

        if($district==0) {
            $arrError[] = 'Bạn chưa chọn quận/huyện';
        }
        if($nhomKH==0) {
            $arrError[] = 'Bạn chưa chọn Nhóm Khách Hàng';
        }

        if(!empty($arrError)) {
            $this->template->assign('errors',$arrError);
            return $this->template->fetch('customer/create.tpl');
        }

        // create one customer

        $params['TenKH'] = $customername;
        $params['Phai'] = $sex;
        $params['DiaChi'] = $address;
        $params['DienThoai'] = $phonenumber;
        $params['Email'] = $email;
        $params['idQuanHuyen'] = $district;
        $params['idKH'] = $id;
        $params['idNhomKH']= $nhomKH;

        $result = $this->customerModel->updateCustomer($params);
        if(!result) {
            $arrError[] = 'Cập nhật khách hàng không thành công';
            $this->template->assign('errors',$arrError);
            return $this->template->fetch('customer/update.tpl');
        }

        header('location:index.php?controller=customer&action=index');
        exit();
    }

    public function deleteAction()
    {
        $listId = isset($_REQUEST['listid']) ? $_REQUEST['listid'] : '';
        if($listId=='') {
            header('location:index.php?controller=customer&action=index');
            return;
        }

        $arrID = explode(',',$listId);

        foreach($arrID as $item) {
            $this->customerModel->deleteCustomer($item);
        }
        header('location:index.php?controller=customer&action=index');
        return;
    }

	public function viewAction() 
	{
		return $this->template->fetch('customer/view.tpl');
	}
}