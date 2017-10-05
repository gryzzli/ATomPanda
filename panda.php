<?php




session_start();
#error_reporting(0);
date_default_timezone_set("Europe/Berlin");

include '../app/config/panda.php';
include 'define.php';
#ini_set('upload_max_filesize',50);

require '../vendor/autoload.php';

include FUNCTIONS_DIR.'/basic.php';
spl_autoload_register('PandaAutoload');

$view = GetInstance('PandaView');


$controller = Getinstance('PandaController');
$router = GetInstance('PandaRouter');
$controller->setRouter($router);
$controller->setView($view);
$view->assign('router',$router);



foreach(glob(APP_DIR . "/init/*.php") as $class) {
        include_once $class;
    }
    
 

$controller->run();
    /*
    $GLOBALS['time'] = microtime(TRUE);
      * 
     
 $GLOBALS['times'] = microtime(TRUE);
print_r(array(

  'memory' => (memory_get_usage() - $mem) / (1024 * 1024),

  'seconds' => $GLOBALS['times'] -  $GLOBALS['time']

));

 */
