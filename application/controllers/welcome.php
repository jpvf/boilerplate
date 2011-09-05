<?php 

class Welcome extends Welcome_Controller {

	function index($name = NULL)
	{
	   $this->load->library('auth');
       
       //$this->auth->login('admin', '123456');
       
       if ($this->auth->is_logged_in())
       {
            echo 'si';
       }
       else
       {
            echo 'no';
       }
    
      $this->auth->logout();
       
       exit;
 /*       $this->load->model('users_model');

        $users = $this->users_model->find_all();

        foreach ($users->result() as $user)
        {
            debug($user);
        }

        exit;*/
		/*$this->forge->add_field('id');
        $this->forge->add_field('user VARCHAR(100)');

        $this->forge->add_field(array(
        	'name' => array(
        		'type'	 => 'varchar',
        		'constraint' => 100,
        		'null'		 => FALSE
	         )
	    ));

	    $this->forge->add_field(array(
        	'id_user' => array(
        		'constraint' => 11,
        		'null'		 => FALSE,
        		'type'		 => 'int'
	         )
	    ));

	    $this->forge->add_key('id_user');

        debug($this->forge->create_table('test', TRUE, FALSE));*/

        $this->load->library('yaml/sfYaml');
        $this->load->library('yaml/sfYamlDumper');
        $this->load->library('yaml/sfYamlInline');
        $this->load->library('yaml/sfYamlParser');

        $yaml = new sfYamlParser();
        $items = $yaml->parse(file_get_contents(PATH.'/uploads/yaml.yaml'));

        foreach ($items as $table => $values)
        {
            $items[$table]['columns'] = ( ! empty($values['columns']) AND isset($values['columns']) )?
                                        $values['columns'] : 
                                        array();
             
            $items[$table]['keys'] = ( ! empty($values['keys']) AND isset($values['keys']) ) ?
                                     $values['keys'] : 
                                     array();     
                                    
            $items[$table]['relations'] = ( ! empty($values['relations']) AND isset($values['relations']) )?
                                          $values['relations'] : 
                                          array();   
                                                       
                                    
            $items[$table]['crud'] = ( ! empty($values['crud']) AND isset($values['crud']) )?
                                     TRUE :
                                     FALSE;    
        }

        $i = 1;
        foreach ($items as $table => $values)
        {
            $relations = array();

            foreach ($values['relations'] as $key => $val)
            {
                $relations[] = "'$key' => '{$key}.id = {$table}.{$val}'";                
            }

            $relations = implode(",\n\t\t", $relations);

            $prefix = array($this , 'prefix_select');
            $select = array();

            $field_name = array();

            foreach ($values['columns'] as $key => $val)
            {
                if (in_array($key, $values['relations']))
                {
                    $relation = array_keys($values['relations'], $key);
                    $relation = $relation[0];
                    $field_name[$key] = str_replace('id_', '', $key);
                    $select[] = "{$table}.{$key}";
                    $select[] = "{$relation}.name AS ".$field_name[$key];
                }
                else
                {
                    $select[] = "{$table}.{$key}";
                }
            }

            $select = implode(', ', $select);

            if (strpos($table, '_') !== FALSE)
            {
                $class = implode('_', array_map(array($this, 'camel_to_upper'), explode('_', $table)));
            }
            else
            {
                $class = ucfirst($table);
            }

        

            $file = <<<JOIN
<?php 

class {$class}_Model extends App_Model {

    protected \$join = array(
        $relations
    );

    protected \$base_select = '$select';
    protected \$where       = '{$table}.active = 1';
    protected \$table       = '$table';

}
JOIN;

             $keys = array();

            foreach ($values['keys'] as $key => $val)
            {
                $keys[] = "\$this->forge->add_key('$key');"; 
            }

            $keys = implode("\n\t", $keys);

            $columns = array();

            foreach ($values['columns'] as $key => $val)
            {
                if ($key == 'id')
                {
                    $columns[] = "\$this->forge->add_field(\"$key\");";
                    continue;
                }
                $val = $this->_get_type($val);
                $columns[] = "\$this->forge->add_field(\"$key $val\");"; 
            }

            $columns = implode("\n\t", $columns);

            if ($this->db->table_exists('schema_version'))
            {
                $row = $this->db->get('schema_version')->row();
                $row = $row ? $row->version : 0;
            }
            else
            {
                $row = 0;
            }
            
            $row = str_pad($row + $i, 3, "0", STR_PAD_LEFT);
            $i++;

            $class_migrations = "Create_Table_{$table}";

            $migrations = <<<MIGRATION
<?php

class Migration_$class_migrations extends Migration {
    
    function up()
    {
        $columns
        $keys

        \$this->forge->create_table('$table', TRUE);
    }

    function down()
    {
        \$this->forge->drop_table('$table');
    }

}
MIGRATION;

            
            $handle = @fopen(RUTA_APP.'/migrations/'.$row.'_'.strtolower($class_migrations).EXT, 'w+');
            $result = @fwrite($handle, $migrations);
            @fclose($handle);
            $class_migrations = strtolower($class_migrations);
            echo "Migration {$class_migrations}".EXT." created!".br();
            echo "<hr />";

            if ( ! $values['crud'])
            {
                $handle = @fopen(RUTA_MODELS.$table.'_model'.EXT, 'w+');
                $result = @fwrite($handle, $file);
                @fclose($handle);
                continue;    
            }

            $module_dir = RUTA_MODULOS.$table;

            if ( ! is_dir($module_dir))
            {
                @mkdir($module_dir);
            }

            if ( ! is_dir($module_dir.'/models/'))
            {
                @mkdir($module_dir.'/models/');
            }

            $handle = @fopen($module_dir.'/models/'.$table.'_model'.EXT, 'w+');
            $result = @fwrite($handle, $file);
            @fclose($handle);

            $model = strtolower($table);
            echo "Model {$model}_model".EXT." created!".br();

            $table_values = $values['columns'];

            $new_array = array();
            foreach ($field_name as $key => $val)
            {
                if (isset($table_values[$key]))
                {
                    $table_values[$val] = '';
                    unset($table_values[$key]);
                }
            }

            unset($table_values['id']);
            unset($table_values['uid']);
            unset($table_values['password']);


            $table_values = array_keys($table_values);
            $total_items  = count($table_values);
            $table_headers = implode("', \n\t\t\t '", array_map('ucfirst', $table_values));
            $table_headers = str_replace('_', ' ', $table_headers);
            $table_values = implode(", \n\t\t\t\t\t \$row->", $table_values);

            $class_name = strtolower($class);

            $insert = array();
            $update = array();

            foreach ( $values['columns'] as $key => $val)
            {
                if ($key == 'active')
                {
                    continue;
                }

                if ($key == 'password')
                {
                    $insert[] = "\$save['password'] = salt_it(_post('password'));";
                    $update[] = "\$save['password'] = salt_it(_post('password'));";
                    continue;
                }

                if ($key != 'id' AND $key != 'uid')
                {                    
                    $insert[] = "\$save['$key'] = _post('$key');";
                    $insert[] = "\$save['uid'] = _uid('{$class_name}'); ";
                    $update[] = "\$save['$key'] = _post('$key');";
                }
                
                if ($key == 'uid')
                {
                    $update[] = "\$row = \$this->{$table}_model->find(_post('uid'));";
                    $update[] = '';
                    $update[] = "if (\$row->num_rows() == 0)";
                    $update[] = "{";
                    $update[] = "\t Message::error('Error','{$table}');";
                    $update[] = "}";
                    $update[] = '';
                    $update[] = "\$save['id'] = \$row->row()->id;";
                }
            }

            $insert = implode("\n\t\t\t", $insert);
            $update = implode("\n\t\t\t", $update);

            $model = strtolower($table);

            $relation = '';
            foreach ( $values['columns'] as $key => $val)
            {
                if (in_array($key, $values['relations']))
                {
                    $relation = array_keys($values['relations'], $key);
                    $relation = $relation[0];
                    $load_relation_model = "\t\t\$this->load->model('{$relation}_model');";

                    $relation = <<<RELATION
        \${$relation} = \$this->{$relation}_model->find_all();
        \$data['options'] = get_select_options(\${$relation}->result(), 'id', 'name');
RELATION;
                }
            }

            $controller = <<<CONTROLLER
<?php

class {$class} extends Admin_Controller {
    
    function __construct()
    {
        parent::__construct();
        \$this->load->model('{$model}_model');
    }

    function index()
    {
        \$this->view();
    }

    function view()
    {
        \$this->load->library('table');

        \$rows = \$this->{$model}_model->find_all();
        
        if (\$rows->num_rows() > 0)
        {
            foreach (\$rows->result() as \$row)
            {
                \$detalles = anchor("{$class_name}/{\$row->uid}/details", 'Detalles');
                \$editar   = anchor("{$class_name}/{\$row->uid}/edit", 'Editar');
                \$eliminar = anchor("{$class_name}/{\$row->uid}/remove", 'Eliminar');

                \$this->table->add_row(array(
                     \$row->{$table_values},
                     \$detalles,
                     \$editar,
                     \$eliminar
                ));
            }
        }
        else
        {
            \$this->table->add_row('No hay registros|colspan="$total_items"'); 
        }

        \$this->table->add_heading(array(
             '$table_headers',
             '&nbsp;|colspan="3"'
        ));

        \$data['table_{$table}'] = \$this->table->generate(array('class' => 'table-full'));
    
        \$this->template->set_content('view_all')
                        ->render(\$data);
    }

    function create()
    {
        \$data = array();
        $load_relation_model
        $relation
        \$this->template->set_content('create')
                        ->render(\$data);
    }

    function save()
    {
        if ( ! _post('uid'))
        {
            \$save = array();
            $insert 
        }
        else
        {
            $update   
        }

        if (\$this->{$model}_model->save(\$save))
        {
            Message::success('Guardado', '{$table}');
        }

        Message::error('Error', {$table});
    }

}
CONTROLLER;

            if ( ! is_dir($module_dir.'/controllers/'))
            {
                @mkdir($module_dir.'/controllers/');
            }

            $handle = @fopen($module_dir.'/controllers/admin'.EXT, 'w+');
            $result = @fwrite($handle, $controller);
            @fclose($handle);

            echo 'Controller '.$table.EXT.' created!'.br();

            if ( ! is_dir($module_dir.'/views/'))
            {
                @mkdir($module_dir.'/views/');
            }

            $all = <<<ALL
<div class="box col-4">
    <div class="box-container">
        <?php echo anchor('{$table}/create', 'Nuevo', array('class' => 'button', 'style' => 'margin-bottom: 10px;float:right')); ?>
        <?php echo \$table_{$table}; ?>
    </div>
</div>
ALL;

            $handle = @fopen($module_dir.'/views/view_all'.EXT, 'w+');
            $result = @fwrite($handle, $all);
            @fclose($handle);
            echo 'View view_all'.EXT.' created!'.br();

            $form = array();
            foreach ( $values['columns'] as $key => $val)
            {
                if ($key == 'id' OR $key == 'uid' OR $key == 'active')
                {
                    continue;    
                }

                if (strpos($key, '_') !== FALSE)
                {
                    $label = ucfirst(implode(' ', array_map('ucfirst', explode('_', $key))));
                }
                else
                {
                    $label = ucfirst($key);
                }

                if ($key == 'password')
                {
                    $form[] = "<li>
                                    <?php echo Form::label('$label', '$key'); ?>
                                    <?php echo Form::password(array('name' => '$key', 'id' => '$key')); ?>
                                </li>";
                }
                else
                {
                    if (in_array($key, $values['relations']))
                    {
                        $label = str_ireplace('Id ', '', $label);
                        $form[] = "<li>
                                        <?php echo Form::label('$label', '$key'); ?>
                                        <?php echo Form::select(\$options,'',array('name' => '$key', 'id' => '$key')); ?>
                                    </li>";
                    }
                    else
                    {                        
                        $form[] = "<li>
                                        <?php echo Form::label('$label', '$key'); ?>
                                        <?php echo Form::text(array('name' => '$key', 'id' => '$key')); ?>
                                    </li>";
                    }
                }
            }

            $form = implode("\n\t", $form);

            $all = <<<ALL
<div class="box col-4">
    <div class="box-container">
        <?php echo Form::open('{$table}/save', array('class' => 'content-forms inline')); ?>
            <ul>
                $form
                <li>
                    <?php echo Form::button('Guardar', array('class' => 'button','type' => 'submit')) ?>
                </li>
            </ul>
        <?php echo Form::close(); ?>
    </div>
</div>
ALL;

            $handle = @fopen($module_dir.'/views/create'.EXT, 'w+');
            $result = @fwrite($handle, $all);
            @fclose($handle);

            echo 'View create'.EXT.' created!'.br();

           
        }
        $migrations = Migrations::getInstance();
        $migrations->set_verbose(true);
        $migrations->install();
        //$migrations->version(0);
        echo $migrations->error;
       /* $this->load->model('users_profiles_model');
        $this->load->model('users_model');

        
        debug($this->users_profiles_model->find_by_attr(array(
            'users_profiles.name' => 'admin',
            'users_profiles.active' => 1
        ))->result());

        echo $this->db->last_query();

        debug($this->users_model->find_by_attr(array(
            'users.first_name' => 'admin',
            'users.active' => 1
        ))->result());

        echo $this->db->last_query();
/*
        $migrations = Migrations::getInstance();
        $migrations->set_verbose(true);
        $migrations->install();
        //$migrations->version(0);
        echo $migrations->error;

       /* if ($this->db->table_exists('users'))
        {
        	echo 'si';
        }
        else
        {
        	echo 'no';
        }
        exit;
		$this->load->view('login');*/
	}

    private function _get_type($type, $field = '')
    {
        $type = explode(' ', $type);
        $add = '';
        $default = '';
        
        $val = 0;
        $null = ' NOT NULL';
                
        if (in_array('null', $type))
        {
            $null = '';
        }
        
        if (strpos($type[0], '(') !== FALSE)
        {
            $val = trim(str_ireplace(')', '',preg_replace('/(.*\()/', '', $type[0])));
        }
        
        if (stripos($type[0], 'int') !== FALSE)
        {
            $type[0] = 'int';
        }
        
        if (stripos($type[0], 'string') !== FALSE)
        {
            $type[0] = 'string';
        }
        
        foreach ($type as $t)
        {       
            if (stripos($t, 'default') !== FALSE)
            {
                $default = str_ireplace('default=', '',$t);
                $default = " DEFAULT '$default'";
            }
        }
        
        if (in_array('index', $type) OR in_array('INDEX', $type))
        {
            $add .= ", \n\tKEY `{$field}` (`{$field}`)";
        }
    
        if (in_array('fulltext', $type) OR in_array('FULLTEXT', $type))
        {
            $add .= ", \n\tFULLTEXT KEY `{$field}` (`{$field}`)";
        }       
        
        switch ($type[0])
        {
            case 'int':             
                $val = $val == 0 ? 11 : $val;
                $type = "int(11)$null";
                break;
            case 'string':              
                $val = $val == 0 ? 20 : $val;
                $type = "varchar($val) $null";
                break;
            case 'text':
                $type = "text$null";
                break;
            case 'datetime':
                $type = "datetime$null";
                break;
            case 'boolean':
            case 'bool':
                $type = "tinyint(1)$null";
                break;
        }
        $this->_keys .= $add;
        return $type . $default;
    }

    function camel_to_upper($item)
    {
        return ucfirst($item);
    }

}




function copy_dir($name)
{
	if ( ! is_null($name))
		{
			$new_folder = $_SERVER['DOCUMENT_ROOT'] . '/' . $name;

			if ( ! is_dir($new_folder))
			{
				recurse_copy(PATH, $new_folder);
			}		

			$files = array();
			$filepath = RUTA_CONFIG . 'config'. EXT; 
			$files[$filepath] = file($filepath, FILE_IGNORE_NEW_LINES);
	        array_unshift($files[$filepath], '');

	        $i = 0;

	        foreach ($files[$filepath] as $line)
	        {
	        	if (strpos($line, '$config[\'base_url\'] .= "://".$_SERVER[\'HTTP_HOST\']  . \'/boilerplate/\';') !== FALSE)
	        	{
	        		$files[$filepath][$i] = '$config[\'base_url\'] .= "://".$_SERVER[\'HTTP_HOST\']  . \'/'.$name.'/\';';
	        	}	
	        	$i++;
	        }

	        $file = implode("\n", $files[$filepath]);

	        $handle = @fopen($new_folder . '/application/config/config' . EXT, 'w+');
	        $result = @fwrite($handle, $file);
	        @fclose($handle);
        }
}

function recurse_copy($src,$dst) 
{ 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 