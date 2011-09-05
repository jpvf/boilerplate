<?php if ( ! defined('BASE')) exit('Acceso directo prohibido');

class Loader_Exception extends Exception{}
/**
 * @author JuanPablo
 * Clase para cargar las librerias, archivos de idioma y scripts
 */
class Loader{
	
	/**
	 * @var objeto loader, usado en el singleton
	 */
	private static $instance; 
    public $objects = array();
    public $controlador = '';
    private $_files;
		
	/**
	 * constructor de la clase
	 * @return void
	 */
	function __construct()
	{
		//show(__CLASS__ . ' iniciada <br>');
        spl_autoload_register(array($this, 'library'));
	}
	
	/**
	 * Singleton para usar el objeto del loader.
	 * @return objeto
	 */
	public static function getInstance() 
    {        
        if ( ! self::$instance) 
        { 
            self::$instance = new Loader(); 
        }         
        return self::$instance; 
    }

	private function _str_to_array($string = '')
	{
		if (is_string($string))
		{
		    if (strpos($string, ','))
		    {
		       $string = explode(',', $string);
		    }
		    else
		    {
		       $string = array($string);
		    }
		}

		return $string;
	}
	/**
     * Cargar librerias quee llegan desde un array, si existe no la carga de nuevo
     *
     * @param  array|string
     * @return true|false
     */
	function library($librerias = NULL)
	{
		if (is_null($librerias))
		{
			return;		
		}

		$librerias = $this->_str_to_array($librerias);

		foreach ($librerias as $libreria)
		{	    
		    $objeto = $libreria;
		    		    
		    if ( is_array($libreria))
		    {
		        $objeto    = array_values($libreria);		        
                $objeto    = $objeto[0];
                
                $libreria  = array_keys($libreria); 
                $libreria  = $libreria[0];     
		    }
		    
		    $clase = $libreria;
            
		    
		    if (strpos($libreria, '/') !== FALSE)
            {
                list($directorio, $clase) = explode('/', $libreria);
            }
            
		    if (strpos($objeto, '/') !== FALSE)
            {
                list($directorio, $objeto) = explode('/', $libreria);
            }
		    
		    $directories = array(
		    	RUTA_CORE.$libreria.EXT 											   => TRUE,
		    	RUTA_LIBRERIAS_CORE.$libreria.EXT 									   => TRUE,
		    	RUTA_LIBRERIAS.$libreria.EXT 										   => TRUE,
		    	RUTA_MODULOS.Router::getInstance()->carpeta.'libraries/'.$libreria.EXT => TRUE,
		    	RUTA_APP_CORE.$libreria.EXT 										   => FALSE
			);

			$file = NULL;
			$create_object = FALSE;

			foreach ($directories as $dir => $obj)
			{
				if (file_exists($dir))
				{
	    			include_once($dir);	
	    			    				
	    			if (class_exists($clase) AND $obj)
	    			{	
	    				$clase = ucfirst($clase);
	    			    $this->objects[$objeto] = new $clase;    			    
	    			    $controller = Controller::getInstance();
	    			    $controller->$objeto = $this->objects[$objeto];    			
	    			}
				}
			}					
		}


		return $this;
		
	}
	
	/**
	 * 
	 * Cargara un paquete que consiste en cargar un archivo bootstrap o de inicio, cargara por defecto
	 * un archivo llamado como el paquete y este se encargara de cargar lo que sea necesario para su 
	 * funcionamiento.
	 * 
	 * @param $name
	 */
	function package($name = '')
	{
		$dir = RUTA_SISTEMA . '/packages/' . $name;
		
		if (is_dir($dir))
		{
			$file = $dir . '/' . $name . EXT;
			
			if (file_exists($file))
			{
				include($file);
			}
		}
	}
	
	function file($file)
	{
		if (file_exists($file))
		{
			include($file);
		}
		else
		{
			//error
		}
	}

	function set_vars($var = array(), $value)
	{
		if (is_string($var))
		{
			$var = array($var => $value);
		}

		foreach ($var as $key => $val)
		{
			$this->$key = $val;
		}

		return $this;
	}

	function view($file = NULL, $data = array(), $return = FALSE)
	{
		if (is_null($file))
		{
			throw new Loader_Exception('There must be a view file to load, empty values can\'t be used');
		}

	    $view = RUTA_VIEWS . $file . EXT;
	    
		if ( ! file_exists($view))
		{
			$view = RUTA_MODULOS . '/' . router::getInstance()->carpeta . '/views/' . $file . EXT;

			if ( ! file_exists($view))
			{
				throw new Loader_Exception('The specified view could not be found');
			}
		}
				
		foreach (controller::getInstance() as $key => $val)
		{
			$this->$key = $val;
		}		
		
		if ($data != NULL)
		{
			extract($data);
		}
						
		if ($return === TRUE)
		{
		    ob_start();
		    include($view);
            $contents = ob_get_contents();             
            ob_end_clean();
            return  $contents;
		}
		else
		{
		    ob_start();
            include($view);
            ob_end_flush();
		}
		
	}
	
	
		/**
	 * Recibe el nombre del archivo de un modelo, se le agregan datos necesarios
	 * para crear la ruta absoluta.Luego de esto instancia el objeto del modelo, 
	 * si el archivo existe lo incluye sino envia un 404 y termina la ejecucion
	 * 
	 * @param $model
	 * @return void
	 */
	function model($model = '', $obj = '', $create_object = TRUE)
	{
		$file = RUTA_MODELS . $model . EXT;

		if (file_exists($file))
		{
			include_once($file);
		}
		else
		{
			$uri = Uri::getInstance();
			$segments = $uri->fetch_uri();
			$module_file = RUTA_MODULOS . router::getInstance()->carpeta. '/models/' . $model . EXT;
    		$carpeta = '';
			
			if (strpos($model, '/') !== FALSE)
            {
                list($carpeta, $model) = explode('/', $model);                
            }
            
            $file = RUTA_APP.'/models/'.$model.EXT;
			
			if (file_exists($file))
			{
			    include_once($file);
			}
			elseif (file_exists($module_file))
			{
			    include_once($module_file);
			}
			else
			{				
                throw new Loader_Exception('The model specified could not be found.'.$model);
			}
		}
		
        if (strpos($model, '/') !== FALSE)
		{
		    list($carpeta, $model) = explode('/', $model);
		}
		
		if ($create_object === TRUE)
		{
			$obj = ($obj == '') ? $model : $obj ;
			$base = controller::getInstance(); 
			$model = ucfirst($model);
			$base->$obj = new $model;
		}
	}

	function autoload_model()
	{
		$model = func_get_arg(0);
		$this->model($model, '', FALSE);
	}
	
	function helper($helpers = '')
	{
	    $helpers = $this->_str_to_array($helpers);	 


		foreach($helpers as $helper)
		{
			$directories = array(
				RUTA_HELPERS_CORE.$helper.EXT,
				RUTA_HELPERS.$helper.EXT,
				RUTA_MODULOS.Router::getInstance()->carpeta.'/helpers/'.$helper.EXT
			);

			foreach ($directories as $file)
			{
				if (file_exists($file))
				{
					include_once($file);
				}
			}
		}
		return $this;				
	}
	
			
}	

/* End of file loader.phtml */
/* Location: /system/loader.phtml */