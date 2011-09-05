<?php 

class Users_Model extends Model {

    private $_join = array(
        'users_profiles' => 'users_profiles.id = users.id_profile'
    );

    function find($uid)
    {
        return $this->db->select('users.id, users.username, users.first_name, users.last_name, users.password, users.email, users.active, users.id_profile, users_profiles.name AS profile, users.uid')
                        ->from('users')
                        ->join($this->_join)
                        ->where("users.uid = $uid AND users.active = 1")
                        ->query();
    }

    function find_all()
    {
        return $this->db->select('users.id, users.username, users.first_name, users.last_name, users.password, users.email, users.active, users.id_profile, users_profiles.name AS profile, users.uid')
                        ->from('users')
                        ->join($this->_join)
                        ->where('users.active = 1')
                        ->query();
    }

    function find_by_attr($attr = '', $val = '')
    {
        $where = '';

        if ( ! is_numeric($val))
        {
            $val = "'$val'"; 
            $where = "users.$attr = $val";   
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

        return $this->db->select('users.id, users.username, users.first_name, users.last_name, users.password, users.email, users.active, users.id_profile, users_profiles.name AS profile, users.uid')
                        ->from('users')
                        ->join($this->_join)
                        ->where($where)
                        ->query();
    }

    function count_all()
    {
        return $this->db->select('count(users.id)')
                        ->from('users')
                        ->join($this->_join)
                        ->where('users.active = 1')
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

        return $this->db->select('count(users.id)')
                        ->from('users')
                        ->join($this->_join)
                        ->where("users.$attr = $val AND users.active = 1")
                        ->query();
    }

    function save($save = array())
    {
        if (isset($save['id']))
        {
            $where = 'id = '.$save['id'];
            unset($save['id']);
            return $this->db->update($save, 'users', $where);
        }

        return $this->db->insert($save, 'users');
    }
}