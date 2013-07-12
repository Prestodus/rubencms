<?php

class Base_Mapper {
	
	public function objectify(array $maps, array $array, $object) {
		foreach ($array as $key => $value) {
			if (array_key_exists($key, $maps)) {
				$item = $maps[$key];
				if (is_array($item) && count($item) > 1) {
					$type = $item[0];
					$setter = $item[1];
					if (method_exists($object, $setter)) {
						if ($type == 'int') {
							$object->$setter((int) $array[$key]);
						} else {
							$object->$setter($array[$key]);
						}
					}
					unset($type);
					unset($setter);
				}
				unset($item);
			}
		}
		return $object;
	}
	
	public function arrayify(array $array, $object) {
		$new_array = array();
		foreach ($array as $key => $getter) {
			if (method_exists($object, $getter)) {
				$new_array[$key] = $object->$getter();
			}
		}
		return $new_array();
	}
	
	public function objectify_multi($array) {
		$new_array = array();
		foreach ($array as $item) {
			$new_array[] = $this->make_object($item);
		}
		return $new_array;
	}
	
}