<?php

class Db_Conn extends config {
	
	public static function connect() {
		$config = parent::getConfig();
		
		try {
			$dbh = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'], $config['db']['username'], $config['db']['password']);
			$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$dbh = $e;
		}
		
		return $dbh;
	}
	
}