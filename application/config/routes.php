<?php 
/* 
 * Configuracion de las rutas del sistema
 * 
 * Es posible configurar rutas de cualquier forma, ejemplo: 
 * 
 * Ruta real
 *  
 *  /controlador/metodo/variables/
 *  
 *   o si esta dentro de una carpeta
 * 
 *  /carpeta/controlador/metodo/variables/
 *  
 * 
 * $route['ruta_del_navegador'] = 'ruta_real';
 * 
 * (:numero) significa que puede va a llegar un numero en el segmento de la uri
 * (:letra) significa que llegara una cadena alfanumerica
 * 
 * Con el signo $ se identifica donde se va a ubicar el reemplazo que se haga y el numero que lo
 * acompaña indica, de izquierda a derecha, el indice del reemplazo, si se tienen (:numero)/(:letra)
 * donde se reemplaza (:numero) sera $1 y donde se reemplaza (:letra) será $2 por ejemplo: 
 * 
 * uri entrante = 'controlador/2/3'
 * 
 * $route['controlador/(:numero)/(:numero)'] = 'controlador/index/$1/$2'
 * 
 * $1 = 2 
 * $2 = 3
 * 
 * daria como resultado
 * 
 * controlador/index/2/3 
 * 
 */

$routes['admin/(:letra)/(:letra)/(:cualquiera)/(:cualquiera)'] = '$1/admin/$2/$3/$4';
$routes['admin/(:letra)/(:letra)/(:cualquiera)'] 			   = '$1/admin/$2/$3';
$routes['admin/(:letra)/(:letra)']			     			   = '$1/admin/$2';
$routes['admin/(:letra)'] 					     			   = '$1/admin';
$routes['admin']											   = 'dashboard/admin';

$routes['(:cualquiera)/admin/(:cualquiera)/(:cualquiera)/(:cualquiera)/'] = '404';
$routes['(:cualquiera)/admin/(:cualquiera)/(:cualquiera)'] 	   = '404';
$routes['(:cualquiera)/admin/(:cualquiera)/'] 				   = '404';
$routes['(:cualquiera)/admin'] 					     		   = '404';

/*
$routes['my_tasks']                                       = 'tasks/my_tasks';
$routes['my_tasks/index']                                 = 'tasks/my_tasks';
$routes['projects/(:numero)/tickets/(:numero)/([a-z_]+)'] = 'tickets/$3/$1/$2';
$routes['([a-z_]+)/(:numero)/([a-z_]+)/(:numero)']        = '$1/$3/$2/$4';
$routes['([a-z_]+)/(:numero)/([a-z_]+)']                  = '$1/$3/$2';
$routes['([a-z_]+)/(:numero)']                            = '$1/index/$2';
 
$route['projects/(:numero)/([a-z_]+)']           = 'projects/$2/$1';
$route['messages/(:numero)/([a-z_]+)/(:numero)'] = 'messages/$2/$1/$3';
$route['messages/(:numero)/([a-z_]+)']           = 'messages/$2/$1';
$route['messages/(:numero)']                     = 'messages/index/$1';
*/