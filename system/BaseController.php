<?php
class BaseController 
{  
    protected $layout = "index.php";
	
    public function __call($name, $arguments) 
    {
        error404("Method {$name} doesn't exist.");
    }
    
    public function __construct()
    {	
        //check_auth();
    }
    
    public function render($view_name, $data = [], $with_layout = true)
    {        
    	ob_start();
    
    	if(!file_exists("views/{$view_name}.php"))
    	{
            error500();
    	}
    
    	foreach($data as $var_name => $var_value)
    	{
            $$var_name = $var_value;
    	}
    
    	require_once("views/{$view_name}.php");
    	$content = ob_get_contents();
    	ob_end_clean();
    
    	if ($with_layout)
    	{
            ob_start();
            require_once("views/layout/{$this->layout}");
            $content = ob_get_contents();
            ob_end_clean();
    	}
    
    	return $content;
    }
}
