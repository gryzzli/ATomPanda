<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

require_once(SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php');
function smarty_modifier_data($text)
{
	if($text != "")
	{
		if(smarty_make_timestamp($text) != time())
		{
   		    return strftime("%d.%m.%Y", smarty_make_timestamp($text));
		}
	}
}

/* vim: set expandtab: */

?>
