<?php

class OnLoadMod extends PandaModController
{
	var $functions="";

	function index()
	{
	  echo 'onload="'.$this->functions.'"';

	
	}

	function add($data)
	{
	  $this->functions = $data."; ";
	}



}