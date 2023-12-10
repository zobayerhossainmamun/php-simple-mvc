<?php
// Start session
session_start();

// Enable error_reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('Asia/Dhaka');

define('host', $_SERVER['HTTP_HOST']);
define('sitename', "MVC Site");
function is_secure(){
	return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
}
if (is_secure()) {
	define("DIR", "https://".host);
}else{
	define("DIR", "http://".host);
}
if (!defined('DOCROOT')) {
	define('DOCROOT', dirname(__FILE__));
}

// Database Configuration
define('DB_TYPE', 'mysql');
define('DB_HOST','localhost');
define('DB_NAME','simple_mvc_db');
define('DB_USER','root');
define('DB_PASS','');

// Load functions from include directory
if (!function_exists('autoloadsystem')) {
	function autoloadsystem($class) {
	    $filename = DOCROOT . "/include/" . strtolower($class) . ".php";
	    if(file_exists($filename)){
	        require $filename;
	    }
	}
}
spl_autoload_register("autoloadsystem");

$db = new Database();
$app = new Bootstrap();
$app->setController('main');
$app->init();
ob_flush();
?>