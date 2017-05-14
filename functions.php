<?php

/**
 * Define is the current request comes from OS Windows
 * @return bool <b>client_OS_is_Windows</b> возвражает <i>истину</i> если текущий HTTP запрос получен из ОС Windows.
 */
function client_OS_is_Windows()
{  
    $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
    return preg_match( '#wi(n|n32|ndows)#', $useragent ) === FALSE;
}

function error404($message = '')
{
    header('HTTP/1.1 404 Not Found');
    if($message !== '')
    {
        $message .= "<br>";
    }
    $message .= "404 Not Found";
    die($message);
}

function error500($message = '')
{
    header('HTTP/1.1 500 Internal Server Error');
    if($message !== '')
    {
        $message .= "<br>";
    }
    $message .= "500 Internal Server Error";
    die($message);
}

function class_autoloader($class_name)
{
    if (mb_substr($class_name, -10, NULL, 'utf-8') === 'Controller')
    {
        $class_string = mb_substr($class_name,0,mb_strlen($class_name,'utf-8')-10,'utf-8');
        $name = preg_replace('/([a-z])([A-Z])/', '$1_$2', $class_string);
        $file_name = "controller/".mb_strtolower($name,'utf-8').'.controller.php';

        if (file_exists($file_name))
        {
            include_once $file_name;
        }
        else
        {
            error500("File {$file_name} not found.");
        }
        return;
    }
    
    if (mb_substr($class_name, -6, NULL, 'utf-8') === 'Helper')
    {
    	$class_string = mb_substr($class_name,0,mb_strlen($class_name,'utf-8')-6,'utf-8');
    	$file_name = "system/helpers/".mb_strtolower($class_string,'utf-8').'.helper.php';
       	
    	if (file_exists($file_name))
    	{
    		include_once $file_name;
    	}
    	else
    	{
    		error500("File {$file_name} not found.");
    	}
        return;
    }
    
    // no postfix, try to load model classes
    $name = preg_replace('/([a-z])([A-Z])/', '$1_$2', $class_name);
    $file_name = "models/".mb_strtolower($name,'utf-8').'.model.php';

   	if (file_exists($file_name))
    {
    	include_once $file_name;
    }
}

function get_controller_class_name($cat)
{
    $pie = explode('_', $cat);
    $result = '';
    foreach ($pie as $value) 
    {
        $result .= ucfirst($value);
    }
    $result .= "Controller";
    
    return $result;
}

function check_auth()
{
    global $system;

    if ($system->user->id === NULL)
    {
        $_SESSION['request_uri'] = $_SERVER['REQUEST_URI'];
        header("Location: index.php?cat=auth&operation=login");
        die();
    }
}

function redirect_after_auth()
{
	$location = "index.php";
	
	if(isset($_SESSION['request_uri']))
	{
		$location = $_SESSION['request_uri'];
		unset($_SESSION['request_uri']);
	}
	
	header("Location: " . $location);
	die();
}