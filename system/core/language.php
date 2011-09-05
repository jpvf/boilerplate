<?php if ( ! defined('BASE')) exit('Acceso directo prohibido');

class Language {

	private static $language = array();
	private $is_loaded	= array();
	private $lang;
	private static $instance;

	function __construct()
	{
		//show(__CLASS__ . ' iniciada <br>');		
	}
	
    public static function getInstance() 
    { 
        if ( ! self::$instance) 
        { 
            self::$instance = new Language(); 
        } 
        return self::$instance; 
    }

	function load($idiom = '')
	{
		$langfile = "lang_$idiom" . EXT; 
		
		if ($langfile  == $this->is_loaded)
		{
			return;
		}

		if ($idiom == '')
		{
			$deft_lang = item('default_lang');
			$idiom 	   = ($deft_lang == '') ? 'es' : $deft_lang;
		}

		$this->lang = $idiom;
		
		$langfile = "lang_$idiom" . EXT;
		
		if (file_exists(RUTA_LENGUAJE . $langfile))
		{
			include(RUTA_LENGUAJE . $langfile);
		}
	

		if ( ! isset($lang))
		{
			return;
		}

		$this->is_loaded = $langfile;
		self::$language  = $lang;

		return TRUE;
	}

	static function line($line = '')
	{
		$line = ($line == '' OR ! isset(self::$language[$line])) ? FALSE : self::$language[$line];
		return $line;
	}

}
// END Language Class

/* End of file Language.php */
/* Location: ./system/libraries/Language.php */