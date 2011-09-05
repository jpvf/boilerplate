<?php if ( ! defined('BASE')) exit('Acceso directo prohibido');

/**
 * Clase URI para el manejo de los parametros que entran por la URI.
 *
 */
class Uri{

    private static $instance;
    private $uri_string;
    private $segments;
    private $fetch_uri;
    var $rsegments = array();

    /**
     * Retorna el objeto que se instancia la primera vez, asi se evita crear basura con los objetos
     * @return uri
     */
    public static function getInstance()
    {
        if ( ! self::$instance)
        {
            self::$instance = new Uri;
        }
        return self::$instance;
    }
    
    function __construct()
    {
        //show(__CLASS__ . ' iniciada <br>');
        
        $this->input    = Input::getInstance();
        $this->init($this->input->server('REQUEST_URI',TRUE));

        return $this;
    }

    function init($uri = '')
    {
        $security = Security::getInstance();
        
        $host  = Config::get('base_url');
        $index = Config::get('index_page');
        
        if ($index != '' AND strpos($uri, $index) === FALSE)
        {
            $uri .= $index;
        }

        if (empty($index))
        {
            $uri = str_replace(dirname($this->input->server('SCRIPT_NAME')),'', $uri);
            $segments = explode('/', $uri); 
        }
        else
        {
            $uri = str_replace($this->input->server('SCRIPT_NAME'),'', $uri);
            $segments = explode('/', str_replace('/' . $index,'', $uri)); 
        } 

        $this->segments = $segments; 

        foreach ($segments as $key => $val)
        {
          $this->rsegments[] = $security->xss_clean($val);
        }
        
        return $this;
    }
    
    function get($param = NULL)
    {       
        if (is_null($param))
        {
            return $this->get_uri_string();
        }
        return (isset($this->segments[$param])) ? $this->segments[$param] : '';
    }
    
    
    function fetch_uri()
    {
        $this->fetch_uri = $this->segments;        
        return $this->fetch_uri;
    }
    
    function get_uri_string()
    {
        $this->uri_string = implode('/',$this->segments);
        return $this->uri_string;
    }

}