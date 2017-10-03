<?php

class PandaCompController
{

var $layout = 'index';
	function prestart()
	{
		if($this->table == "") { $this->table = str_replace('/','_',$this->router->dir); }
	}


	function run()
	{

		if($this->tpl == "")
		{

			if(file_exists(strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'.tpl')))
			{
				$this->tpl = strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'.tpl');
			}
		}
		else
		{
			if(file_exists(strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->tpl.'.tpl')))
			{

				$this->tpl = strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->tpl.'.tpl');
			}



		}

	}

	function loadmodel()
	{


		if(file_exists(strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'.model.php')))
		{
			require_once strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'.model.php');
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

	function index()
	{

	}

}