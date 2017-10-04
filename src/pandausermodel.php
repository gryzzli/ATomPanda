<?php

class PandaUserModel
{
	var $table = 'PandaUsers';
	var $tablePerms = 'PandaUsers_Perms';
	var $userInfo = array();

	function __construct()
	{
		$this->db = getinstance('Medoo\Medoo');
		//$this->import();
	}




	function addUser($user, $pass,$email='')
	{
		#$this->_users[$user] = $pass;
		$row = $this->db->get($this->table, "user",['user'=>$user]);
		if($row['user'] == "")
		{
			$this->db->insert($this->table,array(email=>$email,user=>$user, pass=>$pass, created_at=>date("Y-m-d H:i:s")));
			Panda::Message("Użytkownik został dodany");
			return 1;
		}
		else
		{
			Panda::Error("Użytkownik <b>$user</b> już istnieje");
			return 0;
		}
	}

	function addPerm($user, $perms, $value=1)
	{
		$row = $this->db->get($this->tablePerms, "*", ['AND'=>['id_user'=>$this->_getUserId($user), 'perms'=>strtolower($perms)]]);
		if($row['id_user'] == "")
		{
			$this->db->insert($this->tablePerms,array(id_user=>$this->_getUserId($user), perms=>strtolower($perms),value=>(strtolower($value))));
		}
	}



	function _getUserId($user)
	{
		$row = $this->db->get($this->table, "id", ['user'=>$user]);
		return $row['id'];
	}

	function checkUser($user, $pass)
	{

		if($this->_users[$user] == $pass) { return 1; }
		else
		{
                       
			$row = $this->db->get($this->table,"*",['AND'=>['user'=>$user, 'pass'=>$pass]]);
                       
			if($row['user'] != "")
			{
                               
				
				$row2 =  $this->db->select($this->tablePerms, ['perms', 'value'],['id_user'=>$row['id']]);
                             
				$this->userInfo['perms'] = array();
				foreach($row2 as $val)
				{
					$this->userInfo['perms'][$val['perms']] = $val['value'];
					
				}


				return 1;
			}
		}
		return 0;
	}

	function getUserInfo()
	{
		return $this->userInfo;
	}

	function checkPerms($perms=null)
	{


		if(!$this->parent->isLogin()) { return 0; }

		if($perms == null)
		{
			$router = getInstance('PandaRouter');
			$perms = $router->dir;
		}
		
		
		if($this->userInfo['perms'][strtolower($perms)]) { return 1; }
		if($this->isOP()) { return 1; }
		if($this->managedPerms($perms))  { return 1; }
		return 0;
	}
  
	function checkPermsVal($pval,$perms=null)
	{
		if(!$this->parent->isLogin()) { return 0; }
		if($this->isSOP()) { return 1; }
		if($this->isOP())  { return 1; }

		
		if($perms == null)
		{
			$router = getInstance('PandaRouter');
			$perms = $router->dir;
		}
		foreach( $this->userInfo['perms'] as $key=>$val)
		{

		
		
			if(preg_match('/^'.str_replace("/","\/",$key).'$/',$perms)) { if($val == $pval) { return 1; } }

		}

		return 0;
	}



	function webCreatePerms($perms=null)
	{
		if(!$this->parent->isLogin()) { return 0; }
		if($this->isSOP()) { return 1; }
		if($this->isOP())  { return 1; }


		if($perms == null)
		{
			$router = getInstance('PandaRouter');
			$perms = $router->dir;
		}
		foreach( $this->userInfo['perms'] as $key=>$val)
		{

			if(preg_match('/^'.str_replace("/","\/",$key).'$/',$perms)) { if($val == 'webcreate') { return 1; } }

		}

		return 0;
	}
	function webEditPerms($perms=null)
	{
		if(!$this->parent->isLogin()) { return 0; }
		if($this->webCreatePerms($perms))  { return 1; }


		if($perms == null)
		{
			$router = getInstance('PandaRouter');
			$perms = $router->dir;
		}
		foreach( $this->userInfo['perms'] as $key=>$val)
		{

			if(preg_match('/^'.str_replace("/","\/",$key).'$/',$perms)) { if($val == 'webedit') { return 1; } }

		}

		return 0;
	}
	function managedPerms($perms=null)
	{
		if(!$this->parent->isLogin()) { return 0; }
		if($this->webEditPerms($perms))  { return 1; }

		if($perms == null)
		{
			$router = getInstance('PandaRouter');
			$perms = $router->dir;
		}
		foreach( $this->userInfo['perms'] as $key=>$val)
		{

			if(preg_match('/^'.str_replace("/","\/",$key).'$/',$perms)) { if($val == 'managed') { return 1; } }

		}

		return 0;
	}

	function addPerms($perms=null)
	{
		if(!$this->parent->isLogin()) { return 0; }
		if($this->managedPerms($perms))  { return 1; }


		if($perms == null)
		{
			$router = getInstance('PandaRouter');
			$perms = $router->dir;
		}
		foreach( $this->userInfo['perms'] as $key=>$val)
		{

			if(preg_match('/^'.str_replace("/","\/",$key).'$/',$perms)) { if($val == 'add') { return 1; } }

		}
		return 0;
	}



	function IsSOp()
	{
		return $this->userInfo['perms'][strtolower('sop')];
	}

	function isOP()
	{
		if($this->isSOP()) { return 1; }
		return $this->userInfo['perms'][strtolower('op')];
	}

}