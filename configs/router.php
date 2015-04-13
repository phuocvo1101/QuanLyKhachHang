<?php
$layout="index.tpl";
$basecontroller = null;
$content = "";

    if(isset($_GET["controller"]) && isset($_GET['action'])) {

		switch($_GET["controller"]) {
			case "customer":
				$basecontroller = new CustomerController();
				break;
			case "user":
				$basecontroller = new UserController();
				break;
            case "group":
                $basecontroller = new GroupController();
                break;
            case "product":
                $basecontroller = new ProductController();
                break;
            case "order":
                $basecontroller = new OrderController();
                break;
			default:
				$basecontroller = new CustomerController();
				break;	
		}
		switch(strtolower($_GET['action'])) {
			case 'index':
				$content = $basecontroller->indexAction();
				break;
			case 'indexajax':
				$content = $basecontroller->indexAjaxAction();
				break;
            case 'indexthanhvien':
                $content = $basecontroller->indexActionThanhVien();
                break;
			case 'view':
				$content = $basecontroller->viewAction();
				break;
			case 'viewajax':
				$content = $basecontroller->viewAjaxAction();
				break;
			case 'create':
				$content = $basecontroller->createAction();
				break;
			case 'createajax':
				$content =$basecontroller->createAjaxAction();
				break;
			case 'update':
				$content = $basecontroller->updateAction();
				break;
			case 'updateajax':
				$content = $basecontroller->updateAjaxAction();
				break;

           case 'updatethanhvien':
               $content = $basecontroller->updateActionThanhVien();
               break;
			case 'delete':
				$content =$basecontroller->deleteAction();
				break;
			case 'deleteajax':
				$content =$basecontroller->deleteAjaxAction();
				break;
			case 'login':
				$layout="login.tpl";
				$content =$basecontroller->loginAction();
				break;
			case 'logout':
				$layout="login.tpl";
				$content =$basecontroller->logoutAction();
				break;
			default:
				$content =$basecontroller->indexAction();
				
				break;
		}	
	} else {
        $_GET['controller'] = 'customer';
        $_GET['action'] = 'index';
		$basecontroller = new CustomerController();
		$content = $basecontroller->indexAction();
	}	

$template->assign('content',$content);
$template->display($layout);