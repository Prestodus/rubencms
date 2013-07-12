<?php

class Default_Admin_Acl_Permissions_Proxy {
	
	public function __construct() {
		$this->_mapper = new Default_Admin_Acl_Permissions_Mapper();
	}
	
	public function getAll() {
		$db = Db_Conn::connect();
		
		$sql = "SELECT * FROM admin_permissions";
		$select = $db->prepare($sql);
		$select->execute();
		
		$allpermissions = $select->fetchAll();
		$allpermissions = $this->_mapper->objectify_multi($allpermissions);
		
		return $allpermissions;
	}
	
	public function getById($id) {
		$db = Db_Conn::connect();
		
		$sql = "SELECT * FROM admin_users WHERE au_id = ?";
		$select = $db->prepare($sql);
		$select->execute(array((int) $id));
		$user = $select->fetch();
		
		$sql = "SELECT ar_id, ar_name, ap_id, ap_description
				FROM admin_roles_relations, admin_roles, admin_permissions_relations, admin_permissions
				WHERE arr_user_id = ?
				AND arr_role_id = ar_id
				AND ar_id = apr_role_id
				AND apr_permission_id = ap_id";
		$select = $db->prepare($sql);
		$select->execute(array((int) $id));
		$permissions = $select->fetchAll();
		
		$new_permissions = array();
		foreach ($permissions as $permission) {
			$role_id = $permission['ar_id'];
			$role_name = $permission['ar_name'];
			$new_permissions[$permission['ap_id']] = $permission['ap_description'];
		}
		
		$user = $this->_mapper->make_object($user);
		$user->setRoleId($role_id);
		$user->setRoleName($role_name);
		$user->setPermissions($new_permissions);
		
		return $user;
	}
	
	public function getByEmail($email) {
		$db = Db_Conn::connect();
		
		$sql = "SELECT * FROM admin_users WHERE au_email = ?";
		$select = $db->prepare($sql);
		$select->execute(array($email));
		
		$user = $select->fetch();
		$user = $this->_mapper->make_object($user);
		
		return $user;
	}
	
}