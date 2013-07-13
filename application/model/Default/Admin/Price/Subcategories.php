<?php

class Default_Admin_Price_Subcategories {
	
	protected $_id;
	protected $_name;
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

}