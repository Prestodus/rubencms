<?php

class admin_headadminController extends Base_Controller {
	
	public function aclAction() {
		Default_Login::checklogin('admin');
		
		$this->view->title = "Admin - Floris Thijs";
	}
	
	public function acl_usersAction() {
		Default_Login::checklogin('admin');
		
		$this->view->title = "Admin - Floris Thijs";
		
		$admins_proxy = new Default_Admin_Users_Proxy();
		$this->view->admins = $admins_proxy->getAll();
	}
	
	public function acl_rolesAction() {
		Default_Login::checklogin('admin');
		
		$this->view->title = "Admin - Floris Thijs";
		
		$roles_proxy = new Default_Admin_Acl_Roles_Proxy();
		$this->view->roles = $roles_proxy->getAll();
		
		$permissions_proxy = new Default_Admin_Acl_Permissions_Proxy();
		$this->view->permissions = $permissions_proxy->getAll();
	}
	
}