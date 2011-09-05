<?php 

class Users_Profiles_Model extends Model {

    private $_join = array(
        
    );

    function find($uid)
    {
        return $this->db->select('users_profiles.id, users_profiles.name, users_profiles.active')
                        ->from('users_profiles')
                        ->join($this->_join)
                        ->where("users_profiles.uid = $uid AND users_profiles.active = 1")
                        ->query();
    }

    function find_all()
    {
        return $this->db->select('users_profiles.id, users_profiles.name, users_profiles.active')
                        ->from('users_profiles')
                        ->join($this->_join)
                        ->where('users_profiles.active = 1')
                        ->query();
    }

    function find_by_attr($attr = '', $val = '')
    {
        $where = '';

        if ( ! is_numeric($val))
        {
            $val = "'$val'"; 
            $where = "users_profiles.$attr = $val";   
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

        return $this->db->select('users_profiles.id, users_profiles.name, users_profiles.active')
                        ->from('users_profiles')
                        ->join($this->_join)
                        ->where($where)
                        ->query();
    }

    function count_all()
    {
        return $this->db->select('count(users_profiles.id)')
                        ->from('users_profiles')
                        ->join($this->_join)
                        ->where('users_profiles.active = 1')
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

        return $this->db->select('count(users_profiles.id)')
                        ->from('users_profiles')
                        ->join($this->_join)
                        ->where("users_profiles.$attr = $val AND users_profiles.active = 1")
                        ->query();
    }

    function save($save = array())
    {
        if (isset($save['id']))
        {
            $where = 'id = '.$save['id'];
            unset($save['id']);
            return $this->db->update($save, 'users_profiles', $where);
        }

        return $this->db->insert($save, 'users_profiles');
    }
}