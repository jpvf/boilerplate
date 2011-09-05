<?php 

class App_Controller extends Controller
{
    
    function __construct()
    {
        parent::__construct();
    }


    function before()
    {    
       /* if ( ! $this->session->valid_session() && $this->uri->get(1) != 'login')
        {   
            redirect(get_url() . '/login');
        }
        date_default_timezone_set ("America/Bogota");*/
    }

    function after()
    {
        
    }
    
}