<?php

class admin_indexController extends Base_Controller {
	
	public function indexAction() {
		Default_Login::checklogin('admin');
		
		$this->view->title = "Admin - Floris Thijs";
		
		$this->addStyleSheet('test1')
			->addStyleSheet('test2 prepend', 'prepend')
			->addStyleSheet('test3 append', 'append');
	}
	
}