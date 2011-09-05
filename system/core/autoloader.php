<?php 

class Autoloader {

	static function libraries($librerias = array())
	{
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
		    	RUTA_CORE.$libreria.EXT 			=> TRUE,
		    	RUTA_LIBRERIAS_CORE.$libreria.EXT 	=> TRUE,
		    	RUTA_LIBRERIAS.$libreria.EXT 		=> TRUE,
		    	RUTA_APP_CORE.$libreria.EXT 		=> FALSE,
		    	RUTA_DB.$libreria.EXT 				=> TRUE
			);

			$file = NULL;
			$create_object = FALSE;	
			
			foreach ($directories as $dir => $obj)
			{
				if (file_exists($dir))
				{
	    			include_once($dir);	
				}
			}							
		}

	}

}