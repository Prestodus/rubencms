<?php

class admin_userController extends Base_Controller {
	
	public function loginAction() {
		if (!Default_Login::checklogin('admin', false)) {
			$this->view->title = "Login - Admin - Floris Thijs";
			
			if ($this->postVar('password') && $this->postVar('email')) {
				$error = false;
				try {
			 		$login = new Default_Login();
			 		$login->login($this->postVar('email'), $this->postVar('password'), 'admin');
			 		$this->redirect('admin');
				} catch (Exception $e) {
					if ($e->getMessage() == 'error_login_user') $error = 'Dit account bestaat niet.';
					else if ($e->getMessage() == 'error_login_password') $error = 'Je hebt een foutief wachtwoord ingegeven.';
					else $error = 'Er is een onvoorziene fout opgetreden.';
				}
				$admin = new Default_Session('admin_user');
				$this->view->postVars = $this->postVars();
				$this->view->error = $error;
			}
		} else {
			$this->redirect('admin');
		}
		
	}
	
	public function logoutAction() {
		Default_Login::logout('admin');
	}
	
	public function profileAction() {
		Default_Login::checklogin('admin');
	}
	
	public function profile_editAction() {
		
	}
	
}