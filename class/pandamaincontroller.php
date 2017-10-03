<?php

class PandaMainController
{
        var $tpl;                                                                                                                                                                                                                           
        var $data;
        var $layout = 'index';
	function run()
	{
            $router = getInstance('PandaRouter');
            if(!isset($this->notpl))
            {
		if($this->tpl == "")
		{

                       if($router->lang != "")
                       {
                          
                            if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->method.'.'.$router->lang.'.tpl')))
                            {
                                $this->tpl = strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->method.'.'.$router->lang.'.tpl');   
                                return 1;
                            }
                            else if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.'.$router->lang.'.tpl')))  
                            {
				$this->tpl = strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.'.$router->lang.'.tpl');
                                return 1;
                            }
                       }
                        
                    
                        if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->method.'.tpl')))
                        {
                            $this->tpl = strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->method.'.tpl');   
                            return 1;
                        }
			else if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.tpl')))  
			{
				$this->tpl = strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.tpl');
                                return 1;
			}
		}
		else
		{
                     if($router->lang != "")
                     {
                         if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->tpl.'.'.$router->lang.'.tpl')))
			{
                            $this->tpl = strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->tpl.'.'.$router->lang.'.tpl');
                            return 1;
			}
                     }
			if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->tpl.'.tpl')))
			{
                            $this->tpl = strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->tpl.'.tpl');
                            return 1;
			}



		}
            }

	}

	function loadmodel($file=null,$name=null)
	{

		if($file != null AND file_exists($file))
		{

			require_once $file;
			$modelName = str_replace("~","",$name.'Model');
			$this->model = new $modelName();
			$this->model->name = $this->name;
			$this->model->table = $this->table;
			if(method_exists($this->model, 'start')) { $this->model->start(); }


		}
		if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.model.php')))
		{
			require_once strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.model.php');
			$modelName = str_replace("~","",$this->router->name.'Model');
			$this->model = new $modelName();
			$this->model->name = $this->name;
			$this->model->table = $this->table;
			if(method_exists($this->model, 'start')) { $this->model->start(); }
		}
		else if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.model.php')))
		{
			require_once strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.model.php');
			$modelName = str_replace("~","",$this->router->name.'Model');
			$this->model = new $modelName();
			$this->model->name = $this->name;
			$this->model->table = $this->table;
			if(method_exists($this->model, 'start')) { $this->model->start(); }
		}

	}

	function index()
	{

	}


}