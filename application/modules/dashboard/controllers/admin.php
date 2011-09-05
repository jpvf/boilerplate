<?php 

class Admin extends Admin_Controller {
	
	function index()
	{
		$this->template->set_content('index')
					   ->render();
	}

}