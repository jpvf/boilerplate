<?php
/*
 * Archivo de configuracion general del sistema.* 
 */ 

/*
 * Url del sistema debe contener, el slash del final y el protocolo http.
 */
$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST']  . '/boilerplate/';

/*
 * Esta es la pagina de inicio del sistema por donde todo va a ser enrutado. Si se usa el modrewrite de apache para esconderlo, dejarlo en blanco
 *  asi: "".
 */
$config['index_page']         = "";
/*
 * El modo debug muestra o no los errores de PHP
 */
$config['debug'] 	   		  = TRUE; 

/*
 * El modo dbdebug muestra o no los errores de MySQL
 */
$config['dbdebug']			  = TRUE;

/*
 * Email por defecto del sistema
 */
$config['admin_email'] 		  = "developers@bp.com";

/*
 * Llave para codificar y decodificar dentro del sistema
 */
$config['salt'] 	   		  = "B2579P3468SALT"; 

/*
 * Indica si se deben o no limpiar las variables globales por defecto, puede afectar el rendimiento.
 */
$config['sanitize_globals']   = TRUE; 

/*
 * Indica si se van a utilizar archivos de lenguaje dentro del sistema
 */
$config['lang_files']		  = TRUE; 

/*
 * Lenguaje por defecto, solo las 2 letras que lo identifican: es, en, fr, pt
 */
$config['default_lang']		  = 'es';//idioma por defecto

/*
 * Controlador por defecto, si solo aparece el index.phtml en la url se llegará aca.
 */
$config['default_controller'] = 'welcome'; 

/*
 * Token de validacion en los formularios o donde se necesite
 */
$config['token']			  = md5(sha1(uniqid(rand())));//token para validarlo en los formularios

/*
 * Tiempo de vida de la sesion del ususario
 */
$config['session_time']		  = 30;

/*
 * Se puede utilizar una extension de archivos al final de la url, no afectaran en nada y son unicamente
 * visuales.
 */
$config['url_extension']	  = '';

/*
 * Variable que indica si esta en entorno de desarrollo o en entorno de producción.
 */
$config['devel']              = TRUE;



/* Fin del archivo config.phtml */
/* Ubicacion: /config/config.phtml */