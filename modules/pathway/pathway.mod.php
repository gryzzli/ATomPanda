<?php

class PathwayMod extends PandaModController
{

	function index()
	{

		$router = getinstance('PandaRouter');

		$ret = '<a href="/">Start</a>';
		
		//$lnk = "/";
		$dirs = explode("/",$router->dir);
		foreach($dirs as $val)
		{
		  $lnk .= $val.'/';
		  $ret.= '-><a href="/'.$lnk.'">'.ucwords(str_replace("_"," ",$val)).'</a>';
		}
		echo $ret;
		echo $this->dirs;

	}



}