<?php

class admin_getsetController extends Base_Controller {
    
    public function indexAction() {
		Default_Login::checklogin('admin');
		
    	if ($this->postVar('names', false)) {
    		$this->view->output = $this->initialize($this->postVar('names', false), $this->postVar('int', false))
							->generate();
			$this->view->names = $this->postVar('names', false);
			$this->view->int = $this->postVar('int', false);
    	} else $this->view->output = false;
    	
    	$this->view->number = $this->getVar('number', 1);
    	
    }
      
    public function initialize($names, $ints) {
		Default_Login::checklogin('admin');
		
        foreach ($names as $key => $value) { 
            if ($value != '') { 
                if (array_key_exists($key, $ints)) { 
                    $this->names[] = array('type' => 'int', 'name' => trim($value)); 
                } else { 
                    $this->names[] = array('type' => 'string', 'name' => trim($value)); 
                } 
            } 
        }
        return $this;
          
    } 
      
    public function generate() {
		Default_Login::checklogin('admin');
		
        $outputvars = array(); 
        $outputgetset = array(); 
        foreach ($this->names as $name) { 
            $name['name'] = strtolower($name['name']); 
            $outputvars[] = "\tprotected \$_".$name['name'].";"; 
            $getset = "\tpublic function get".str_replace(" ", "", ucwords(str_replace("_", " ", $name['name'])))."() {"; 
                $getset .= "\n\t\treturn \$this->_".$name['name'].";"; 
            $getset .= "\n\t}"; 
            $getset .= "\n\tpublic function set".str_replace(" ", "", ucwords(str_replace("_", " ", $name['name'])))."(\$_".$name['name'].") {"; 
                $getset .= "\n\t\t\$this->_".$name['name']." = ".($name['type']=='int'?'(int) ':'')."\$_".$name['name'].";"; 
                $getset .= "\n\t\treturn \$this;"; 
            $getset .= "\n\t}"; 
            $outputgetset[] = $getset; 
        } 
        $output = implode("\n", $outputvars); 
        $output .= "\n\n"; 
        $output .= implode("\n\n", $outputgetset); 
        return $output; 
          
    } 
	
}