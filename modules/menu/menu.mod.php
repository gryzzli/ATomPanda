<?php

class MenuMod extends PandaModController
{

	function index()
	{

		if($this->params['id'] == "") { $id = 'default'; }
		else { $id = $this->params['id']; }
		$this->data = PandaConfig::get('mod/menu/'.$id);
		$router = getinstance('PandaRouter');

		$dirs = explode("/",$router->dir);
		//echo $dirs[0];
		$this->data['isSub'] = 0;
		$this->data['id'] = $this->params['id'];
                
          
		if(is_Array($this->data['item']))
		{
		
		foreach($this->data['item'] as $key=>$val)
		{

			if(((stristr($val['link'],'grzybowice.pl/'.$dirs[0]) OR stristr($val['link'],'grzybowice.pl.loc/'.$dirs[0])) AND $router->dir != "") OR ($router->dir == "" AND $val['link'] == HTTP_BASE_URL))
			{
				
				$this->data['item'][$key]['name'] = '<span style="color: #383634; ">'.$this->data['item'][$key]['name'].'</span>';
				$this->data['item'][$key]['sub']  = ''.$this->sub(str_replace(HTTP_BASE_URL,'',$val['link'])).'';
				if($this->data['item'][$key]['sub'] != "")
				{
				  $this->data['isSub'] = 1;
				}
			}
			else if($this->data['item'][$key]['new'] == 1) { $this->data['item'][$key]['name'] = '<span style="color: #D80533; ">'.$this->data['item'][$key]['name'].' (nowe)</span>'; }
		}
		  if($this->data['isSub'])
		  {
		   
		    foreach($this->data['item'] as $key=>$val)
		    {
		      if($this->data['item'][$key]['sub'] == "")
		      {
			$this->data['item'][$key]['liStyle'] = 'class="hideMenu'.$this->data['id'].'"';
		      }
		    }
		   
		  }
		}
	}

	function sub($dir)
	{

		$ret = '';
		if(file_exists(WEB_DIR.'/'.$dir.'/submenumod.conf.php'))
		{

			$router = getinstance('PandaRouter');
			$dirs  = explode("/",$router->dir);
			$dirs2 = explode("/",$dir);
			unset($dirs2[0]);
			foreach($dirs2 as $key=>$val)
			{
				//echo '['.$val.'] -'.$dirs[$key-1].'<br/>';
				if($val != $dirs[$key-1]) { return ''; }
			}
			if(Panda::eregi($dirs[0], $dir))
			{
				$data = include WEB_DIR.'/'.$dir.'/submenumod.conf.php';

				$ret = '<ul>';
				foreach($data as $key=>$val)
				{

					if(Panda::eregi(str_replace(HTTP_BASE_URL,'',$val['link']),'/'.$router->dir))
					{
						$ret .= '<li><a href="'.$val['link'].'"><span style="color: #383634; ">'.trim($val['name']).'</span></a>'.$this->sub(str_replace(HTTP_BASE_URL,'',$val['link'])).'</li>'."\n";
					}
					else
					{
						$ret .= '<li><a href="'.$val['link'].'">'.trim($val['name']).'</a>'.$this->sub(str_replace(HTTP_BASE_URL,'',$val['link'])).'</li>'."\n";
					}
				}

				$ret .= '</ul> ';
			}
		}
				//echo $dir;

		return $ret;

	}

}