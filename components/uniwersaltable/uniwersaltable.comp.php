<?php

class UniwersalTableComp extends PandaCompController
{
	var $name = 'UniwersalTable';

	function start()
	{
		$this->loadmodel();
	}

	function index()
	{
		if(!file_exists(WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.tpl'))
		{
			include_once strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'compbuild.comp.php');
			$build = new UniwersalTableCompBuild();
			if($this->indexPage['organization'] != 'colTable')
			{
				$build->makeIndexRowTable($this->model, WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.tpl', $this);
			}
			else
			{
				$build->makeIndexColTable($this->model, WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.tpl', $this);
			}
		}

		$this->model->order = $this->order;
		$pagination = new PandaPagination();
		$pagination->perPage = 50;
		$pagination->allItems =$this->model->getCount();

		$this->model->limit = $pagination->controlSQLLimit();
		$this->data = $this->model->get();

		$this->view->assign('pagination',$pagination->drawNaviBar());
		$this->tpl = 	WEB_DIR.'/'.$this->router->dir.'/'.$this->router->name.'.tpl';
		//$this->model->CreateTableFromDefinition();


	}

	function delete()
	{

		$user = getInstance('PandaUser');

		if($user->isOvner($this->model->get($this->router->params[0])))
		{
			$this->model->del($this->router->params[0]);
			$media = getInstance('PandaMedia');
			$media->delDir($this->router->dir.'/'.$this->router->params[0]);

			Panda::Message("Usunięto wpis o id ". $this->router->params[0]);
		}


		$this->index();
		return 0;
	}

	function edit()
	{

		$user = getInstance('PandaUser');
		if($user->isOvner($this->model->get($this->router->params[0])))
		{
			$this->editData = $this->model->get($this->router->params[0]);
			$this->add();
		}


		return 0;
	}

	function addFoto()
	{
		if(!file_exists(WEB_DIR.'/'.$this->router->dir.'/addFoto.tpl'))
		{
			include_once strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'compbuild.comp.php');
			$build = new UniwersalTableCompBuild();
			$build->makeAddFoto($this->model, WEB_DIR.'/'.$this->router->dir.'/addFoto.tpl');
		}

		$form = new PandaForm();

		if($fotka = $form->save())
		{
			$media = getInstance('PandaMedia');
			$media->add($fotka,$this->router->dir.'/'.$this->router->params[0]);
			Panda::Message("Fotografia została dodana");
		}


		$this->view->assign('form',$form);
		$this->tpl = 	WEB_DIR.'/'.$this->router->dir.'/addFoto.tpl';

	}

	function more()
	{
		if(!file_exists(WEB_DIR.'/'.$this->router->dir.'/more.tpl'))
		{

			include_once strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'compbuild.comp.php');
			$build = new UniwersalTableCompBuild();
			$build->makeMore($this->model, WEB_DIR.'/'.$this->router->dir.'/more.tpl',$this);
		}
		$this->data = $this->model->get($this->router->params[0]);
		$this->tpl = 	WEB_DIR.'/'.$this->router->dir.'/more.tpl';
	}

	function add()
	{

		if(!file_exists(WEB_DIR.'/'.$this->router->dir.'/add.tpl'))
		{

			include_once strtolower(COMPONENTS_DIR.'/'.$this->name.'/'.$this->name.'compbuild.comp.php');
			$build = new UniwersalTableCompBuild();
			$build->makeAdd($this->model, WEB_DIR.'/'.$this->router->dir.'/add.tpl', $this);
		}

		$form = new PandaForm();
		$user = getInstance('PandaUser');

		foreach($this->model->Definition() as $key=>$val)
		{
			if($val['required'] == 1) { $form->addRequired($key); }
			if($val['type'] == "created_at")      { $data[$key] = date("Y-m-d H:i:s"); }
			else if($val['type'] == "updated_at") { $data[$key] = date("Y-m-d H:i:s"); }
			else if($val['type'] == "id_user")    { $data[$key] = $user->id;      }
			else if($val['type'] == "sessid")     { $data[$key] = session_id(); }
			else if($val['type'] == "auth")       { $data[$key] = 1; }
		}



		if($form->isSubmit() AND $form->isValid())
		{
			$data = array_merge($data,$form->submitData);



			$this->model->add($data);
			Panda::Message("Dane zostały dodane");
			$this->index();
			return 0;
		}
		else
		{
			$form->data = $this->editData;
			$form->hidden('id',$this->editData['id']);
		}
		$this->view->assign('form',$form);

		$this->tpl = 	WEB_DIR.'/'.$this->router->dir.'/add.tpl';

	}




}