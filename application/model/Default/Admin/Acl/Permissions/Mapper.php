<?php

class Default_Admin_Acl_Permissions_Mapper extends Base_Mapper {
	
	public function make_object($array, $object = false) {
		if (!is_array($array)) return false;
		
		$maps = array(
			'ap_id' => array('int', 'setId'),
			'ap_description' => array('string', 'setDescription')
		);
		
		if (!is_object($object)) $object = new Default_Admin_Acl_Permissions();
		
		$object = $this->objectify($maps, $array, $object);
		
		return $object;
	}
	
	public function make_array(object $object) {
		$maps = array(
			'ap_id' => 'getId',
			'ap_description' => 'getDescription'
		);
		
		$array = $this->arrayify($maps, $object);
		
		return $array;
	}
	
}