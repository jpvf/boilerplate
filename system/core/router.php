<?php if ( ! defined('BASE')) exit('Acceso directo prohibido');

class Router {

    public $directorio  = '';
    public $controlador = '';
    public $carpeta     = '';
	private static $instance;
	
	public static function getInstance()
	{
		if ( ! self::$instance)
		{
			self::$instance = new Router();
		}
		return self::$instance;
	}
	
	function __construct()
    {
        //show(__CLASS__ . ' iniciada <br>');
        $this->uri    = Uri::getInstance();
    }
	
	function get_controller()
	{ 		    
       //Trae la uri actual...
	    $uri = $this->uri->fetch_uri();

        //Es necesario traer al controlador del config?
		if ($this->uri->get_uri_string() == '/' OR ! $this->uri->get_uri_string())
        {
            $uri = $this->_set_default_controller();
        }

        //Revisa las rutas predefinidas para sobreescribir la actual
        $segments = $this->_rutas($uri);     

        //Aun no hay metodo?
        if ( empty($this->metodo) OR ! isset($this->metodo))
        {
            $this->metodo = ( ! empty($segments[1])) ? $segments[1] : 'index';
        }

		return $this->_load_controller();
	}
	
	private function _set_default_controller()
	{ 
        Config::load('config');
	    if (strpos(Config::get('default_controller'), '/') !== FALSE)
        {
            $this->uri->init('/'.Config::get('index_page').'/'.Config::get('default_controller').'/');
            return $this->uri->fetch_uri();
        }
        return explode('/', '/'.Config::get('default_controller').'/');
	}
	
	private function _rutas($segments = array())
	{
        Config::load('routes');
        $routes = Config::get_group('routes');
        
	    $uri = array();
	    
	    foreach ($segments as $segment)
	    {	    
	       if ( ! empty($segment))
	       {	           
	           $uri[] = $segment;	           
	       }	       
	    }	    

	    $segments = $uri;
	    
	    $uri = implode('/', $segments);

        if (isset($routes->$uri))
        {
            return $this->_validar_peticion(explode('/', $routes->$uri));
        }

        foreach ($routes as $key => $val)
        {
            $key = str_replace(':cualquiera', '.+', str_replace(':letra', '[a-z_-]+', str_replace(':numero', '[0-9]+', $key)));

            if (preg_match('#^'.$key.'$#', $uri))
            {
                if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
                {
                    $val = preg_replace('#^'.$key.'$#', $val, $uri);        
                                
                }
                $this->uri->rsegments = explode('/', $val);
                return $this->_validar_peticion(explode('/', $val));
            }
        }
        
        $this->uri->rsegments = explode('/', $uri);
        return $this->_validar_peticion($segments);
	}
		
	private function _validar_peticion($segments = array())
	{
       //Es un modulo?

        if (is_dir(RUTA_MODULOS . $segments[0]))
        {
            $segments[1] = (isset($segments[1])) ? $segments[1] : '';

            //Es una subcarpeta con nombre distinto al de la carpeta?
            if (is_dir(RUTA_MODULOS . $segments['0'] . '/controllers/' . $segments[1]))
            {
                $segments[2] = (isset($segments[2])) ? $segments[2] : '';

                //es un archivo dentro de la subcarpeta?
                if (file_exists( RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[1] . '/' . $segments[2] .EXT))
                {
                    $this->carpeta = $segments[2];
                    $this->directorio  = '';
                    $this->controlador = $segments[2];
                    $this->metodo      = (isset($segments[3])) ? $segments[3] : 'index';
                    $this->controller_file =  RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[1] . '/' . $segments[2] .EXT;
                    return $segments;
                }
                //Es un archivo pero con distinto nombre a la carpeta del modulo?
                if (file_exists( RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[1] .EXT))
                {
                    $this->carpeta = $segments[1];
                    $this->directorio = '';
                    $this->controlador = $segments[1];
                    $this->metodo      = (isset($segments[2])) ? $segments[2] : 'index';
                    $this->controller_file = RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[1] .EXT;
                    return $segments;
                }

            }
             //Es entonces un modulo con nombre de carpeta y archivo diferente?
            if (file_exists( RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[1] .EXT))
            {
                $this->carpeta = $segments[0];
                $this->metodo = (isset($segments[2])) ? $segments[2] : 'index';
                $this->directorio = $segments[1];
                $this->controlador = $segments[1];
                $this->controller_file = RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[1] .EXT;    
                return $segments;            
            } 

            //Es entonces un modulo con nombre de carpeta y archivo igual?
            if (file_exists( RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[0] .EXT))
            {
                $this->carpeta = $segments[0];
                $this->metodo = (isset($segments[1])) ? $segments[1] : 'index';
                $this->directorio = '';
                $this->controlador = $segments[0];
                $this->controller_file = RUTA_MODULOS . $segments[0] . '/controllers/' . $segments[0] .EXT;    
                return $segments;            
            } 
        }        

        //Es un directorio dentro de la carpeta controllers?
        if (is_dir(RUTA_CONTROLLERS . $segments[0]))
        {
            $this->set_directorio($segments[0]);

            $segments = array_slice($segments, 1);
            
            //Es un archivo dentro del directorio?
            if (file_exists(RUTA_CONTROLLERS . $this->directorio . '/' . $segments[0].EXT))
            {
                $this->controlador = $segments[0];
                $this->controller_file = RUTA_CONTROLLERS . $this->directorio . '/' . $segments[0].EXT;
                return $segments;
             }
        }
        //FInalmente, es simplemente un archivo dentro de la carpeta base de controllers?
        elseif (file_exists(RUTA_CONTROLLERS . $segments[0] .EXT))
        {
            $this->directorio = '';
            $this->controlador = $segments[0];
            $this->controller_file = RUTA_CONTROLLERS . $segments[0] .EXT;
            return $segments; 
        }

        //Si llega hasta aca es que no hay mas que hacer.
		Error::getInstance()->trigger_error(404);
	}
		
	private function _load_controller(){
	    return (object) array('controlador' => $this->controlador,  
	                          'metodo'      => $this->metodo, 
	                          'directorio'  => $this->directorio,
	                          'archivo'	    => $this->controller_file);
		
	}

}