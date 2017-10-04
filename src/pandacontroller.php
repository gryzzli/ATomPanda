<?php

class PandaController
{

	function setRouter(&$router)
	{
		$this->router =& $router;
	}

	function setView(&$view)
	{
		$this->view =& $view;
	}

	function run()
	{

		include WEB_DIR.'/'.$this->router->dir.'/'.$this->router->controllerFile;
               
		$MainController = new $this->router->controller();
		$GLOBALS['MainController'] =& $MainController;
		$MainController->view =& $this->view;
		$MainController->router =& $this->router;
		$MainController->id = $this->router->id;
		$GLOBALS['Panda']['RequestWeb'] = HTTP_BASE_URL.'/'.$this->router->dir;
		$GLOBALS['Panda']['Router'] =& $this->router;
		if($this->router->method != 'index' AND !method_exists($MainController, $this->router->method))
		{
			$this->router->MethodNotExists();
		}
		$method = $this->router->method;

		if(method_exists($MainController, 'prestart'))
		{
			$MainController->prestart();
		}

		if(method_exists($MainController, 'start'))
		{
                     
			$MainController->start();
		} $GLOBALS['time'] = microtime(TRUE);
              
		if($MainController->access[$method] != "")
		{
			if($MainController->access[$method] == 'perms')
			{
				$user = getinstance('PandaUser');

				if($user->isOP() OR $user->checkPerms($this->router->dir)) {  $MainController->$method(); }
			}
		}
		else
		{
			if(is_array($this->router->params))                                                                                                                                                                              
                        {                                                                                                                                                                                                                
                                                                                                                                                                                                                                         
                            call_user_func_array(array($MainController,$method),$this->router->params);      
                            
                        }                                                                                                                                                                                                               
                        else                                                                                                                                                                                                             
                        {                                
                            
                        $MainController->$method();    
                    
                       } 
		}
                
     
		$MainController -> run();

		$this->view->assignbyref('Panda',$GLOBALS['Panda']);
                if(!isset($MainController->nolayout))
                {
		if($MainController->tpl != "")
		{
			if($MainController->data != "") { $this->view->assign('data',$MainController->data); }
			$this->view->assign('main',$this->view->fetch($MainController->tpl));
		}
                   
                if($this->router->lang != "" && file_exists(LAYOUT_DIR.'/'.$MainController->layout.'.'.$this->router->lang .'.tpl'))
                {
                    $layoutfile = LAYOUT_DIR.'/'.$MainController->layout.'.'.$this->router->lang .'.tpl';
                }
                else
                {
                    $layoutfile = LAYOUT_DIR.'/'.$MainController->layout.'.tpl';
                }
                
                
                
                    if(!$this->view->display($layoutfile))
                    {
                            PandaFs::mkdir($this->view->object->compile_dir);
                            PandaFs::mkdir($this->view->object->cache_dir);
                    }
                }
                else
                {
                    if($MainController->tpl != "")
                        {
			if($MainController->data != "") { $this->view->assign('data',$MainController->data); }
			
                    
                    if(!$this->view->display($MainController->tpl))
                    {
                            PandaFs::mkdir($this->view->object->compile_dir);
                            PandaFs::mkdir($this->view->object->cache_dir);
                    }
                        }
                }
                
                
                

	}

}