<?php

class PandaView
{
    
       var $object;
    
	function __construct()
	{
               
                
		$this->object = new Smarty();
                
		$this->object->setTemplateDir(WEB_DIR);
		$this->object->setCompileDir(TMP_DIR.'/smarty/compile');
		$this->object->setCacheDir(TMP_DIR.'/smarty/cache');
		$this->object->left_delimiter  = '{{';
		$this->object->right_delimiter = '}}';
		
                $this->object->addPluginsDir(SYS_PLUGINS_DIR.'/smarty');
                $this->object->addPluginsDir(PLUGINS_DIR.'/smarty');
                if(DEBUG)
                {
                    $this->object->force_compile = true;
                }
                
                $this->registerFunction('Mod','module');
                
                
		if(is_array($GLOBALS['PandaView']['assignByRef']))
		{
			foreach($GLOBALS['PandaView']['assignByRef'] as $key => $val)
			{
				$this->assignByRef($key,$val);

			}
		}
               
           

	}


	function Display($file)
	{
		$this->object->display($file);

	}

	function Assign($name, $data=null)
	{
		if(is_array($name))                                                                                                                                                                                                       
               {                                                                                                                                                                                                                         
                $this->object->assign($name);                                                                                                                                                                                            
               }                                                                                                                                                                                                                         
               else                                                                                                                                                                                                                      
               {                                                                                                                                                                                                                         
                $this->object->assign($name,$data);                                                                                                                                                  
               } 
	}

	function AssignByRef($name, &$data)
	{
		$this->object->assignByRef($name,$data);
	}

	function fetch($tpl)
	{
		return $this->object->fetch($tpl);
	}

	function clearAssign($name)
	{
		$this->object->clearAssign($name);
	}

	function registerFunction($smarty_name, $function_name)
	{
		$this->object->registerPlugin('function',$smarty_name,$function_name);
	}

	static function globalAssignByRef($name, &$ref)
	{
		$GLOBALS['PandaView']['assignByRef'][$name] = $ref;

	}



}