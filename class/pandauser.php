<?php

class PandaUser
{

	var $login="";
	var $password="";
	var $id=0;
	var $isLogin="";

	function __construct()
	{

	}

	function setModel(&$model)
	{
		$this->model = $model;
		$this->model->parent =& $this;

		$this->isLogin();
		$this->login($this->login,$this->password);
	}

	function isOp()  { return $this->model->isOP();  }
	function isSOp() { return $this->model->isSOP(); }
	function isOvner($data)
	{
            
          
		if($this->isOP()) { return 1; }
		//if($data['id'] == $this->id) { return 1; }
		if($data['sessid'] ==  session_id() AND $data['sessid'] != "") {  return 1; }
		if($data['id_user'] == $this->id AND $this->id != 0) { return 1; }
		return 0;
	}

	function checkPerms($perms=null)       { return $this->model->checkPerms($perms); }
	function checkPermsVal($pval,$perms=null) { return $this->model->checkPermsVal($pval,$perms=null); }
	function webCreatePerms($perms=null)   { return $this->model->webCreatePerms($perms); }
	function webEditPerms($perms=null)     { return $this->model->webEditPerms($perms); }
	function managedPerms($perms=null)     { return $this->model->managedPerms($perms); }
	function addPerms($perms=null)         { return $this->model->addPerms($perms); }
	


	function login($user, $pass)
	{
		if($this->model->checkuser($user,$pass) AND $user != "" AND $pass != "")
		{
			$this->login    = $user;
			$this->password = $pass;
			$this->isLogin = 1;

			$this->userInfo = $this->model->getUserInfo();
			$this->id = $this->userInfo['id'];

		}
		else
		{
			$this->isLogin = 0;
			$this->password = 0;
			$this->id = 0;
		}

		   $_SESSION['Pandauser']['isLogin']  = $this->isLogin;
		   $_SESSION['Pandauser']['login']    = $this->login;
		   $_SESSION['Pandauser']['password'] = $this->password;
		   $_SESSION['Pandauser']['id'] = $this->id;
		return  $this->isLogin;

	}

	function isLogin()
	{
		if($this->isLogin == "")
		{
			if($_SESSION['Pandauser']['isLogin'] == 1 AND $_SESSION['Pandauser']['login'] != "")
			{

				$this->isLogin  = 1;
				$this->login    = $_SESSION['Pandauser']['login'];
				$this->password = $_SESSION['Pandauser']['password'];
				$this->id = $_SESSION['Pandauser']['id'];
				return 1;
			}
			else
			{

				return 0;
			}

		}
		else { return $this->isLogin; }
	}

	function logout()
	{
		$this->isLogin = 0;
		$this->isLogin = 0;
		$this->password = 0;
		unset( $_SESSION['Pandauser']);
	}




}