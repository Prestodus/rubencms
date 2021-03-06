<?php

class Default_Admin_Price_Categories_Proxy {
	
	public function __construct() {
		$this->_mapper = new Default_Admin_Price_Categories_Mapper();
	}
	
	public function getAll() {
		$db = Db_Conn::connect();
		
		$sql = "SELECT * FROM front_price_categories";
		$select = $db->prepare($sql);
		$select->execute();
		
		$allusers = $select->fetchAll();
		$allusers = $this->_mapper->objectify_multi($allusers);
		
		return $allusers;
	}
	
	public function getById($id) {
		$db = Db_Conn::connect();
		
		$sql = "SELECT * FROM front_price_categories WHERE fpc_id = ?";
		$select = $db->prepare($sql);
		$select->execute(array((int) $id));
		
		$user = $select->fetch();
		$user = $this->_mapper->make_object($user);
		
		return $user;
	}
	
}