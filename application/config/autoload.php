<?php 
/*s
 * Archivo de configuracion para auto cargar librerias.
 * 
 * Se pueden autocargar: Librerias, helpers y archivos de lenguaje
 * El formato debe ser : $autoload['tipo'] = array('libreria', 'libreria1');
 * 
 * Solo debe existir un array por cada item.
 */
$autoload['libraries'] = array(
	'datamapper',
	'acl', 
	'modules', 
	'breadcrumbs', 
	'template', 
	'assets', 
	'perms', 
	'form',
	'app_model'
);

$autoload['helpers']   = array(
	'helpers', 
	'debug', 
	'html', 
	'url', 
	'date_helper', 
	'page', 
	'form',
	'error', 
	'users', 
	'tabs', 
	'input', 
	'menu',
	'security', 
	'language',
	'messages',
	'inflector_helper'
);

$autoload['language']  = array();

/* Fin del archivo autoload.phtml */
/* Ubicacion: /config/autoload.phtml */