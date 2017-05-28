<?php
require_once 'init.php';

$system = new System();

$controller = isset($_GET['cat']) ? $_GET['cat'] : 'main';
$operation = isset($_GET['operation']) && $_GET['operation'] ? $_GET['operation'] : 'index';
$controller_class_name = get_controller_class_name($controller);
$controller_obj = new $controller_class_name();
/*try{
}
catch
*/
$result = $controller_obj->$operation();
if ($result)
{
    echo  $result;
}