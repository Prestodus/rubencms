<?php

include_once(ROOT_PATH.'/library/config.php');

class bootstrap {
	
	public $config;
	public $getVars;
	public $postVars;
	
	public function __construct() {
		$this->config = config::getConfig();
		$this->getVars()->postVars();
	}

	public function getVars() {
		$request = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
		foreach ($request as $key => $value) {
			if ($value == '') unset($request[$key]);
		}
		$request = array_values($request);
		$getVars = array();
		
		if (!count($request)) {
			$module = strtolower($this->config['website']['defaultmodule']);
			$controller = strtolower('index');
			$action = strtolower('index');
		}
		elseif (count($request) < 2) {
			$module = strtolower($request[0]);
			$controller = strtolower('index');
			$action = strtolower('index');
		}
		elseif (count($request) > 1 && count($request) < 3) {
			$module = strtolower($request[0]);
			$controller = strtolower($request[1]);
			$action = strtolower('index');
		}
		else {
			$module = strtolower($request[0]);
			$controller = strtolower($request[1]);
			$action = strtolower($request[2]);
			for($i=3; $i<count($request); $i+=2) {
				$getVars[$request[$i]] = strtolower((isset($request[$i+1])?$request[$i+1]:''));
			}
		}
		$getVars['module'] = $module;
		$getVars['controller'] = $controller;
		$getVars['action'] = $action;
		$this->getVars = $getVars;
		
		return $this;
	}
	
	public function postVars() {
		foreach ($_POST as $key => $value) {
			$this->postVars[$key] = $value;
		}
		
		if (!is_array($this->postVars)) {
			$this->postVars = array();
		}
		
		return $this;
	}
	
	public function getConfig() {
		return $this->config;
	}
	
	public function initializePage() {
		ob_start();
		include_once(ROOT_PATH . '/library/autoload.php');
		include_once(ROOT_PATH . '/library/base/Base_Functions.php');
		include_once(ROOT_PATH . '/library/base/Base_Controller.php');
		include_once(ROOT_PATH . '/library/base/Base_View.php');
		include_once(ROOT_PATH . '/library/base/Base_Mapper.php');
		
		if (is_readable(ROOT_PATH.'/application/controller/'.$this->getVars['module'].'/'.$this->getVars['controller'].'Controller.php')) {
			include('../application/controller/'.$this->getVars['module'].'/'.$this->getVars['controller'].'Controller.php');
			$error = false;
		}
		else {
			$error = true;
		}
		
		if (!$error) {
			$controller = $this->getVars['module'].'_'.$this->getVars['controller'].'Controller';
			$action = $this->getVars['action'].'Action';
			
			try {				
				if (class_exists($controller)) {
					$dispatch = new $controller();
					$dispatch->_init($this->getVars, $this->postVars, $this->getConfig());
				}
				else {
					throw new Exception("An error has ocurred. The controller has not been found.");
				}
				if (method_exists($dispatch, $action)) {
					$object = call_user_func_array(array($dispatch, $action), $this->getVars);
					$view = new view($dispatch, $this->getVars['module'], $this->getVars['controller'], $this->getVars['action'], $this->config);
					$view->__render();
				}
				else {
					throw new Exception("An error has ocurred. The action has not been found.");
				}
			}
			catch (Exception $e) {
				$error = true;
			}
		}
		if ($error) {
			include(ROOT_PATH.'/application/controller/'.$this->getVars['module'].'/error404Controller.php');
			$controller = $this->getVars['module'].'_error404Controller';
			$dispatch = new $controller();
			$dispatch->_init($this->getVars, $this->postVars, $this->getConfig());
			$object = call_user_func_array(array($dispatch, 'error404Action'), $this->getVars);
			$view = new view($object, $this->getVars['module'], 'errors', 'error404', $this->config);
			$view->__render();
		}
		$output = ob_get_clean();
		return $output;
	}
	
}