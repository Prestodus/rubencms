<?php

class Default_Admin_Price_Categories_Mapper extends Base_Mapper {
	
	public function make_object($array, $object = false) {
		if (!is_array($array)) return false;
		
		$maps = array(
			'fpc_id' => array('int', 'setId'),
			'fpc_name' => array('string', 'setName'),
			'fpc_description' => array('string', 'setDescription'),
			'fpc_date_created' => array('string', 'setDateCreated'),
			'fpc_date_updated' => array('string', 'setDateUpdated')
		);
		
		if (!is_object($object)) $object = new Default_Admin_Price_Categories();
		
		$object = $this->objectify($maps, $array, $object);
		
		return $object;
	}
	
	public function make_array(object $object) {
		$maps = array(
			'fpc_id' => 'getId',
			'fpc_name' => 'getName',
			'fpc_description' => 'getDescription',
			'fpc_date_created' => 'getDateCreated',
			'fpc_date_updated' => 'getDateUpdated'
		);
		
		$array = $this->arrayify($maps, $object);
		
		return $array;
	}
	
}