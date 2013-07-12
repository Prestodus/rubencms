<?php

class Default_Admin_Acl_Roles_Mapper extends Base_Mapper {
	
	public function make_object($array, $object = false) {
		if (!is_array($array)) return false;
		
		$maps = array(
			'ar_id' => array('int', 'setId'),
			'ar_name' => array('string', 'setName')
		);
		
		if (!is_object($object)) $object = new Default_Admin_Acl_Roles();
		
		$object = $this->objectify($maps, $array, $object);
		
		return $object;
	}
	
	public function make_array(object $object) {
		$maps = array(
			'au_id' => 'getId',
			'au_name' => 'getName'
		);
		
		$array = $this->arrayify($maps, $object);
		
		return $array;
	}
	
}