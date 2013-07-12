<?php

class Default_Password {
	
	public function generate_salt($cost = 11) {
	    if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
	        throw new Exception("cost parameter must be between 4 and 31");
	    }
	    $rand = array();
	    for ($i = 0; $i < 8; $i += 1) {
	        $rand[] = pack('S', mt_rand(0, 0xffff));
	    }
	    $rand[] = substr(microtime(), 2, 6);
	    $rand = sha1(implode('', $rand), true);
	    $salt = '$2a$' . sprintf('%02d', $cost) . '$';
	    $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
	    return $salt;
	}
	
	public function generate_password($password) {
		return crypt($password, $this->generate_salt());
	}
	
	public function validate_password($password, $hash) {
		if ($hash == crypt($password, $hash)) return true;
		else return false;
	}
	
	public function generate_random($length = 12) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!?/*-+%';
	    $random_string = '';
	    for ($i = 0; $i < $length; $i++) {
	        $random_string .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $random_string;
	}
	
}