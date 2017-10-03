<?php

class NaviBarMod extends PandaModController
{

	function index()
	{

		$router = getInstance('PandaRouter');
		$ret = 'Jesteś w katalogu: ';
		$ex = explode("/",$router->dir);

		foreach($ex as $key=>$val)
		{
			$ret .= $val.' / ';
		}


	}

}