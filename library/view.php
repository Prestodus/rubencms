<?php

class view extends Base_View {
	
	public $view;
	public $module;
	public $controller;
	public $action;
	public $config;
	
	public function __construct($object, $module, $controller, $action, $config) {
		
		$this->view = $object->view;
		$this->module = $module;
		$this->controller = $controller;
		$this->action = $action;
		$this->config = $config;
		
	}
	
	public function __render($part = null) {
		
		$viewfolder = ROOT_PATH.'/application/view/';
		
		if ($part == null) {
		
			if (!isset($this->view->title)) $this->view->title = '';
			if (!isset($this->view->styles)) $this->view->styles = '';
			if (!isset($this->view->scripts)) $this->view->scripts = '';
			
			foreach ($this->view as $key => $value) {
				$this->$key = $value;
			}
			
			unset($this->view);
			
			include_once($viewfolder.'layout/'.$this->module.'/index.phtml');
			
		} elseif ($part == 'content') {
			
			$this->action = str_replace('_', '/', $this->action);
			if (file_exists($viewfolder.'scripts/'.$this->module.'/'.$this->controller.'/'.$this->action.'.phtml')) {
				
				include_once($viewfolder.'scripts/'.$this->module.'/'.$this->controller.'/'.$this->action.'.phtml');
				
			}
			else {
			
				echo 'De view \''.$this->action.'.phtml\' bestaat niet.';
				
			}
		
		}
		else {

			if (file_exists($viewfolder.str_replace('_', '/', $part).'.phtml')) {
			
				include_once($viewfolder.str_replace('_', '/', $part).'.phtml');
				
			} else {
			
				echo 'De view \''.str_replace('_', '/', $part).'.phtml\' bestaat niet.';
				
			}
		
		}
		
		return $this;
		
	}
	
	public function thisPage($module, $controller = "index", $action = "index") {
		if ($this->module == $module && $this->controller == $controller && $this->action == str_replace('_', '/', $action)) return true;
		else return false;
	}
	
}