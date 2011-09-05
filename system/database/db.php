<?php if ( ! defined('BASE')) exit('Acceso directo prohibido');

class db extends Active_Record
{
    
    public $query;
    public $queries = array();
    public $counter = 0;
    public $time    = 0;
    public $result  = null;
    private $_database;

    private $_connection;
    private static $_current_databases;
    private static $instance; 
    
    function __construct($db = null)
    {
        self::$instance = $this;
        $this->_connect();
    }  
    
    
    function __destruct()
    {
        $this->_close();
    }     
    
    public static function getInstance() 
    { 
        if ( ! self::$instance) 
        { 
            self::$instance = new db(); 
        } 
        return self::$instance; 
    }

    private function _list_tables()
    {
        $query = $this->query('SHOW TABLES FROM '.$this->_database);

        $tables = array();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result('array') as $key => $val)
            {
                $tables[] = array_shift($val);
            }
        }

        return $tables;
    }

    function table_exists($table = '')
    {
        if (empty($table))
        {
            return FALSE;
        }   

        $tables = $this->_list_tables();

        if ( in_array($table, $tables))
        {
            return TRUE;
        }
        
        return FALSE;
    }

    function query($query = '', $return_id = FALSE)
    {                        
        $query = empty($query) ? $this->get_sql() : $query;     

        $res             = new results();   
        $res->conn_id    = $this->_connection;
        $res->results_id = $this->_execute($query);

        if ($return_id !== FALSE)
        {
            return $res->results_id;
        }
        return $res;
    }    

    function get_queries()
    {
        return $this->queries;        
    }

    function count_queries()
    {
        return $this->counter;
    }
    
    function time_queries()
    {
        return $this->time;
    }   

    function resource()
    {
        return $this->rows;
    }
            
    function last_id()
    {
        return mysql_insert_id();
    }    
    
    function affected_rows()
    {
        return mysql_affected_rows();
    }
    
    private function _execute($query){
        
        $this->counter   += 1;            
        $start_time       = microtime();
        $rows             = mysql_query($query);
        $end_time         = microtime(); 
        $this->queries[]  = $query;
        $this->time      += $end_time - $start_time;           
        $this->query_time = $end_time - $start_time;        
        $this->_query_error();
        
        return $rows;
    }
    
    function total_time()
    {
        return $this->time;
    }

    protected function _connect()
    {       
        if ($this->_connection)
        {
            return;
        }

        Config::load('db');
        $db = Config::get_group('db');  

        $this->_database = $db['database'];

        $this->_connection = mysql_connect($db['hostname'], $db['username'], $db['password'], TRUE);

        if ( ! $this->_connection)
        {
            throw new Database_Exception(mysql_error($this->_connection), mysql_errno($this->_connection));
        }

        $this->_connection_id = sha1($db['hostname'].'_'.$db['username'].'_'.$db['password']);

        $this->_set_charset('utf8');

        $this->_select_db($db['database']);

        return $this;
    } 

    protected function _select_db($database)
    {
        if ( ! mysql_select_db($database, $this->_connection))
        {
            throw new Database_Exception(mysql_error($this->_connection), mysql_errno($this->_connection));
        }

        static::$_current_databases[$this->_connection_id] = $database;
    }

    protected function _set_charset($charset)
    {
        $status = mysql_set_charset($charset, $this->_connection);
        
        if ($status === FALSE)
        {
            throw new Database_Exception(mysql_error($this->_connection), mysql_errno($this->_connection));
        }
    }
        
    private function _close()
    {
        mysql_close($this->_connection);
    }
    
    private function _query_error()
    {
        $error = $this->_error();

        if ($error AND item('dbdebug'))
        {            
            $error_html = '<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;background:#fff;width:600px;">

                            <h3>Error de MySQL</h3>
                            
                            <p>Query: <br />' . nl2br(end($this->queries)) .'</p>
                            <p>Error: '  . $error. '</p>
                            <p>Tiempo: ' . $this->query_time . '</p>

                          </div>';
            echo backtrace();
            echo $error_html;
        }

        return $this;
    }

    function last_query($formatted = TRUE)
    {
        if ($formatted !== FALSE)
        {
            return end($this->queries);
        }

        return  '<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;background:#fff;width:600px;">

                    <h3>Último Query</h3>
                    
                    <p>Query: <br />' . nl2br(end($this->queries)).'</p>
                    
                    <p>Tiempo: ' . $this->query_time . '</p>
                                        
                  </div>'; 
    }

    private function _error()
    {
        return mysql_error();
    }

    function escape_str($str, $dashes = FALSE)    
    {   
        if (is_array($str))
        {
            foreach ($str as $key => $val)
            {
                $str[$key] = $this->escape_str($val, FALSE);
            }        
            return $str;
        }

        if (function_exists('mysql_real_escape_string') AND is_resource($this->_connection))
        {
            $str = mysql_real_escape_string($str, $this->_connection);
        }
        elseif (function_exists('mysql_escape_string'))
        {
            $str = mysql_escape_string($str);
        }
        else
        {
            $str = addslashes($str);
        }

        if ($dashes === TRUE)
        {
            if (substr_count($str,'--') > 0)
            {
                $str = str_replace('--', '', $str);
            }
            
            if (substr_count($str, ';')  > 0)
            {
                $str = str_replace(';', '', $str);
            }       
        }        
        return $str;
    }
    

    function field_data($table = '')
    {
        if ( ! empty($table))
        {
            $i = 0;
            $fields = array();

            $query = $this->query('SELECT * FROM '.$table);
            
            while ($i < mysql_num_fields($query->results_id)) 
            {
                $fields[] = mysql_fetch_field($query->results_id, $i);
                $i++;
            }
            
            return $fields;
        }
        return mysql_fetch_field($query->results_id);
    }


}