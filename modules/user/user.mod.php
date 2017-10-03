<?php

class UserMod extends PandaModController
{

	function index()
	{

		$this->user = getInstance('PandaUser');

		if($this->user->isLogin()) { $this-> UserLogged(); return 0; }
		$this->tpl = 'user';
	}

	function userLogged()
	{
		$this->tpl = 'userlogged';
	}
}