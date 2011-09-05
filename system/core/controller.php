<?php if ( ! defined('BASE')) die();

/**
 * @author JuanPablo
 * Clase controller
 * clase para extender desde un controlador hijo
 */
class Controller{

  private static $instance; 
    
  public static function getInstance()
  {
      if ( ! self::$instance)
      {
          self::$instance = new Controller();
      }
      return self::$instance;
  }
	/**
	 * Inicia objetos y librerias para 
	 * la clase hija.
	 * 
	 * @return void
	 */
	function __construct()
	{
      
      self::$instance = $this;

      $this->load     = Loader::getInstance();
      $this->db       = db::getInstance();
      $this->forge    = Forge::getInstance();
      $this->session  = Session::getInstance();
      $this->language = Language::getInstance();

      foreach ($this->load->objects as $key => $val)
      {
          if ( ! isset($this->$key))
          {
              $this->$key = $val;
          }
      }

      if (isset($this->language))
      {
         $this->language->load($this->session->get('user_lang'));
      }

	}

  function before(){}

  function after(){}
  
}
/* Fin del archivo controller.phtml */