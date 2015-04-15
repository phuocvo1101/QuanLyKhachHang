<?php
include_once (PATH_LIBRARY.'Pager.php');
include_once (PATH_MODEL.'ProductModel.php');
class ProductController extends BaseController
{
    private $productModel;
    public function ProductController()
    {
        $this->productModel= new ProductModel();
        parent::BaseController();
    }
    public function indexAction()
    {
        $limit= isset($_REQUEST['limit'])? $_REQUEST['limit']: 4;
        $products= $this->productModel->getProducts();
        $totalRecord = count($products);
        $pagination = new Pagination($limit);
        $start = (int)$pagination->start();
        $limit= (int)$pagination->limit;
        $totalPages= $pagination->totalPages($totalRecord);

        $products1 = $this->productModel->getProductLimit($start,$limit);

        $listPages= $pagination->listPages($totalPages);

        $this->template->assign('products',$products1);
        $this->template->assign('listPages',$listPages);
        return $this->template->fetch('product/index.tpl');
    }
    public function indexAjaxAction()
    {

        $search= isset($_POST['search'])? $_POST['search']:'';
        $limit= isset($_REQUEST['limit'])? $_REQUEST['limit']: 4;
        $products= $this->productModel->getProducts($search);
        $totalRecord = count($products);
        $pagination = new Pagination($limit);
        $start = (int)$pagination->start();
        $limit= (int)$pagination->limit;
        $totalPages= $pagination->totalPages($totalRecord);

        $products1 = $this->productModel->getProductLimit($start,$limit,$search);

        $listPages= $pagination->listPages($totalPages);

        $this->template->assign('products',$products1);
        $this->template->assign('listPages',$listPages);

        $data= $this->template->fetch('product/dataindex.tpl');
        if($listPages==''){
            $phantrang='';
        }else{
            $phantrang = $this->template->fetch('product/listpageindex.tpl');
        }
        $result = array("data"=>$data,"phantrang"=>$phantrang);

        echo json_encode($result);
        exit();

    }
    public function createAction()
    {
        if(!isset($_POST['submitCreate'])){
            return $this->template->fetch('product/create.tpl');
        }
        $productname= isset($_POST['productname'])? $_POST['productname']:'';
        $price= isset($_POST['price'])?$_POST['price']:0;

        $this->template->assign('productname',$productname);
        $this->template->assign('price',$price);

        $arrErorrs = array();

        if($productname==''){
            $arrErorrs[]='Ban Chua Nhap Ten San Pham';
        }
        $checkgroupname= $this->productModel->checkProductName($productname);
        if($checkgroupname){
            $arrErorrs[]= 'Ten San Pham da ton tai';
        }
        if($price==0){
            $arrErorrs[]='Ban Chua Nhap Gia San Pham';
        }
        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('product/create.tpl');
        }
        $params['TenSanPham']= $productname;
        $params['GiaSanPham'] = $price;

        $result = $this->productModel->createProduct($params);
        if(!$result){
            $arrErorrs[]='Them Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('product/create.tpl');
        }
        header('location:index.php?controller=product&action=index');
        exit();
    }

    public function updateAction()
    {

        $idSanPham= isset($_GET['id'])?$_GET['id']:'';
        if(isset($_POST['id'])){
            $idSanPham= $_POST['id'];

        }
        $product= $this->productModel->getProduct($idSanPham);
        if(!isset($_POST['submitUpdate'])){
            $this->template->assign('productname',$product->TenSanPham);
            $this->template->assign('price',$product->GiaSanPham);
            $this->template->assign('idSanPham',$idSanPham);
            return $this->template->fetch('product/update.tpl');
        }

        $productname= isset($_POST['productname'])?$_POST['productname']:'';
        $price=isset($_POST['price'])?$_POST['price']:0;

        $this->template->assign('productname',$product->TenSanPham);
        $this->template->assign('price',$product->GiaSanPham);
        $this->template->assign('idSanPham',$idSanPham);
        $arrErorrs = array();

        if($productname==''){
            $arrErorrs[]='Ban Chua Nhap groupname';
        }
        $checkproductname= $this->productModel->checkProductNameUpdate($productname,$idSanPham);
        if($checkproductname){
            $arrErorrs[]= 'Ten San Pham da ton tai';
        }
        if($price==0){
            $arrErorrs[]='Ban Chua Nhap Gia San Pham';
        }

        if(!empty($arrErorrs)){
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('product/update.tpl');
        }
        $price1 = $this->productModel->_toInt($price);
        $params['TenSanPham']= $productname;
        $params['GiaSanPham'] =$price1;
        $params['idSanPham']= $idSanPham;
        $result = $this->productModel->updateProduct($params);
        if(!$result){
            $arrErorrs[]='Cap Nhap Khong Thanh Cong';
            $this->template->assign('errors',$arrErorrs);
            return $this->template->fetch('product/update.tpl');
        }
        header('location:index.php?controller=product&action=index');
        exit();


    }
    public function deleteAction()
    {
        $listid= isset($_GET['listid'])?$_GET['listid']:'';
        if($listid==''){
            header('location:index.php?controller=product&action=index');
            exit();
        }

        $arrList= explode(',',$listid);

        foreach($arrList as $item){
            $this->productModel->deleteProduct($item);
        }
        header('location:index.php?controller=product&action=index');
        exit();

    }
}