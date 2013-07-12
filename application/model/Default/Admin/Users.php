<?php

class Default_Admin_Users {
	
	protected $id;
	protected $email;
	protected $password;
	protected $firstname;
	protected $lastname;
	protected $created;
	protected $updated;
	protected $roleid;
	protected $rolename;
	protected $permissions;

	public function setId($id) {
		$this->id = (int) $id;
		return $this;
	}
	public function getId() {
		return $this->id;
	}

	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	public function getEmail() {
		return $this->email;
	}

	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}
	public function getPassword() {
		return $this->password;
	}

	public function setFirstname($firstname) {
		$this->firstname = $firstname;
		return $this;
	}
	public function getFirstname() {
		return $this->firstname;
	}

	public function setLastname($lastname) {
		$this->lastname = $lastname;
		return $this;
	}
	public function getLastname() {
		return $this->lastname;
	}
	
		public function getFullname() {
			return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
		}

	public function setCreated($created) {
		$this->created = $created;
		return $this;
	}
	public function getCreated() {
		return $this->created;
	}

	public function setUpdated($updated) {
		$this->updated = $updated;
		return $this;
	}
	public function getUpdated() {
		return $this->updated;
	}
	
	public function setRoleid($roleid) {
		$this->roleid = $roleid;
		return $this;
	}
	public function getRoleid() {
		return $this->roleid;
	}
	
	public function setRolename($rolename) {
		$this->rolename = $rolename;
		return $this;
	}
	public function getRolename() {
		return $this->rolename;
	}
	
	public function setPermissions($permissions) {
		$this->permissions = $permissions;
		return $this;
	}
	public function getPermissions() {
		return $this->permissions;
	}
	
	public function acl($permission) {
		if (in_array($permission, $this->getPermissions())) return true;
		else return false;
	}

}