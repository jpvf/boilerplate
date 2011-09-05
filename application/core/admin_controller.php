<?php

class Admin_Controller extends Controller {
	
	function __construct()
	{
		parent::__construct();		
		$this->template->set_template('admin');
	}
}