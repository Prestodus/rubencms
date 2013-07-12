<?php

class Base_Functions {
	
	public $stylesheets = array();
	
	function addStyleSheet($href, $position = "append") {
		if ($position == "append") {
			$this->stylesheets[] = $href;
		} else if ($position == "prepend") {
			array_unshift($this->stylesheets, $href);
		} else {
			$this->stylesheets[] = $href;
		}
		return $this;
	}
	
	function renderStyleSheets() {
		$return = "";
		foreach ($this->stylesheets as $sheet) {
			$return .= '
			
			<link rel="stylesheet" type="text/css" href="'.$sheet.'" />';
		}
		return $return;
	}
	
	function createUrl($module = 'front', $controller = 'index', $action = 'index', array $vars = array()) {
		
		$url = '/'.$module.'/'.$controller.'/'.$action.'/';
		foreach ($vars as $key => $value) {
			$url .= $key.'/'.$value.'/';
		}
		return $url;
		
	}
	
	public static function redirect($module = 'front', $controller = 'index', $action = 'index', array $vars = array()) {
		
		$url = '/'.$module.'/'.$controller.'/'.$action.'/';
		foreach ($vars as $key => $value) {
			$url .= $key.'/'.$value.'/';
		}
		header('Location: '.$url);
		exit;
		
	}
	
	public function getUser($type = 'admin') {
		$login = new Default_Login();
		if ($type == 'admin') {
			if ($login->checklogin('admin', false)) {
				$users_proxy = new Default_Admin_Users_Proxy();
				$session = new Default_Session('admin_user');
				$user = $users_proxy->getById($session->get('id'));
				return $user;
			} else
				return false;
	 	} else {
			if ($login->checklogin('front', false)) {
				$users_proxy = new Default_Front_Users_Proxy();
				$session = new Default_Session('front_user');
				$user = $users_proxy->getById($session->get('id'));
				return $user;
			} else
				return false;
	 	}
	}
	
}