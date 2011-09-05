<?php

/**
 * Clase Base de modelo, contiene los metodos básicos de un modelo como
 * encontrar un registro de una tabla, todos los registros de la tabla, 
 * contar, guardar, actualizar, métodos mágicos para los queries.
 * 
 */

class App_Model extends Model {
    
    /**
     * @var array $join contiene las relaciones básicas de la tabla
     */
    protected $join = array();

    /**
     * @var string $table contiene la tabla del modelo actual
     */
    protected $table = '';

    /**
     * @var string $find contiene el identificador del modelo actual
     */
    protected $find = 'id';

    /**
     * @var string $base_select contiene los campos basicos a seleccionar
     */
    protected $base_select = '*';

    /**
     * @var string $where contiene los campos a filtrar en el where
     */
    protected $where = '';

    /**
     * Realiza un query buscando todos los registros con la preparación 
     * básica realizada en el modelo, ej.:
     * 
     * SELECT * FROM table
     *
     * @return  array
     */
    function find_all()
    {
        $this->_setup();
        return $this->db->get($this->table);
    }
    
    /**
     * Realiza un query buscando todos los registros con la preparación 
     * básica realizada en el modelo y recibiendo un id para filtrar por tal campo, 
     * ej.:
     * 
     * SELECT * FROM table WHERE table.id = '$id'
     *
     * @param   numeric el id a buscar
     * @return  array   el array con el resultado de la clase DB
     */
    function find($id = NULL)
    {
        //No hay nada, devuelva nada.
        if (is_null($id))
        {
            return FALSE;
        }

        $this->_setup();

        $this->db->where($this->_and()."{$this->table}.{$this->find} = $id")
                 ->limit(1);

        return $this->db->get($this->table);
    }
    
    /**
     * Realiza un query buscando todos los registros con la preparación 
     * básica realizada en el modelo pero el resultado va a ser un total nada mas, 
     * ej.:
     * 
     * SELECT count(id) as total FROM table
     *
     * @return  string el numero total de filas
     */
    function count_all()
    {
        $this->_setup(TRUE);
        
        $result = $this->db->get($this->table);
        
        if ($result->num_rows() == 0)
        {
            $total = 0;
        }
        else 
        {
            $total = $result->row()->total;
        }
        
        return $total; 
    }
    
    /**
     * Realiza un query insertando el array asociativo que llegue, verifica si existe el uid, si
     * existe actualiza el registro, sino lo saca del array para que no cree uno nuevo o genere un error
     *
     * @param   array el array con los datos a guardar
     * @return  bool  true o false dependiendo del resultado del query
     */
    function save($save)
    {
        $field = $this->find($save['uid']);
            
        if ($field->num_rows() == 0)
        {
            return $this->db->insert($save, $this->table);
        }
        else
        {
            $uid = $save['uid'];
            
            unset($save['uid']);
            
            $field = $field->row();
            
            if ( ! isset($field->id))
            {
                return FALSE;
            }
            
            return $this->db->update($save, $this->table, "id = {$field->id}");
        }
        
    }
    
    /**
     * Prepara las partes del query que llegan desde el modelo tales como las asociaciones, 
     * selects, where.
     *
     * @param   bool si se hace un query de conteo o no
     * @return  void
     */ 
    private function _setup($count = FALSE)
    {
        if ($count === FALSE)
        {
            $this->db->select($this->base_select);            
        }
        else
        {
            $this->db->select("count({$this->table}.{$this->find}) as total");
        }
        
        $this->db->join($this->join);
        $this->db->where($this->where);
    }
    
    /**
     * Función mágica para generar queries de busqueda por campos, ej.:
     *
     * find_all_by_{tabla}_{campo}(valor)
     *
     * @param   string      nombre de la funcion
     * @param   array       valores que llegan a la funcion
     * @return  void|array  array de resultado de la clase DB
     */ 
    function __call($function, $args)
    {
        // Si esta buscando un método no contemplado, muestre una excepcion para
        // que la consulta no genere un error.

        if (strpos($function, 'find_all_by_') === FALSE)
        {
            throw new Exception('Method not found.', '1');
        }

        $field = str_ireplace('find_all_by_', '', $function);
        
        $field = explode('_', $field, 2);
        
        $table = $field[0];
        $field = $field[1];
        $value = $args[0]; 
        $operator = isset($args[1]) ? $args[1] : '=';
        
        // No hay campo para hacer el filtro, no hay nada más que hacer
        if (empty($field))
        {
            throw new Exception('Method not found.', '1');
        }
        
        return $this->_find_by($table, $field, $value, $operator);
    }
    
    /**
     * Realiza el query dinámico llamado desde la función mágica.
     *
     * @param   bool si se hace un query de conteo o no
     * @return  void
     */ 
    private function _find_by($table, $field, $value, $operator = '=')
    {
        if (is_string($value))
        {
            $value = "'$value'";
        }
        
        $this->_setup();
          
        $this->db->where($this->_and()."pmt_$table.$field $operator $value");              
        return $this->db->get($this->table);         
    }
    
    /**
     * Verifica si existe un where desde el modelo para agregar la palabra AND y no tener problemas.
     *
     * @return  void|string la palabra AND o vacío
     */ 
    private function _and()
    {
        if ( ! empty($this->where))
        {
            return ' AND ';
        } 
        
        return '';
    }
    
}