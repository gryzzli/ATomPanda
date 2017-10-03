<?php

class UniwersalTable_admin
{

	function __construct()
	{
		$this->view = new PandaView();
		$this->router = getinstance('PandaRouter');

		if($this->router->params[1] == "")
		{
			$dir = $this->router->params[0];
		}
		else
		{

			if(is_dir(WEB_DIR.'/'.implode("/",$this->router->params)))
			{
				$dir = implode("/",$this->router->params);
			}
			else if(is_file(WEB_DIR.'/'.implode("/",$this->router->params)))
			{
				$dir = dirname(implode("/",$this->router->params));
				$this->data['file'] = basename(implode("/",$this->router->params));
			}
			//$this->data['file'] = basename(implode("/",$this->router->params.));
		}
		$this->data['dir'] = $dir;
		$this->data['orginal'] = HTTP_BASE_URL.'/'.$dir;
	}


	function index()
	{
		$f = new PandaForm();
		for($i=0;$i<20;$i++)
		{
			$f->addOptions('type_'.$i,array(text, textarea, author,date,mail,www,skype,gg,icq,int));
		}

		$f->addOptions('first_organization',array(rowTable,colTable));

		if($f->isSubmit())
		{

			$save  = '<?php'."\n";
			$save .= 'class '.basename($this->data['dir']).'Model extends PandaModel
{

	function Definition()
	{
';

			for($i=0; $i<20; $i++)
			{
				if($f->data['name_'.$i] != "")
				{
					if($f->data['required_'.$i] == "") { $f->data['required_'.$i] = 0; } else { $f->data['required_'.$i] = 1; }
					$save .= '$ret[\''.$f->data['name_'.$i].'\']  = array(type=>'.$f->data['type_'.$i].',     title=>\''.$f->data['title_'.$i].'\', required=>'.$f->data['required_'.$i].');'."\n";
				}
			}

			if($f->data['authorized'] != "") { $save .= '$ret[\'authorized\']  = array(type=>auth);'."\n"; }
			if($f->data['id']         != "") { $save .= '$ret[\'id\']          = array(type=>id);'."\n"; }
			if($f->data['created_at'] != "") { $save .= '$ret[\'created_at\']  = array(type=>created_at);'."\n"; }
			if($f->data['updated_at'] != "") { $save .= '$ret[\'updated_at\']  = array(type=>updated_at);'."\n"; }
			if($f->data['sessid']     != "") { $save .= '$ret[\'sessid\']      = array(type=>sessid);'."\n"; }
			if($f->data['id_user']    != "") { $save .= '$ret[\'id_user\']     = array(type=>id_user);'."\n"; }

			$save .= 'return $ret;'."\n";
			$save .= "}\n}";

			$save2 = '<?php
class '.basename($this->data['dir']).'Main extends UniwersalTableComp
{
';

			$save2 .= 'var $table = \''.$f->data['table'].'\';'."\n";
			$save2 .= 'var $title = \''.$f->data['title'].'\';'."\n";
			$save2 .= 'var $indexPage = array('."\n";
			$save2 .= 'organization=>\''.$f->data['first_organization'].'\''."\n";
			if($f->data['first_show'] != "") { $save2 .= ',show => array('.$f->data['first_show'].')';}
			$save2 .= "); \n";
			if($f->data['order'] != "") { $save2 .= 'var $order = \''.$f->data['table'].'\';'."\n"; }
			if($f->data['antybot'] != "") { $save2 .= 'var $antyBot = 1;'."\n"; }
			$save2 .= '}';


			//echo '<pre>'.$save;

			PandaFs::Save(WEB_DIR.'/'.$this->data['dir'].'/'.basename($this->data['dir']).'.model.php',$save);
			PandaFs::Save(WEB_DIR.'/'.$this->data['dir'].'/'.basename($this->data['dir']).'.main.php',$save2);
			unlink(WEB_DIR.'/'.$this->data['dir'].'/'.basename($this->data['dir']).'.tpl');
		}

		$f->data['id'] = 1;
		$f->data['id_user'] = 1;
		$f->data['sessid'] = 1;
		$this->view->assign('f',$f);


	}



	function display()
	{
		return $this->view->fetch(COMPONENTS_DIR.'/uniwersaltable/admin/admin.tpl');

	}


}