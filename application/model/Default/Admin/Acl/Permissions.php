<?php

class Default_Admin_Acl_Permissions {
	
	protected $_id;
	protected $_description;

	public function getId() {
		return $this->_id;
	}
	public function setId($_id) {
		$this->_id = (int) $_id;
		return $this;
	}

	public function getDescription() {
		return $this->_description;
	}
	public function setDescription($_description) {
		$this->_description = $_description;
		return $this;
	}

}