<?php
include_once(PATH_APPLICATION.'controller/IController.php');

abstract class BaseController implements IController
{
	protected $template;
	public function BaseController()
	{
		global $template;
		$this->template = $template;
		// checkLogin
		if(!isset($_SESSION['userid']) && isset($_GET['controller']) && $_GET['controller']!='user' && 
		isset($_GET['action']) && $_GET['action']!='login'  ) {
			header('location:index.php?controller=user&action=login');
		} 
	}
	public   function indexAction()
	{
	}
	public   function indexAjaxAction()
	{
	}
	public   function viewAction()
	{
	}
	public   function viewAjaxAction()
	{
	}
	public   function createAction()
	{
	}
	public   function createAjaxAction()
	{
	}
	public   function deleteAction()
	{
	}
	public   function deleteAjaxAction()
	{
	}
	public   function updateAction()
	{
	}
	public   function updateAjaxAction()
	{
	}
}