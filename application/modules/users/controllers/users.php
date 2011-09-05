<?php

class Users extends App_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }

    function index()
    {
        $this->view();
    }

    function view()
    {
        $this->load->library('table');

        $rows = $this->users_model->find_all();
        
        if ($rows->num_rows() > 0)
        {
            foreach ($rows->result() as $row)
            {
                $detalles = anchor("users/{$row->uid}/details", 'Detalles');
                $editar   = anchor("users/{$row->uid}/edit", 'Editar');
                $eliminar = anchor("users/{$row->uid}/remove", 'Eliminar');

                $this->table->add_row(array(
                     $row->username, 
					 $row->first_name, 
					 $row->last_name, 
					 $row->email, 
					 $row->active, 
					 $row->profile,
                     $detalles,
                     $editar,
                     $eliminar
                ));
            }
        }
        else
        {
            $this->table->add_row('No hay registros|colspan="6"'); 
        }

        $this->table->add_heading(array(
             'Username', 
			 'First name', 
			 'Last name', 
			 'Email', 
			 'Active', 
			 'Profile',
             '&nbsp;|colspan="3"'
        ));

        $data['table_users'] = $this->table->generate(array('class' => 'table-full'));
    
        $this->template->set_content('view_all')
                        ->render($data);
    }

    function create()
    {
        		$this->load->model('users_profiles_model');
                $users_profiles = $this->users_profiles_model->find_all();
        $data['options'] = get_select_options($users_profiles->result(), 'id', 'name');
        $this->template->set_content('create')
                        ->render($data);
    }

    function save()
    {
        if ( ! _post('uid'))
        {
            $save = array();
            $save['username'] = _post('username');
			$save['uid'] = _uid('users'); 
			$save['first_name'] = _post('first_name');
			$save['uid'] = _uid('users'); 
			$save['last_name'] = _post('last_name');
			$save['uid'] = _uid('users'); 
			$save['password'] = salt_it(_post('password'));
			$save['email'] = _post('email');
			$save['uid'] = _uid('users'); 
			$save['id_profile'] = _post('id_profile');
			$save['uid'] = _uid('users');  
        }
        else
        {
            $save['username'] = _post('username');
			$save['first_name'] = _post('first_name');
			$save['last_name'] = _post('last_name');
			$save['password'] = salt_it(_post('password'));
			$save['email'] = _post('email');
			$save['id_profile'] = _post('id_profile');
			$row = $this->users_model->find(_post('uid'));
			
			if ($row->num_rows() == 0)
			{
				 Message::error('Error','users');
			}
			
			$save['id'] = $row->row()->id;   
        }

        if ($this->users_model->save($save))
        {
            Message::success('Guardado', 'users');
        }

        Message::error('Error', users);
    }

}