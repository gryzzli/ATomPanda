<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

require_once(SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php');
function smarty_modifier_timestamp($text)
{
	if($text != "")
	{
		if(smarty_make_timestamp($text) != time())
		{
   		    return smarty_make_timestamp($text);
		}
	}
}

/* vim: set expandtab: */

?>
