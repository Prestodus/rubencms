<?php

class front_indexController extends Base_Controller {
	
	public function indexAction() {
		
		$this->view->title = "Floris Thijs - Visual Effects Artist";
		
		$this->view->images = glob('graphics/layout/slider/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
		
		return $this;
		
	}
	
	public function contactAction() {
		$this->view->title = "Contact - Floris Thijs - Visual Effects Artist";
		
		if ($this->postVars()) {
			$error = array();
			if (strlen($this->postVar('name')) < 3) $error["name"] = true;
			if (!Default_Validate::validate_email($this->postVar('emailaddress'))) $error["emailaddress"] = true;
			if (strlen($this->postVar('message')) < 5) $error["message"] = true;
			if (count($error) < 1) {
				$mail = new Default_Mail();
				$send = $mail->setFrom($this->config["contact"]["email"])
					->setFromName($this->config["contact"]["name"])
					->setTo($this->config["contact"]["email"])
					->setBcc($this->postVar('emailaddress'))
					->setSubject('Contact: '.$this->config["website"]["path"])					
					->setBody(
'Someone contacted you on floristhijs.be.

Name:
 '.$this->postVar('name').'
Email address:
 '.$this->postVar('emailaddress').'
Date:
 '.date('d/m/Y').'

========== Message ==========
'.$this->postVar('message').'
========== Message =========='
					)
					->send();
				if ($send === true) $this->view->success = 1;
			} else {
				$this->view->error = $error;
			}
		}
						
		return $this;
	}

}