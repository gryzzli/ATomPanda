<?php




function PandaAutoload($class_name)
{


	 if(file_exists(CLASS_DIR.'/'.strtolower($class_name) . '.php'))
	 {
   	 	require_once CLASS_DIR.'/'.strtolower($class_name) . '.php';
	 }
	 else if(file_exists(CLASS_DIR.'/smarty/'.$class_name . '.php'))
	 {
   	 	require_once CLASS_DIR.'/smarty/'.$class_name . '.php';
	 }
	 else if(file_exists(MODULES_DIR.'/'.str_replace("mod","",strtolower($class_name)).'/'.str_replace("mod",".mod",strtolower($class_name)) . '.php'))
	 {
   	 	require_once MODULES_DIR.'/'.str_replace("mod","",strtolower($class_name)).'/'.str_replace("mod",".mod",strtolower($class_name)) . '.php';
	 }
         else if(file_exists(SYS_MODULES_DIR.'/'.str_replace("mod","",strtolower($class_name)).'/'.str_replace("mod",".mod",strtolower($class_name)) . '.php'))
	 {
   	 	require_once SYS_MODULES_DIR.'/'.str_replace("mod","",strtolower($class_name)).'/'.str_replace("mod",".mod",strtolower($class_name)) . '.php';
	 }
	 else if(file_exists(COMPONENTS_DIR.'/'.str_replace("comp","",strtolower($class_name)).'/'.str_replace("comp",".comp",strtolower($class_name)) . '.php'))
	 {
   	 	require_once COMPONENTS_DIR.'/'.str_replace("comp","",strtolower($class_name)).'/'.str_replace("comp",".comp",strtolower($class_name)) . '.php';
	 }
         else if(file_exists(SYS_COMPONENTS_DIR.'/'.str_replace("comp","",strtolower($class_name)).'/'.str_replace("comp",".comp",strtolower($class_name)) . '.php'))
	 {
   	 	require_once SYS_COMPONENTS_DIR.'/'.str_replace("comp","",strtolower($class_name)).'/'.str_replace("comp",".comp",strtolower($class_name)) . '.php';
                
	 }
        
   


}




function getInstance($name,$instance='default',$noinit=0)
{


        $params = null;
        if(is_array($name))
        {
        $params = $name[1];
        $name = $name[0];
        }

	$name = ucfirst($name);
	if(null == $GLOBALS['Object'][$name][$instance]['object'])
	{
            if($noinit==0)
            {
                if(isset($GLOBALS['Object'][$name][$instance]['params']))
                {
                    $params = $GLOBALS['Object'][$name][$instance]['params'];
                }
                
                echo '-'.$name.'-';
		$object = new $name($params);
            }
            else
            {
                $GLOBALS['Object'][$name][$instance]['params'] = $params;
            }
		
            if($object->noInstance!=1)
		{
			$GLOBALS['Object'][$name][$instance]['object'] =& $object;
		}
		else
		{
			return $object;
		}
	}
	return  $GLOBALS['Object'][$name][$instance]['object'];

}

function module($params)
{

	if(file_exists(MODULES_DIR.'/'.strtolower($params['mod']).'/'.strtolower($params['mod']).'.mod.php'))
	{
            require_once MODULES_DIR.'/'.strtolower($params['mod']).'/'.strtolower($params['mod']).'.mod.php';
        }
        else if(file_exists(SYS_MODULES_DIR.'/'.strtolower($params['mod']).'/'.strtolower($params['mod']).'.mod.php'))
	{
            require_once SYS_MODULES_DIR.'/'.strtolower($params['mod']).'/'.strtolower($params['mod']).'.mod.php';
        }
	
                
                
		$Module = Getinstance($params['mod'].'Mod');
		$Module->name = $params['mod'];
		$Module->router = getInstance('PandaRouter');
		$Module->params =& $params;
                
		$Module->index();
		$Module->id = $params->id;
		$Module->run();
		if($Module->tpl != "")
		{
			
			$view = getInstance('PandaView',$params['mod']);
			if($Module->data != "") { $view -> assign('data',$Module->data); }
			$view->display($Module->tpl);
		}

	

}
