<?php

class PandaConfig
{

	static function get($file,$section=null)
	{
		if(file_exists(USER_CONFIG_DIR.'/'.$file.'.conf.php'))
		{
			if($section == null) { return include USER_CONFIG_DIR.'/'.$file.'.conf.php'; }
			else { $ret =  include USER_CONFIG_DIR.'/'.$file.'.conf.php'; return $ret[$section]; }
			
		
		}
		else if(file_exists(CONFIG_DIR.'/'.$file.'.conf.php'))
		{
			if($section == null) { return include CONFIG_DIR.'/'.$file.'.conf.php'; }
			else { $ret =  include CONFIG_DIR.'/'.$file.'.conf.php'; return $ret[$section]; }
		}
                else { return null; }
	}

}