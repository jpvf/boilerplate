<?php

class SQL_Generator{
	
	private $_keys;
	
	function __construct(){}
	
	function generate_table($name = NULL , $fields = NULL, $relation = FALSE)
	{		
		if ($relation === FALSE)
		{
			$fields = 'id:int ' . $fields . ' created_at:datetime index updated_at:datetime index created_by:int index updated_by:int index active:boolean index default=1';
		}
		
		$fields = preg_replace('/ (\w+):/i', ',$1:$2', $fields);
		$fields = explode(',', $fields);
		$new_fields = array();
		
		foreach ($fields as $field)
		{
			$new_fields[] = $this->_add_field($field);
		}
		
		$table = "CREATE TABLE `$name` ( \n\t";
		$table .= (implode(", \n\t", $new_fields)  . $this->_return_keys());
		$table .= "\n ) ENGINE=MYISAM CHARSET=utf8;"; 
		debug($table);
	}
	
	private function _add_field($field)
	{
		list($field, $type) = explode(':', $field);
		$add = '';
		if (trim(strtolower($field)) == 'id')
		{
			$this->_keys .= ",\n \tPRIMARY KEY(`id`)";
			$add = ' AUTO_INCREMENT';
		}
		return $field . ' ' . $this->_get_type($type, $field) . $add;		
	}
	
	private function _get_type($type, $field)
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
				$type = "tinyint(1)$null";
				break;
		}
		$this->_keys .= $add;
		return $type . $default;
	}
	
	private function _return_keys()
	{
		$keys = $this->_keys;
		$this->_keys = '';
		return $keys;
	}
}