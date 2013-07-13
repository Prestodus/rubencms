<?php

class Default_Admin_Price_Items {
	
	protected $_id;
	protected $_category_id;
	protected $_subcategory_id;
	protected $_name;
	protected $_price;
	protected $_date_created;
	protected $_date_updated;

	public function getId() {
		return $this->_id;
	}
	public function setId($_id) {
		$this->_id = (int) $_id;
		return $this;
	}

	public function getCategoryId() {
		return $this->_category_id;
	}
	public function setCategoryId($_category_id) {
		$this->_category_id = (int) $_category_id;
		return $this;
	}

	public function getSubcategoryId() {
		return $this->_subcategory_id;
	}
	public function setSubcategoryId($_subcategory_id) {
		$this->_subcategory_id = (int) $_subcategory_id;
		return $this;
	}

	public function getName() {
		return $this->_name;
	}
	public function setName($_name) {
		$this->_name = $_name;
		return $this;
	}

	public function getPrice() {
		return $this->_price;
	}
	public function setPrice($_price) {
		$this->_price = $_price;
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