<?php

class Test extends App_Controller {
	
	function index()
	{
		
		/*
		$this->load->library('auth');

		/*if ( ! $this->auth->login('admin', '123456'))
		{
			echo 'FALSE!!!!';
		}
		
		if ($this->auth->is_logged_in())
		{
			echo 'logueado';
		}
		else
		{
			echo 'no logueado';
		}

		//$this->auth->logout();



		/*
		$this->load->library('validation');
		$_POST['username'] = 'jua';
		$_POST['password'] = '';

		$this->validation->set_rules('username', 'Username', 'required|min_length[9]')
						 ->set_rules('password', 'Password', 'required');

		$this->validation->set_message('min_length', 'Length fail');
		$this->validation->set_message('required', 'Require fail');
		
		if ($this->validation->run() == FALSE)
		{
			debug($this->validation->error_string());
		}
		*/
	}
}