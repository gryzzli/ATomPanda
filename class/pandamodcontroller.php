<?php

class PandaModController
{
var $noTpl;
    var $tpl;
	function run()
	{
		if($this->noTpl == "")
		{
		
		
			if($this->tpl == "")
			{
                            
                            $router = getInstance('PandaRouter');
                            
                                if(isset($router->lang))
                                {
                                   if(file_exists(MODULES_DIR.'/'.$this->name.'/'.$this->name.'.'.$router->lang.'.tpl'))
                                    {
					$this->tpl = MODULES_DIR.'/'.$this->name.'/'.$this->name.'.'.$router->lang.'.tpl'; return 1;
                                    }
                                    else if(file_exists(SYS_MODULES_DIR.'/'.$this->name.'.'.$router->lang.'.tpl'))
                                    {
					$this->tpl = SYS_MODULES_DIR.'/'.$this->name.'/'.$this->name.'.'.$router->lang.'.tpl'; return 1;
                                    } 
                                }
                                
                                if($this->tpl == "")
			{
				if(file_exists(MODULES_DIR.'/'.$this->name.'/'.$this->name.'.tpl'))
				{
					$this->tpl = MODULES_DIR.'/'.$this->name.'/'.$this->name.'.tpl'; return 1;
				}
                                else if(file_exists(SYS_MODULES_DIR.'/'.$this->name.'/'.$this->name.'.tpl'))
				{
					$this->tpl = SYS_MODULES_DIR.'/'.$this->name.'/'.$this->name.'.tpl'; return 1;
				}
                        }
			}
                      
			else
			{
				if(file_exists(MODULES_DIR.'/'.$this->name.'/'.$this->tpl.'.tpl'))
				{
					$this->tpl = MODULES_DIR.'/'.$this->name.'/'.$this->tpl.'.tpl'; return 1;
				}
                                else if(file_exists(SYS_MODULES_DIR.'/'.$this->name.'/'.$this->tpl.'.tpl'))
				{
					$this->tpl = SYS_MODULES_DIR.'/'.$this->name.'/'.$this->tpl.'.tpl'; return 1;
				}
			}
		}

	}


	function loadmodel($file=null,$name=null)
	{
            
		if($file != null AND file_exists($file))
		{
			require_once $file;
			$modelName = $name.'Model';
			$this->model = new $modelName();
			$this->model->name = $this->name;
			$this->model->table = $this->table;
			if(method_exists($this->model, 'start')) { $this->model->start(); }
		}

		else if(file_exists(strtolower(MODULES_DIR.'/'.$this->name.'/'.$this->name.'.model.php')))
		{
			require_once strtolower(MODULES_DIR.'/'.$this->name.'/'.$this->name.'.model.php');
			$modelName = $this->name.'Model';
			$this->model = new $modelName();
			$this->model->name = $this->name;
			$this->model->table = $this->table;
			if(method_exists($this->model, 'start')) { $this->model->start(); }

		}
                else if(file_exists(strtolower(SYS_MODULES_DIR.'/'.$this->name.'/'.$this->name.'.model.php')))
		{
			require_once strtolower(SYS_MODULES_DIR.'/'.$this->name.'/'.$this->name.'.model.php');
			$modelName = $this->name.'Model';
			$this->model = new $modelName();
			$this->model->name = $this->name;
			$this->model->table = $this->table;
			if(method_exists($this->model, 'start')) { $this->model->start(); }

		}
		else if(file_exists(strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.model.php')))
		{
			require_once strtolower(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.model.php');
			$modelName = $this->router->name.'Model';
			$this->model = new $modelName();
			$this->model->name = $this->name;
			$this->model->table = $this->table;
		}

	}


}