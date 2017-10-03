<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
require_once(SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php');

function smarty_modifier_data_czas($text)
{
	if($text != "")
	{
   		return strftime("%d.%m.%Y %H:%I", smarty_make_timestamp($text));
	}
}

/* vim: set expandtab: */

?>
