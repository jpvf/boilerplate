<?php 

class Users_Permissions_Model extends Model {

    private $_join = array(
        'users' => 'users.id = users_permissions.id_user',
		'users_resources' => 'users_resources.id = users_permissions.id_resource'
    );

    function find($uid)
    {
        return $this->db->select('users_permissions.id, users_permissions.id_user, users.name AS user, users_permissions.id_resource, users_resources.name AS resource, users_permissions.allowed')
                        ->from('users_permissions')
                        ->join($this->_join)
                        ->where("users_permissions.uid = $uid AND users_permissions.active = 1")
                        ->query();
    }

    function find_all()
    {
        return $this->db->select('users_permissions.id, users_permissions.id_user, users.name AS user, users_permissions.id_resource, users_resources.name AS resource, users_permissions.allowed')
                        ->from('users_permissions')
                        ->join($this->_join)
                        ->where('users_permissions.active = 1')
                        ->query();
    }

    function find_by_attr($attr = '', $val = '')
    {
        $where = '';

        if ( ! is_numeric($val))
        {
            $val = "'$val'"; 
            $where = "users_permissions.$attr = $val";   
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

        return $this->db->select('users_permissions.id, users_permissions.id_user, users.name AS user, users_permissions.id_resource, users_resources.name AS resource, users_permissions.allowed')
                        ->from('users_permissions')
                        ->join($this->_join)
                        ->where($where)
                        ->query();
    }

    function count_all()
    {
        return $this->db->select('count(users_permissions.id)')
                        ->from('users_permissions')
                        ->join($this->_join)
                        ->where('users_permissions.active = 1')
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

        return $this->db->select('count(users_permissions.id)')
                        ->from('users_permissions')
                        ->join($this->_join)
                        ->where("users_permissions.$attr = $val AND users_permissions.active = 1")
                        ->query();
    }

    function save($save = array())
    {
        if (isset($save['id']))
        {
            $where = 'id = '.$save['id'];
            unset($save['id']);
            return $this->db->update($save, 'users_permissions', $where);
        }

        return $this->db->insert($save, 'users_permissions');
    }
}