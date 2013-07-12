<?php

class Default_Login {
	
	private $type = 'front';
	private $email = false;
	private $session = false;
	
	public function login($email = false, $password = false, $type = 'admin') {
		$password_generator = new Default_Password();
		$db = Db_Conn::connect();
		if ($type == 'admin') {
			$this->type = 'admin';
			$this->session = new Default_Session('admin_user');
			$admin_users_proxy = new Default_Admin_Users_Proxy();
			$user = $admin_users_proxy->getByEmail($email);
			if ($user) {
				if ($password_generator->validate_password($password, $user->getPassword())) {
					$this->email = $email;
					$hash = $password_generator->generate_password($password_generator->generate_random());
					$this->session
						->set('id', $user->getId())
						->set('hash', $hash)
						->set('login_date', date('Y-m-d H:i:s', time()));
					$query = "DELETE FROM admin_sessions WHERE as_admin_id = ?";
					$delete = $db->prepare($query);
					$delete->execute(array($user->getId()));
					$query = "INSERT INTO admin_sessions (as_admin_id, as_session_hash, as_date_created) VALUES (?, ?, NOW())";
					$insert = $db->prepare($query);
					$insert->execute(array($user->getId(), $hash));
				} else {
					$query = "DELETE FROM admin_sessions WHERE as_admin_id = ?";
					$delete = $db->prepare($query);
					$delete->execute(array($user->getId()));
					throw new Exception('error_login_password');
				}
			} else {
				throw new Exception('error_login_user');
			}
		} else {
			$this->type = 'front';
			$this->session = new Default_Session('front_user');
			$front_users_proxy = new Default_Front_Users_Proxy();
			$user = $front_users_proxy->getByEmail($email);
			if ($user) {
				if ($password_generator->validate_password($password, $user->getPassword())) {
					$this->email = $email;
					$hash = $password_generator->generate_password($password_generator->generate_random());
					$this->session
						->set('id', $user->getId())
						->set('hash', $hash)
						->set('login_date', date('Y-m-d H:i:s', time()));
					$query = "DELETE FROM front_sessions WHERE fs_user_id = ?";
					$delete = $db->prepare($query);
					$delete->execute(array($user->getId()));
					$query = "INSERT INTO front_sessions (fs_user_id, fs_session_hash, fs_date_created) VALUES (?, ?, NOW())";
					$insert = $db->prepare($query);
					$insert->execute(array($user->getId(), $hash));
				} else {
					$query = "DELETE FROM front_sessions WHERE fs_user_id = ?";
					$delete = $db->prepare($query);
					$delete->execute(array($user->getId()));
					throw new Exception('error_login_password');
				}
			} else {
				throw new Exception('error_login_user');
			}
		}
	}
	
	public static function logout($type = 'admin') {
		$db = Db_Conn::connect();
		if ($type == 'admin') {
			$session = new Default_Session('admin_user');
			$session->unsetParent();
			Base_Functions::redirect('admin', 'user', 'login');
		} else {
			$session = new Default_Session('front_user');
			$session->unsetParent();
			Base_Functions::redirect('front', 'user', 'login');
		}
	}
	
	public static function checklogin($type = 'admin', $redirect = true) {
		$db = Db_Conn::connect();
		if ($type == 'admin') {
			$session = new Default_Session('admin_user');
			if ($session->exists()) {
				$query = "SELECT * FROM admin_sessions WHERE as_admin_id = ? AND as_session_hash = ?";
				$select = $db->prepare($query);
				$select->execute(array($session->get('id'), $session->get('hash')));
				if ($select->fetch()) {
					$query = "UPDATE admin_sessions SET as_date_updated = NOW() WHERE as_admin_id = ?";
					$update = $db->prepare($query);
					$update->execute(array($session->get('id')));
					return true;
				} else {
					if (!$redirect)
						return false;
					else {
						Base_Functions::redirect('admin', 'user', 'login');
					}
				}
			} else {
				if (!$redirect)
					return false;
				else {
					Base_Functions::redirect('admin', 'user', 'login');
				}
			}
		} else {
			$session = new Default_Session('front_user');
			if ($session->exists()) {
				$query = "SELECT * FROM front_sessions WHERE fs_user_id = ? AND fs_session_hash = ?";
				$select = $db->prepare($query);
				$select->execute(array($session->get('id'), $session->get('hash')));
				if ($select->fetch()) {
					$query = "UPDATE front_sessions SET fs_date_updated = NOW() WHERE fs_user_id = ?";
					$update = $db->prepare($query);
					$update->execute(array($session->get('id')));
					return true;
				} else {
					if ($loginpage)
						return false;
					else {
						Base_Functions::redirect('front', 'user', 'login');
					}
				}
			} else {
				if ($loginpage)
					return false;
				else {
					Base_Functions::redirect('front', 'user', 'login');
				}
			}
		}
	}
	
}