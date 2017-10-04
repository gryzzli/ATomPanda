<?php
define('PANDA_DIR', PROJECT_DIR.'/vendor/gryzzli/atompanda');
define('CLASS_DIR', PANDA_DIR.'/class');


define('FUNCTIONS_DIR',PANDA_DIR.'/functions');
define('APP_DIR',PROJECT_DIR.'/app');
define('WEB_DIR',APP_DIR.'/web');
define('TMP_DIR',PROJECT_DIR.'/tmp');

define('VENDOR_DIR',PROJECT_DIR.'/vendor');
define('MODULES_DIR',APP_DIR.'/modules');
define('SYS_MODULES_DIR',PANDA_DIR.'/modules');
define('COMPONENTS_DIR',APP_DIR.'/components');
define('SYS_COMPONENTS_DIR',PANDA_DIR.'/components');

define('LAYOUT_DIR',APP_DIR.'/layout');
define('CONFIG_DIR',PANDA_DIR.'/config');
define('USER_CONFIG_DIR',APP_DIR.'/config');

if($_SERVER['HTTPS'] != 'on')
{
    define('HTTP_BASE_URL','http://'.$_SERVER['HTTP_HOST'].''.WEB_PATH);
}
else
{
    define('HTTP_BASE_URL','https://'.$_SERVER['HTTP_HOST'].''.WEB_PATH);
}

define('HTTP_LAYOUT_URL',HTTP_BASE_URL.'/layout');
define('MEDIA_DIR',PROJECT_DIR.'/public_html/media');
define('HTTP_MEDIA_URL', HTTP_BASE_URL.'/media');
define('PUBLIC_DIR', PROJECT_DIR.'/public_html');


define('PLUGINS_DIR', APP_DIR.'/plugins');
define('SYS_PLUGINS_DIR', PANDA_DIR.'/plugins');