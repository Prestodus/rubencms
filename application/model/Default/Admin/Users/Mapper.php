<?php

class Default_Admin_Users_Mapper extends Base_Mapper {
	
	public function make_object($array, $object = false) {
		if (!is_array($array)) return false;
		
		$maps = array(
			'au_id' => array('int', 'setId'),
			'au_email' => array('string', 'setEmail'),
			'au_password' => array('string', 'setPassword'),
			'au_firstname' => array('string', 'setFirstname'),
			'au_lastname' => array('string', 'setLastname'),
			'au_created' => array('string', 'setCreated'),
			'au_updated' => array('string', 'setUpdated')
		);
		
		if (!is_object($object)) $object = new Default_Admin_Users();
		
		$object = $this->objectify($maps, $array, $object);
		
		return $object;
	}
	
	public function make_array(object $object) {
		$maps = array(
			'au_id' => 'getId',
			'au_email' => 'getEmail',
			'au_password' => 'getPassword',
			'au_firstname' => 'getFirstname',
			'au_lastname' => 'getLastname',
			'au_created' => 'getCreated',
			'au_updated' => 'getUpdated'
		);
		
		$array = $this->arrayify($maps, $object);
		
		return $array;
	}
	
}