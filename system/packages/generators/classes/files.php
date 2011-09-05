<?php 

class Files_Generator
{
	
	function __construct()
	{
		
	}
	
	function __call($func, $args)
	{
		$new_args = array();
		$new_args[] = $func;
		
		foreach ($args as $arg)
		{
			$new_args[] = $arg;
		}
		
		call_user_func_array(array(&$this, '_generate_file'), $new_args);
	}
	
	private function _generate_file($tipo, $name = NULL, $func = NULL)
	{
		if (is_null($name))
		{
			echo 'Debe especificar un nombre';
			return FALSE;
		}
		
		$functions = '';
		$body = htmlentities($this->_body_template($tipo, $name));
		
		if ($tipo == 'controller')
		{
			$functions .= $this->_function_template('index');
		}
		
		if ( ! is_null($func))
		{	
			foreach ($func as $key => $val)
			{
				$functions .= $this->_function_template($key, $val);
			}
		}
		
		$body = str_ireplace('CONTROLLER_CONTENT_TO_BE_REPLACED', $functions, $body);
		
		debug($body);
	}
	
	
	private function _function_template($name, $params = '', $private = FALSE)
	{
		$function = $private === FALSE ? 'function ' : 'private function _' ;
		$name = strtolower($name);
		$function = <<<FUNCTION
		
	{$function}{$name}($params)
	{
	
	}

FUNCTION;
		return $function;
	}
	
	private function _body_template($tipo, $name)
	{
		$name = ucfirst(strtolower($name));
		
		if ($tipo == 'model')
		{
			$tipo = 'Model';
			$name = $name . '_Model';
		} 
		else 
		{
			$tipo = 'MY_Controller';
		}
		
		$body = <<<BODY
<?php 

class $name extends $tipo 
{ 
	CONTROLLER_CONTENT_TO_BE_REPLACED
}
BODY;
		return $body;
	}
	
	
		
	
}