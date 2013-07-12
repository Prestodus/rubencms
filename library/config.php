<?php

class config {
	
	public static function getConfig() {
		$config = parse_ini_file('../application/configs/config.ini', true);
		return $config;
	}
	
}