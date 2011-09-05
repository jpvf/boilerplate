<?php 

class App_Controller extends Controller
{
    
    function __construct()
    {
        parent::__construct();
    }


    function before()
    {    
        $this->load->library('auth');

        if ( ! $this->auth->is_logged_in() AND Uri::getInstance()->get(1) != 'login')
        {
        //    redirect(get_url() . '/login');
        }
    }

    function after()
    {
        
    }
    
}