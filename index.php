<?php
/**
* Nombre de la carpeta donde se encuentra la aplicacion, si se quiere guardarla en otra carpeta
* se crea la carpeta o se cambia el nombre con la estructura establecida.
*/
$application_folder = 'application';

/**
* Constantes base del sistema, extension, rutas al core, al sistema y a la carpeta del framework
* ademas define la constante BASE para comprobar que se haya ingresado mediante este archivo 
* y no directamente.
*/
define('BASE'        , 1);
define('PATH'        , __DIR__);
define('RUTA_SISTEMA', PATH . '/system');
define('RUTA_CORE'   , RUTA_SISTEMA . '/core/');
define('EXT'         , '.php');

/**
* Incluye las librerias del core del framework.
*/

include(RUTA_CORE    . 'constants'      . EXT);
include(RUTA_PACKAGES. 'debug/debug'    . EXT);
include(RUTA_CORE    . 'error'          . EXT);
include(RUTA_CORE    . 'config'         . EXT);
include(RUTA_CORE    . 'loader'         . EXT);
include(RUTA_CORE    . 'router'         . EXT);
include(RUTA_CORE    . 'language'       . EXT);
include(RUTA_DB      . 'active_record'  . EXT);
include(RUTA_DB      . 'db'             . EXT);
include(RUTA_DB      . 'results'        . EXT);
include(RUTA_DB      . 'forge'          . EXT);
include(RUTA_CORE    . 'migrations'     . EXT);
include(RUTA_CORE    . 'controller'     . EXT);
include(RUTA_CORE    . 'model'          . EXT);
include(RUTA_CORE    . 'uri'            . EXT);
include(RUTA_CORE    . 'input'          . EXT);
include(RUTA_CORE    . 'security'       . EXT);
include(RUTA_LIBRERIAS_CORE . 'session' . EXT);

/**
* Se instancian objetos, el objeto Loader va a autocargar las librerias y helpers definidos en el archivo de 
* configuracion. 
*/

$load        = Loader::getInstance();

Config::load('config, autoload');
$load->helper(Config::get('helpers'));

$router      = Router::getInstance();
$uri         = Uri::getInstance();
$controlador = $router->get_controller();



set_exception_handler('exceptions_handler');

if (Config::get('debug'))
{
    set_error_handler("error_handler");
}
else
{
    error_reporting(0);
}

$load->library(Config::get('libraries'));


//Si llega hasta acá es porque el controlador existe en alguna parte.
include($controlador->archivo);

$clase = $controlador->controlador;

$load->controlador = $controlador->controlador;

/**
* Por si depronto la clase llega con un slash, se revienta, se coge lo necesario
* para evitar conflictos, problemas o cualquier cosa rara que no este prevista...
*/

if (strpos($clase, '/'))
{
    list($vacio, $clase) = explode('/', $clase);
}

/**
* En algunos puntos como el las configuraciones, archivos de lenguage y en general cualquier
* archivo propio de cada modulo es necesario tener en algun punto el folder del archivo al que
* se esta llamando.
*/
list(Config::$folder, $dump) = explode('controllers/', $router->controller_file);

$clase = ucwords($clase);
$clase = new $clase;

if (method_exists($clase, $controlador->metodo) && is_callable(array($clase,$controlador->metodo)))
{       
    $vars = ($controlador->directorio == '') ? array_slice($uri->rsegments, 2) : array_slice($uri->rsegments, 3);

    // Funcion que se ejecuta antes de la funcion solicitada.
    if (method_exists($clase, 'before'))
    {
        call_user_func_array(array($clase, 'before'), $vars);    
    }

    call_user_func_array(array($clase, $controlador->metodo), $vars);   
    
    // Funcion que se ejecuta despues de la funcion solicitada.
    if (method_exists($clase, 'after'))
    {
        call_user_func_array(array($clase, 'after'), $vars);    
    }           
}
else
{
    mostrar_error();
}

/* Fin del archivo index.phtml */