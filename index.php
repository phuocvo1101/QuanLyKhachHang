<?php
session_start();
define('PATH_SERVERNAME','http://'.$_SERVER['SERVER_NAME'].'/');
define('PATH_SERVER',$_SERVER['DOCUMENT_ROOT'].'/');
define('PATH_CONFIG',PATH_SERVER.'configs/');
define('PATH_LIBRARY',PATH_SERVER.'library/');
define('PATH_APPLICATION',PATH_SERVER.'application/');
define('PATH_CACHE',PATH_SERVER.'cache/');
define('PATH_CONTROLLER',PATH_APPLICATION.'controller/');
define('PATH_MODEL',PATH_APPLICATION.'model/');
define('PATH_VIEW',PATH_APPLICATION.'view/templates/');
define('PATH_CSS',PATH_SERVERNAME.'application/css/');
define('PATH_JS',PATH_SERVERNAME.'application/view/js/');
define('PATH_IMAGES',PATH_SERVERNAME.'application/images/');

include_once (PATH_CONFIG.'database.php');
include_once (PATH_LIBRARY.'Database.php');
include_once (PATH_CONFIG.'smarty.php');

$template->assign('PATH_CSS',PATH_CSS);
$template->assign('PATH_JS',PATH_JS);
$template->assign('PATH_IMAGES',PATH_IMAGES);

if(isset($_SESSION['loaiuser'])){
    $template->assign('loaiuser',$_SESSION['loaiuser']);
}

if(isset($_SESSION['username'])){
    $template->assign('username1',$_SESSION['username']);
}

if(isset($_SESSION['userid'])){
    $template->assign('userid',$_SESSION['userid']);
}

include_once (PATH_CONFIG.'controller.php');

include_once (PATH_CONFIG.'router.php');
//$template->assign('loaiuser',$_SESSION['loaiuser']);