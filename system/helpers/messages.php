<?php

class Message {
    
    private static function _message($type = '', $text = '', $url = '')
    {
        $url = ($url[0] != '/') ? '/' . $url : $url;
        session::getInstance()->set_flashdata(array('text' => $text , 'type' => $type));
        redirect(get_url() . $url); 
    }

    static function success($text = 'Success', $url = '')
    {
        return self::_message('success', $text, $url);
    }

    static function error($text = 'Error', $url = '')
    {
        return self::_message('error', $text, $url);
    }

    static function warning($text = 'Warning', $url = '')
    {
        return self::_message('warning', $text, $url);
    }

    static function info($text = 'Info', $url = '')
    {
        return self::_message('info', $text, $url);
    }


    static function get($sticky = FALSE)
    {
        $session = session::getInstance();

        $text = $session->flashdata('text');
        $type = $session->flashdata('type');

        if (empty($text) OR empty($type))
        {
            return NULL;
        }

        $close = ($sticky === TRUE) ? '' : "<span class='close' id='hide' title='Cerrar'></span>";
        $class = ($sticky === TRUE) ? 'sticky' : ''; 

        $message = "<div class='message $type $class' style='display: block;'><p>$text</p>$close</div>";
        return $message;        
    }
}
