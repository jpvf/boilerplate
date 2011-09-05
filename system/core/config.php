<?php if ( ! defined('BASE')) die();

class Config 
{
    static $folder = NULL;
    private static $config;
    private static $files = array();

    function __construct()
    {
        //show(__CLASS__ . ' iniciada <br>');
    }

    public static function load($files = '')
    {   
        if (is_string($files))
        {
            if (strpos($files, ','))
            {               
                $files = explode(',' , $files);
            }
            else
            {
                $files = array($files);
            }
        }

        foreach ($files as $file)
        {
            $file = trim($file);
        
            $config_file = RUTA_CONFIG . $file . EXT;

            if (file_exists($config_file))
            {
                include($config_file);

                self::$files[$file]  = ${$file};

                foreach (self::$files[$file] as $key => $val)
                {
                    self::$config[$key] = $val;
                }
            }

            if ( ! is_null(self::$folder))
            {
               $config_file = self::$folder . 'config/' . $file . EXT;

                if (file_exists($config_file))
                {
                    include($config_file);

                    self::$files[$file]  = ${$file};

                    foreach (self::$files[$file] as $key => $val)
                    {
                        self::$config[$key] = $val;
                    }
                }
            }

        }
    }

    public static function get($key = '')
    {
        return self::$config[$key];
    }

    public static function set($file = array(), $values = '')
    {
        if (is_string($file))
        {
            $file = array($file => $values);
        }

        foreach ($file as $key => $val)
        {
            self::$config[$key] = $val;
        }
    }

    public static function get_group($group = '')
    {
        return self::$files[$group];
    }

    public static function set_group($group = array(), $name = '')
    {
        if ($name == '' OR empty($group))
        {
            return FALSE;
        }

        self::$files[$name] = $group;

        self::set($group);
    }

}