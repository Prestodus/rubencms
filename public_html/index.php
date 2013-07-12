<?php

function dump($var, $exit = null) {
	
	$var_dump = '';
	if(isset($var)) {
		
		echo var_dump($var);
		
	} else {
		
		echo "Variable doesn't exist!";
		
	}
	if ($exit != null) exit();
	
}

session_start();
error_reporting(E_ALL);

define('PUBLIC_PATH', getcwd());
define('ROOT_PATH', PUBLIC_PATH.'/..');

set_include_path(PUBLIC_PATH);

include('../application/bootstrap.php');

$bootstrap = new bootstrap();
echo $bootstrap->initializePage();