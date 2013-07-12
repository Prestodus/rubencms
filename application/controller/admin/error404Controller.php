<?php

class admin_error404Controller extends Base_Controller {
	
	public function error404Action() {
		
		$this->view->title = "Error 404";
		
		return $this;
		
	}
	
}