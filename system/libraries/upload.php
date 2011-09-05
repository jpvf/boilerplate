<?php 

class upload{
	
	private static $upload;
	var $file = null;
	
	public function __construct()
	{
		if(isset($_FILES) && !empty($_FILES)){
			$this->file = $_FILES['file'];
		}
	}
	
	public static function getInstance() 
    { 
        if (!self::$upload) 
        { 
            self::$upload = new upload(); 
        } 
        return self::$upload; 
    }
    
    private function _check_ext()
    {
    	$this->allowed_ext 			= explode('|', $this->allowed);
	    $this->file_ext    			= strrchr($this->file['name'],'.');
	    list($dot, $this->file_ext) = explode('.', $this->file_ext);
	    
	    foreach($this->allowed_ext as $key => $val){
	    	if($val == $this->file_ext){ 
		    	return true;
		    }
	    }
	    return false;	       
    }
    
    private function _check_size()
    {
        $this->file_size = $this->file['size'];
    	if($this->max_size >= $this->file['size']){
    		return true;
    	}
    	return false;
    }
    
    private function _move()
    {
        $this->file_ext = ($this->file_ext == 'jpg') ? ('jpeg') : ($this->file_ext);
        $this->base_name = $this->file['name'];
        if(isset($this->file_name) && !empty($this->file_name)){
            $this->file['name'] = $this->file_name . '.' .$this->file_ext;
        }
        
        if(isset($this->timestamp) && !empty($this->timestamp) && $this->timestamp === TRUE){
            $ext = strrchr($this->file['name'],'.');
            $name = reverse_strrchr($this->file['name'],'.');
            list($dot, $ext) = explode('.', $ext);
            $ext = ($ext == 'jpg') ? ('jpeg') : ($ext);
            $this->timestamp_val = date('YmdHis');
            $this->file['name'] = $name . '-' . $this->timestamp_val . '.' . $ext;
        }
         
	    if(move_uploaded_file($this->file['tmp_name'], $this->upload_path .  $this->file['name'] )) {
		    return true;
		}
		
		return false;
    }
    
    public function do_upload($config = array())
    {
    	if(!$this->file){
    		return;
    	}    
    	
    	$this->_setDefaults($config);
		
    	if(!$this->_check_ext()){
			return false;
		}
		
		if(!$this->_check_size()){
			return false;
		}
		
		if(file_exists($this->upload_path . $this->file['name'])){
			return false;
		}
		
		if(!$this->_move()){
			return false;
		}
		
		return true;
		
    }
    
    private function _setDefaults($upload_config = array())
    {
        include_once(RUTA_CONFIG . 'upload' . EXT);
        if(count($config) > 0){
        	foreach($config as $key => $val){
        		$this->$key = $val;
        	}
        }
    	if(count($upload_config) > 0){
    		foreach($upload_config as $key => $val){
    			$this->$key = $val;
    		}
    	}
    }
    
    public function get_name()
    {
    	return $this->upload_path . $this->file['name'];
    }
    
    public function get_size()
    {
        return $this->file_size;
    }
    
    function get_base_filename()
    {
        return $this->base_name;
    }
    
    public function get_timestamp()
    {
        return $this->timestamp_val;
    }

}