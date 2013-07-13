<?php

class Default_Admin_Price_Categories {
	
	protected $_id;
	protected $_name;
	protected $_description;
	protected $_date_created;
	protected $_date_updated;

	public function getId() {
		return $this->_id;
	}
	public function setId($_id) {
		$this->_id = (int) $_id;
		return $this;
	}

	public function getName() {
		return $this->_name;
	}
	public function setName($_name) {
		$this->_name = $_name;
		return $this;
	}

	public function getDescription() {
		return $this->_description;
	}
	public function setDescription($_description) {
		$this->_description = $_description;
		return $this;
	}

	public function getDateCreated() {
		return $this->_date_created;
	}
	public function setDateCreated($_date_created) {
		$this->_date_created = $_date_created;
		return $this;
	}

	public function getDateUpdated() {
		return $this->_date_updated;
	}
	public function setDateUpdated($_date_updated) {
		$this->_date_updated = $_date_updated;
		return $this;
	}
	
	
	
	public function save($parameters = '*') {
		$db = Db_Conn::connect();
		$mapper = new Default_Admin_Price_Categories_Mapper();
		
		$data = $mapper->make_array($this);
		
		if (is_array($parameters)) {
			$data = $mapper->from_input($data, $parameters);
		}
		
		if ($this->getId()) {
			$data['fpc_date_updated'] = date('Y-m-d H:i:s', time());
			$mapper->array_update($data, 'front_price_categories', array('fpc_id', '1'));
		} else {
			$data['fpc_date_created'] = date('Y-m-d H:i:s', time());
			$mapper->array_insert($data, 'front_price_categories');
			$this->setId($db->lastInsertId());
		}
		return $this;
	}

}