<?php

class Default_Session {
	
    private $session_name = 'default';
    
    public function __constructor($session_name) {
    	$this->session_name = $session_name;
    }
    
    public function exists() {
    	return isset($_SESSION[$this->session_name]);
    }

    public function set($subname, $value) {
        $_SESSION[$this->session_name][$subname] = $value;
        return $this;
    }
    
    public function get($subname, $default = false) {
        if(isset($_SESSION[$this->session_name][$subname]) && !empty($_SESSION[$this->session_name][$subname]))
            return $_SESSION[$this->session_name][$subname];
        else
            return $default;
    }
    
    public function getParent() {
    	if (isset($_SESSION[$this->session_name]))
    		return $_SESSION[$this->session_name];
   		else
   			return false;
    }
    
    public function unsetChild($subname) {
    	unset($_SESSION[$this->session_name][$subname]);
        return $this;
    }
    
    public function unsetParent() {
    	unset($_SESSION[$this->session_name]);
        return $this;
    }
    
    public static function unsetAll() {
    	session_destroy();
    }
   
}