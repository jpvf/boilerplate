<?php if ( ! defined('BASE')) exit('Acceso directo prohibido');

class Model{

	function __construct()
	{
		//show(__CLASS__ . ' iniciada <br>');
	}

	function __get($key)
	{
		$base = Controller::getInstance();
		return $base->$key;
	}
		
}