<?php

class admin_priceController extends Base_Controller {
	
	public function indexAction() {
		Default_Login::checklogin('admin');
		
		$this->view->title = "Admin - Floris Thijs";
		
		
	}
	
	public function newAction() {
		Default_Login::checklogin('admin');
		
		$this->view->title = "Admin - Floris Thijs";
		
		$subcategories_proxy = new Default_Admin_Price_Subcategories_Proxy();
		$subcategories = $this->view->subcategories = $subcategories_proxy->getAll();
		
		if ($this->postVars()) {
			
		}
	}
	
}