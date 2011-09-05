<?php 

class Users_Resources_Model extends Model {

    private $_join = array(
        'users_permissions' => 'users_permissions.id = users_resources.id_resource'
    );

    function find($uid)
    {
        return $this->db->select('users_resources.id, users_resources.name, users_resources.active')
                        ->from('users_resources')
                        ->join($this->_join)
                        ->where("users_resources.uid = $uid AND users_resources.active = 1")
                        ->query();
    }

    function find_all()
    {
        return $this->db->select('users_resources.id, users_resources.name, users_resources.active')
                        ->from('users_resources')
                        ->join($this->_join)
                        ->where('users_resources.active = 1')
                        ->query();
    }

    function find_by_attr($attr = '', $val = '')
    {
        $where = '';

        if ( ! is_numeric($val))
        {
            $val = "'$val'"; 
            $where = "users_resources.$attr = $val";   
        }

        if (is_array($attr))
        {
            $where = array();

            foreach ($attr as $field => $val)
            {
                if ( ! is_numeric($val))
                {
                    $val = "'$val'";
                }
                $where[] = "$field = $val";
            }

            $where = implode(' AND ', $where);
        }

        return $this->db->select('users_resources.id, users_resources.name, users_resources.active')
                        ->from('users_resources')
                        ->join($this->_join)
                        ->where($where)
                        ->query();
    }

    function count_all()
    {
        return $this->db->select('count(users_resources.id)')
                        ->from('users_resources')
                        ->join($this->_join)
                        ->where('users_resources.active = 1')
                        ->query();
    }

    function count_by_attr($attr = '', $val = '')
    {
        if ( ! is_numeric($val))
        {
            $val = "'$val'";    
        }

        if (is_array($attr))
        {
            $where = array();

            foreach ($attr as $field => $val)
            {
                if ( ! is_numeric($val))
                {
                    $val = "'$val'";
                }
                $where[] = "$field = $val";
            }

            $where = implode(' AND ', $where);
        }

        return $this->db->select('count(users_resources.id)')
                        ->from('users_resources')
                        ->join($this->_join)
                        ->where("users_resources.$attr = $val AND users_resources.active = 1")
                        ->query();
    }

    function save($save = array())
    {
        if (isset($save['id']))
        {
            $where = 'id = '.$save['id'];
            unset($save['id']);
            return $this->db->update($save, 'users_resources', $where);
        }

        return $this->db->insert($save, 'users_resources');
    }
}