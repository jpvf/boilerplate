<?php if ( ! defined('BASE')) exit('Acceso directo prohibido');

class Database_Exception extends Exception{}

class Active_Record
{

    var $result;
    protected $result_object;

    private $join     = array();
    private $select   = '';
    private $from     = '';
    private $where    = '';
    private $group_by = '';
    private $having   = '';
    private $order_by = '';
    private $limit    = ''; 
    private $data     = array();
            
    
    function get($table = '', $limit = '', $where = '')
    {
        if ($this->select == '')
        {        
            $this->select('*');
        }

        if ($table != '')
        {
            $this->from($table);
        }
        else
        {
            throw new Database_Exception('You must specify a table name for the select.');
        }

        if ($where != '')
        {
            $this->where($where);
        }

        if ($limit != '')
        {
            $this->limit($limit);
        }

        return $this->query();
    }

    function set($key = '', $val = '', $escape = TRUE)
    {
        $this->data[$this->_protect_identifiers($key)] = ($escape === TRUE) ? "'$val'" : $val;
        return $this;   
    }

    private function _set_values($values = array())
    {
        if (count($values) > 0)
        {          
            foreach ($values as $key => $val)
            {
                $this->set($key , $val);
            }  
        }            
    }

    private function _protect_identifiers($item = '', $prefix_single = FALSE, $protect_identifiers = NULL, $field_exists = TRUE)
    {
        $this->_reserved_identifiers = array('*');
        if ( ! is_bool($protect_identifiers))
        {
            $protect_identifiers = TRUE;
        }

        if (is_array($item))
        {
            $escaped_array = array();

            foreach($item as $k => $v)
            {
                $escaped_array[$this->_protect_identifiers($k)] = $this->_protect_identifiers($v);
            }

            return $escaped_array;
        }
        $item = trim($item);

        // Convert tabs or multiple spaces into single spaces
        $item = preg_replace('/[\t ]+/', ' ', $item);

        // If the item has an alias declaration we remove it and set it aside.
        // Basically we remove everything to the right of the first space
        $alias = '';
        if (strpos($item, ' ') !== FALSE)
        {
            $alias = strstr($item, " ");
            $item = substr($item, 0, - strlen($alias));
        }

        // This is basically a bug fix for queries that use MAX, MIN, etc.
        // If a parenthesis is found we know that we do not need to
        // escape the data or add a prefix.  There's probably a more graceful
        // way to deal with this, but I'm not thinking of it -- Rick
        if (strpos($item, '(') !== FALSE)
        {
            return $item.$alias;
        }

        // Break the string apart if it contains periods, then insert the table prefix
        // in the correct location, assuming the period doesn't indicate that we're dealing
        // with an alias. While we're at it, we will escape the components
        if (strpos($item, '.') !== FALSE)
        {
            $parts  = explode('.', $item);


            if ($protect_identifiers === TRUE)
            {
                $item = $this->_escape_identifiers($item);
            }

            return $item.$alias;
        }


        if ($protect_identifiers === TRUE AND ! in_array($item, $this->_reserved_identifiers))
        {
            $item = $this->_escape_identifiers($item);
        }

        return $item.$alias;
       /* $val = trim($val);

        if (strpos($val, '.') !== FALSE)
        {
            $alias = '';
            if (stripos($val, ' as ') !== FALSE)
            {
                list($val, $alias) = explode(' as ', $val );       
                $alias = " as `$alias`";
            }
            $values = explode('.', $val);
            $protected = '`' . implode('`.`' , $values) . '`' . $alias;
        }
        else
        {
            $protected = '`' . $val . '`';
        }

        return $protected;*/
    }

    function _escape_identifiers($item)
    {
        $this->_escape_char ='';
        if ($this->_escape_char == '')
        {
            return $item;
        }

        foreach ($this->_reserved_identifiers as $id)
        {
            if (strpos($item, '.'.$id) !== FALSE)
            {
                $str = $this->_escape_char. str_replace('.', $this->_escape_char.'.', $item);  
                
                // remove duplicates if the user already included the escape
                return preg_replace('/['.$this->_escape_char.']+/', $this->_escape_char, $str);
            }       
        }
        
        if (strpos($item, '.') !== FALSE)
        {
            $str = $this->_escape_char.str_replace('.', $this->_escape_char.'.'.$this->_escape_char, $item).$this->_escape_char;            
        }
        else
        {
            $str = $this->_escape_char.$item.$this->_escape_char;
        }
    
        // remove duplicates if the user already included the escape
        return preg_replace('/['.$this->_escape_char.']+/', $this->_escape_char, $str);
    }
    
    function insert($values = array(), $tabla = '')
    {
        $this->_set_values($values);

        if (count($this->data) == 0)
        {
            return FALSE;    
        }

        $tabla = $this->_protect_identifiers($tabla);

        $sql = "INSERT INTO $tabla \n";
        $sql .= "(" . implode(',' , array_keys($this->data)) . ") \n";
        $sql .= "VALUES \n";
        $sql .= "(" . implode(",", $this->data) . ") \n";

        $this->_reset_query();        
        return $this->query($sql, TRUE);
    }
    
    function update($values = array(), $tabla = '', $where = '')
    {
        $this->_set_values($values);

        if (count($this->data) == 0)
        {
            return FALSE;
        }

        $values = array();

        foreach ($this->data as $key => $val)
        {
            $values[] = $key . ' = ' . $val;
        }
        
        $sql = "UPDATE $tabla \n SET ";
        
        $sql .= implode(", \n", $values);
        
        if ($where != '' OR $this->where != '')
        {
            $this->where($where);

            $sql .= " \n WHERE " . $this->where . "\n";
        }
        
        $this->_reset_query();
        
        return $this->query($sql, TRUE);    
    }
    
    function select($select = '*')
    {       
        if (is_string($select))
        {
            if (strpos($select,',') !== FALSE)
            {
                $select = explode(',', $select);
            }
            else{
                $select = array($select);
            }
        }

        $items = array();

        foreach ($select as $item)
        {
            if (strpos($item, '*') !== FALSE)
            {
                if (strpos($item, '.') !== FALSE)
                {
                    list($table, $field) = explode('.', $item);
                    $item = $table . '.' . $field;
                }
                $items[] = $item;
            }
            else
            {
                $items[] = $item;
            }
        }
        
        $select = implode(", ", $items);
        
        if ( ! empty($this->select))
        {
            $this->select .= ', ';
        }
        
        $this->select .= $select;
        return $this;
    }    

    function from($from = '')
    {
        $this->from = "($from)";
        return $this;
    }

    function join($table = '', $on = '', $type = '')
    {        
        if (is_array($table))
        {
            foreach ($table as $key => $val)
            {
                if (strpos($val, '|') !== FALSE)
                {
                    list($on, $type) = explode('|', $val);
                }
                else
                {
                    $on = $val;
                }

                $this->join($key, $on, $type);
            }
        }

        if (is_string($table))
        {
            $table = $this->_protect_identifiers($table);

            $on = $this->_protect_operador($on);

            $this->join[] = strtoupper($type) . " JOIN $table ON ( $on )";
        }     
        return $this;         
    }

    private function _protect_operador($on, $protect = TRUE)
    {
        if (preg_match('/([\w\.]+)([\W\s]+)(.+)/', $on, $match))
        {
            if (stripos($match[3], ' AND ') !== FALSE)
            {
                list($last_match , $match_and) = explode(' AND ', $match[3]);
                $final_match = $this->_protect_operador($match_and, $protect);

                if ($protect === TRUE)
                {
                    $last_match = $this->_protect_identifiers($last_match);
                }
                $match[3] = $last_match . ' AND ' . $final_match;
            }
            elseif (stripos($match[3], ' OR ') !== FALSE)
            {
                list($last_match , $match_and) = explode(' OR ', $match[3]);
                $final_match = $this->_protect_operador($match_and, $protect);

                if ($protect === TRUE)
                {
                    $last_match = $this->_protect_identifiers($last_match);
                }

                $match[3] = $last_match . ' OR ' . $final_match;
            }
            else
            {
                if ($protect === TRUE)
                {
                    $match[3] = $this->_protect_identifiers($match[3]);
                }            
            }
            $match[1] = $this->_protect_identifiers($match[1]);
        
            $on = $match[1].$match[2].$match[3];      
        }
        return $on;
    }

    function where($where = '')
    {
        if (is_string($where))
        {                    
            if ($this->where == '')
            {
                $this->where = "";
            }
            
           // $where = $this->_protect_identifiers($where);
            $this->where .= $where;
                       
        }        
        if (is_array($where))
        {
            $vars = array();
            
            foreach ($where as $key => $value)
            {
                if ( ! is_numeric($value))
                {
                     $value = "'$value'";                       
                }

                if ( ! $this->_tiene_operador($key) )
                {
                    $key = "$key =" ;                  
                }

               // $key = $this->_protect_operador($key, FALSE);
                $vars[] = "$key $value";
            }
            $this->where = implode(' AND ', $vars);    
        }
        return $this;
    }    

    

    function group_by($group_by = '')
    {
        if ( ! is_array($group_by))
        {
            if (strpos($group_by, ',') !== FALSE)
            {
                $group_by = explode(',', $group_by);
            }
            else
            {
                $group_by = array($group_by);
            }       
        }        
        
        $items = array();

        foreach ($group_by as $item)
        {
            $items[] = $this->_protect_identifiers($item);
        }

        $this->group_by = implode(",", $items);     
        return $this;   
    }    

    function order_by($order_by = '', $order = 'ASC')
    {
        if ( ! is_array($order_by))
        {

            if (strpos($order_by, 'ASC') !== FALSE)
            {
                $order_by = str_ireplace('ASC', '', $order_by);                
            }

            if (strpos($order_by, 'DESC') !== FALSE)
            {
                $order    = 'DESC';
                $order_by = str_ireplace('DESC', '', $order_by);                
            }

            if (strpos($order_by, ',') !== FALSE)
            {
                $order_by = explode(',', $order_by);
            }
            else
            {
                $order_by = array($order_by);
            }       
        }        

        $items = array();

        foreach ($order_by as $item)
        {
            $items[] = $this->_protect_identifiers($item);
        }

        $this->order_by = implode(",", $items) . " $order"; 
        return $this;
    }

    

    public function having($having)
    {        
        $this->having = $this->_protect_operador($having, FALSE);
        return $this;
    }   

    public function limit($limit = '', $offset = '')
    {        
        if ($offset != '')
        {
            $offset = ', ' . $offset;
        }

        $this->limit = "$limit $offset";

        return $this;
    }

    protected function get_sql()
    {
        $this->sql = '';

        if ($this->select != '')
        {
            $this->sql .= "SELECT {$this->select} \n ";
        }

        if ($this->from != '')
        {
            $this->sql .= "FROM {$this->from} \n";
        }

        if ($this->join != '')
        {
            $this->sql .= implode("\n", $this->join ) . "\n";
        }
           
        if ($this->where != '')
        {
            $this->sql .= "WHERE {$this->where} \n";
        }

        if ($this->group_by != '')
        {
            $this->sql .= "GROUP BY {$this->group_by} \n ";
        }

        if ($this->having != '')
        {
            $this->sql .= "HAVING {$this->having} \n";
        }

        if ($this->order_by != '')
        {
            $this->sql .= "ORDER BY {$this->order_by} \n";
        }

        if ($this->limit != '')
        {
            $this->sql .= "LIMIT {$this->limit} \n";
        }
        
        $this->_reset_query();

        return  $this->sql;
    }

    function _reset_query()
    {               
        $this->select = '';
        $this->from = '';
        $this->where = '';
        $this->join = '';
        $this->group_by = '';
        $this->having = '';
        $this->order_by = '';
        $this->limit = '';        
        $this->data = array();
    }

    private function _tiene_operador($str)
    {
        $str = trim($str);

        if ( ! preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str))
        {
            return FALSE;
        }

        return TRUE;
    }
}