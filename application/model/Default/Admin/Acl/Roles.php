<?php

class Default_Admin_Acl_Roles {
	
	protected $_id;
	protected $_name;
	protected $_permissions;

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
	
	public function getPermissions() {
		return $this->_permissions;
	}
	public function setPermissions($_permissions) {
		$this->_permissions = $_permissions;
		return $this;
	}

}