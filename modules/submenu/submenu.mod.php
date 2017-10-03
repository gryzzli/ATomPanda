<?php

class SubMenuMod extends PandaModController
{

	var $noInstance = 1;

	function index()
	{
		$router = getInstance('PandaRouter');



		//if(file_exists(WEB_DIR.'/'.$router->dir.'/submenumod.conf.php'))
		//{
	//		$this->data = include WEB_DIR.'/'.$router->dir.'/submenumod.conf.php';
	//	}

		if($this->params['type'] == "page") { $this->tpl = page; unset($this->params['type']); }
		else if(!stristr($router->dir,'~')) { $this->noTpl = 1; return 0; }
		$dirArray = explode('/',$router->dir);
		foreach($dirArray as $val)
		{

			if(file_exists(WEB_DIR.'/'.implode('/',$dirArray).'/submenumod.conf.php'))
			{
				$this->data = include WEB_DIR.'/'.implode('/',$dirArray).'/submenumod.conf.php';
				break;
			}
			unset($dirArray[count($dirArray)-1]);
		}
		if($this->data == '') { $this->noTpl = 1; }


	}

}