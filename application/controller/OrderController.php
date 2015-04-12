<?php
include_once (PATH_MODEL.'OrderModel.php');
include_once (PATH_LIBRARY.'Pager.php');
class OrderController extends BaseController
{
    private $OrderModel;
    public function OrderController()
    {
        $this->OrderModel= new OrderModel();
        parent::BaseController();
    }
    public function indexAction()
    {
        $limit= isset($_GET['limit'])?$_GET['limit']:3;
        $orders= $this->OrderModel->getOrders();
        $totalRecord= count($orders);
        $pagenation = new Pagination($limit);
        $start=(int)$pagenation->start();
        $limit=(int)$pagenation->limit;
        $totalPages= $pagenation->totalPages($totalRecord);
        $listPages= $pagenation->listPages($totalPages);

        $orders1= $this->OrderModel->getOrdersLimit($start,$limit);
        $this->template->assign('orders',$orders1);
        $this->template->assign('listPages',$listPages);
        return $this->template->fetch('order/index.tpl');
    }
    public function indexAjaxAction()
    {
        $limit= isset($_GET['limit'])?$_GET['limit']:3;
        $orders= $this->OrderModel->getOrders();
        $totalRecord= count($orders);
        $pagenation = new Pagination($limit);
        $start=(int)$pagenation->start();
        $limit=(int)$pagenation->limit;
        $totalPages= $pagenation->totalPages($totalRecord);
        $listPages= $pagenation->listPages($totalPages);

        $orders1= $this->OrderModel->getOrdersLimit($start,$limit);
        $this->template->assign('orders',$orders1);
        $this->template->assign('listPages',$listPages);

        $data= $this->template->fetch('order/dataindex.tpl');
        $phantrang= $this->template->fetch('order/listpageindex.tpl');

        $result= array("data"=>$data,"phantrang"=>$phantrang);
        echo json_encode($result);
        exit();
    }
    public function createAction()
    {
        $products=$this->OrderModel->getProducts();
        $customers= $this->OrderModel->getCustomers();
        $users= $this->OrderModel->getUsers();
        $this->template->assign('products',$products);
        $this->template->assign('customers',$customers);
        $this->template->assign('users',$users);
        if(!isset($_POST['submitCreate'])){
            return $this->template->fetch('order/create.tpl');
        }

        $product= isset($_POST['product'])?$_POST['product']:0;
        $soluong= isset($_POST['soluong'])? $_POST['soluong']:0;
        $customer= isset($_POST['customer'])? $_POST['customer']:0;
        $user= isset($_POST['user'])? $_POST['user']:0;

        $this->template->assign('product',$product);
        $this->template->assign('soluong',$soluong);
        $this->template->assign('customer',$customer);
        $this->template->assign('user',$user);

        $arrErorrs = array();

        if($product==0){
            $arrErorrs[]='Ban Chua Nhap product';
        }
        if($soluong==0){
            $arrErorrs[]='Ban Chua Nhap so luong';
        }
        if($customer==0){
            $arrErorrs[]='Ban Chua Nhap Khach Hang';
        }

        if($user==0){
            $arrErorrs[]='Ban Chua Nhap Username';
        }
        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('order/create.tpl');
        }

        $params['idSanPham']=$product;
        $params['SoLuong']=$soluong;
        $params['idKH']=$customer;
        $params['idUser']= $user;

        $result = $this->OrderModel->createOrder($params);
        if(!$result){
            $arrErorrs[]='Them Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('order/create.tpl');
        }
        header('location:index.php?controller=order&action=index');
        exit();
    }
    public function updateAction()
    {
        $idDonHang= isset($_GET['id'])?$_GET['id']:'';
        if(isset($_POST['id'])){
            $idDonHang= $_POST['id'];
        }
        $order= $this->OrderModel->getOrder($idDonHang);
        $products=$this->OrderModel->getProducts();
        $customers= $this->OrderModel->getCustomers();
        $users= $this->OrderModel->getUsers();

        $this->template->assign('products',$products);
        $this->template->assign('customers',$customers);
        $this->template->assign('users',$users);
        if(!isset($_POST['submitUpdate'])){
            $this->template->assign('product',$order->idSanPham);
            $this->template->assign('soluong',$order->SoLuong);
            $this->template->assign('customer',$order->idKH);
            $this->template->assign('user',$order->idUser);
            $this->template->assign('idDonHang',$order->idDonHang);
            return $this->template->fetch('order/update.tpl');
        }

        $product= isset($_POST['product'])?$_POST['product']:0;
        $soluong= isset($_POST['soluong'])? $_POST['soluong']:0;
        $customer= isset($_POST['customer'])? $_POST['customer']:0;
        $user= isset($_POST['user'])? $_POST['user']:0;

        $this->template->assign('product',$product);
        $this->template->assign('soluong',$soluong);
        $this->template->assign('customer',$customer);
        $this->template->assign('user',$user);
        $arrErorrs = array();

        if($product==0){
            $arrErorrs[]='Ban Chua Nhap product';
        }
        if($soluong==0){
            $arrErorrs[]='Ban Chua Nhap so luong';
        }
        if($customer==0){
            $arrErorrs[]='Ban Chua Nhap Khach Hang';
        }

        if($user==0){
            $arrErorrs[]='Ban Chua Nhap Username';
        }
        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('order/update.tpl');
        }

        $params['idSanPham']=$product;
        $params['SoLuong']=$soluong;
        $params['idKH']=$customer;
        $params['idUser']= $user;
        $params['idDonHang']= $idDonHang;
        $result = $this->OrderModel->UpdateOrder($params);
        if(!$result){
            $arrErorrs[]='Cap Nhap Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('order/update.tpl');
        }
        header('location:index.php?controller=order&action=index');
        exit();
    }
    public function deleteAction()
    {
        $listid= isset($_GET['listid'])?$_GET['listid']:'';
        if($listid==''){
            header('location:index.php?controller=order&action=index');
            exit();
        }

        $arrList= explode(',',$listid);

        foreach($arrList as $item){
            $this->OrderModel->DeleteOrder($item);
        }
        header('location:index.php?controller=order&action=index');
        exit();
    }
}
