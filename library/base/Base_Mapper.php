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
		return $new_array;
	}
	
	public function objectify_multi($array) {
		$new_array = array();
		foreach ($array as $item) {
			$new_array[] = $this->make_object($item);
		}
		return $new_array;
	}
	
	public function from_input($data, $parameters) {
		foreach ($parameters as $param_key => $param_value) {
			if (array_key_exists($param_key, $data)) {
				if (is_string($param_value) || is_int($param_value)){
					$data[$param_key] = $param_value;
				} else {
					unset($data[$param_key]);
				}
			}
		}
		return $data;
	}
	
	public function array_insert(array $array, $table) {
		$db = Db_Conn::connect();
		
		$binds = array();
		$query = 'INSERT INTO '.$table.' (';
		$array_columns = array();
		$array_values = array();
		if (preg_match('/^[a-zA-Z0-9_]*$/', $table)) {
			foreach ($array as $key => $value) {
				if ((is_string($key) && $key != '') && (is_int($value) || is_string($value)) && $value != '') {
					$array_columns[] = $key;
					$array_values[] = $value;
				}
			}
			if (count($array_columns) > 0) {
				$questionmarks = array();
				for ($i=1; $i<=count($array_columns); $i++) {
					$questionmarks[] = '?';
				}
				$query .= implode(', ', $array_columns).') VALUES ('.implode(', ', $questionmarks).')';
				$insert = $db->prepare($query);
				
				foreach ($array_values as $value) {
					$binds[] = $value;
				}
	
				if ($insert->execute($binds)) {
					return true;
				} else {
					return false;
				}
			} else {
				dump('Error: array_insert has no valid fields to set.');
				return false;
			}
		} else {
			dump('Error: array_insert: table name is not valid.');
		}
	}
	
	public function array_update(array $array, $table, array $id) {
		$db = Db_Conn::connect();
		
		$binds = array();
		$query = 'UPDATE '.$table.' SET ';
		$query_sets = array();
		if (preg_match('^[a-zA-Z0-9_]*$', $table)) {
			foreach ($array as $key => $value) {
				if ((is_string($key) && $key != $id[0] && $key != '') && (is_int($value) || is_string($value)) && $value != '') {
					$query_sets[] = $key.' = ?';
					$binds[] = $value;
				}
			}
			if (count($query_sets) > 0) {
				$query .= implode(', ', $query_sets).' WHERE '.$pdo->quote($id[0]).' = ?';
				$binds[] = (int) $id[1];
				$update = $db->prepare($query);
				if ($update->execute($binds)) {
					return true;
				} else {
					return false;
				}
			} else {
				dump('Error: array_update has no valid fields to set.');
				return false;
			}
		} else {
			dump('Error: array_insert: table name is not valid.');
		}
	}
	
}