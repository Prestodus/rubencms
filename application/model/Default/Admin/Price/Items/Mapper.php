<?php

class Default_Admin_Price_Items_Mapper extends Base_Mapper {
	
	public function make_object($array, $object = false) {
		if (!is_array($array)) return false;
		
		$maps = array(
			'fpi_id' => array('int', 'setId'),
			'fpi_category_id' => array('int', 'setCategoryId'),
			'fpi_subcategory_id' => array('int', 'setSubcategoryId'),
			'fpi_name' => array('string', 'setName'),
			'fpi_price' => array('string', 'setPrice'),
			'fpi_date_created' => array('string', 'setDateCreated'),
			'fpi_date_updated' => array('string', 'setDateUpdated')
		);
		
		if (!is_object($object)) $object = new Default_Admin_Price_Items();
		
		$object = $this->objectify($maps, $array, $object);
		
		return $object;
	}
	
	public function make_array(object $object) {
		$maps = array(
			'fps_id' => 'getId',
			'fps_name' => 'getName',
			'fps_date_created' => 'getDateCreated',
			'fps_date_updated' => 'getDateUpdated'
		);
		
		$array = $this->arrayify($maps, $object);
		
		return $array;
	}
	
}