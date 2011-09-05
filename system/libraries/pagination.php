<?php 

class pagination{

	private static $instance; 
	var $page;
	public function __construct()
	{
		$this->records = 0;
		$this->page    = 0;
		$this->count    = 0;
		$this->link    = '';
		$this->input   = input::getInstance();
		$this->uri	   = uri::getInstance();
		$this->total   = 0;
		$this->first_last = TRUE;
		$this->prev_next  = TRUE;
		$this->class   = null;
		$this->selected = 'active';
		$this->first = 'First';
		$this->prev = 'Prev';
		$this->next = 'Next';
		$this->last = 'Last';
		$this->segment = 3;
		$this->complement = '';
	}
	
	public static function getInstance() 
    { 
        if ( ! self::$instance) 
        { 
            self::$instance = new pagination(); 
        } 
        return self::$instance; 
    }
    
	public function set_up($params = array())
	{		
	    $pagination = config::getInstance()->load('pagination')->get_group('pagination');
	    
	    foreach ($pagination as $key => $val)
	    {
	       $this->$key = $val;
	    }
	    
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				$this->$key = $val;
			}
		}		
	}
	
	public function get_records()
	{
		return $this->records;
	}
	
	public function get_page()
	{		
		if ($this->uri->get($this->segment) != '')
		{
			$this->page = $this->uri->get($this->segment);
			
			if ($this->page >= 1)
			{
				$this->page -= 1;
			}
			else
			{
				$this->page = 0;
			}			
		}
		if ($this->page < 0)
		{
			$this->page = 0;
		}
		return $this->page;
	}
	
	public function rows($rows = 0)
	{
	   $this->count = $rows;
	}
	
	public function set_total($rows){
		$this->total = $rows;
	}
	
	public function create_links()
	{
		$this->set_total($this->total);
		$links = null;
		$total = $this->total / $this->records;
		$total = ceil($total);	

		if(!$this->complement){
		  $this->complement = '';
		}
		
		if($total > 1){
			if($this->uri->get($this->segment) > 1){
				$page = $this->uri->get($this->segment) - 1;
				if($this->first_last){
					$links .= "<li class='previous'><a href='{$this->link}1/{$this->complement}' class='ui-corner-all{$this->class}'>{$this->first}</a></li>";
				}
				if($this->prev_next){
					$links .= "<li class='previous'><a href='{$this->link}$page/{$this->complement}' class='ui-corner-all{$this->class}'>{$this->prev}</a></li>";
				}
			}
		
			for($i = 0; $i < $total; $i++){
				$num = $i + 1;
				if($this->uri->get($this->segment) == $num OR ($num == 1 && (!$this->uri->get($this->segment)))){
					$links .= "<li class='ui-corner-all {$this->class} {$this->selected}'>$num</li>";
				}else{
					$links .= "<li><a href='{$this->link}$num/{$this->complement}' class='ui-corner-all{$this->class}'>$num</a></li>";
				}
			}
			
			if($this->uri->get($this->segment) < $total  ){
				if($this->uri->get($this->segment)){
					$page = $this->uri->get($this->segment) + 1;
				}else{
					$page = 2;
				}
                if($this->prev_next){
                    $links .= "<li class='next'><a href='{$this->link}$page/{$this->complement}' class='ui-corner-all{$this->class}'>{$this->next}</a></li>";
                }
				if($this->first_last){
					$links .= "<li class='next'><a href='{$this->link}$total/{$this->complement}' class='ui-corner-all{$this->class}'>{$this->last}</a></li>";
				}
			}
		}
		$links = '<ul id="paginator">' . $links . '</ul>';
		return $links;
	}


}