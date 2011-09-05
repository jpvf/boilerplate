<?php

class tabs{
    
    static function tab($segment = 0, $check = '', $link = '', $html = '', $extra = '')
    {
        $anchor = anchor("/$link", $html); 
        $class  = self::selected_tab($segment, $check);
        return "<li class='$class' $extra>$anchor</li>";
    }
    
    private static function selected_tab($uri_segment = 0, $str = '')
    {
        if ($uri_segment === 0)
        {
            return FALSE;
        }
        
        $uri = uri::getInstance();
        
        $return = 'ui-state-default ui-corner-top ';
        $return .= ($uri->get($uri_segment) == $str)?'ui-state-active':'';
        return  $return;
    }
    
    static function open($attributes = array())
    {
        if ( is_array($attributes))
        {
            $attributes = implode(' ', $attributes);
        }
                                
        $tab_open = "<ul class='tabs' $attributes>";
        return $tab_open;
    }
    
    static function close()
    {
        return '</ul>';
    }
    
}