<?php

class Base_View extends Base_Functions {
	
	public $scripts = array();
	
	public function bufferScriptStart() {
		ob_start();
	}
	
	public function bufferScriptEnd() {
		$this->scripts[] = ob_end_clean();
	}
	
	public function bufferScriptRender() {
		return implode('\n\n', $this->scripts);
	}
	
}