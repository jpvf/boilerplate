<?php

class Admin extends Admin_Controller {
	
	function index()
	{
		$this->template->render();
	}
	
	function navigation()
	{

		$data['js'] = 'navigation';
		$this->template->set_content('navigation/menu')
					   ->render($data);
	}	
	

}