<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

require_once(SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php');
function smarty_modifier_days_left($text)
{
	if($text != "")
	{
		if(smarty_make_timestamp($text) != time())
		{
   		   // return strftime("%d.%m.%Y", smarty_make_timestamp($text));
                    $datetime1 = new DateTime(date('Y-m-d'));
                    $datetime2 = new DateTime($text);
                    $interval = $datetime1->diff($datetime2);
                    return $interval->format('%R%a ');
		}
	}
}

/* vim: set expandtab: */

?>
