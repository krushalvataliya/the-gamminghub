<?php
error_reporting(E_ALL);
define("DS", DIRECTORY_SEPARATOR);
require_once "Controller/Core/Front.php";

class Kv
{
	
	public static function init()
	{
		$front = new Controller_Core_Front();
		$front->init();
	}

	public static function getApiFile()
	{
		return '.'. DS .'assets'. DS .'gameapi.json';
	}
}

Kv::init();

?>