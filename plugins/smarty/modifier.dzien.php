<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
require_once(SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php');

function smarty_modifier_dzien($text)
{
	if($text != "")
	{
   		$dzien =  strftime("%u", smarty_make_timestamp($text));
		switch($dzien)
		{
			case 1: $ret = 'Poniedziałek'; break;
			case 2: $ret = 'Wtorek'; break;
			case 3: $ret = 'Środa'; break;
			case 4: $ret = 'Czwartek'; break;
			case 5: $ret = 'Piątek'; break;
			case 6: $ret = 'Sobota'; break;
			case 7: $ret = 'Niedziela'; break;
		}
		return $ret;
	}
}

/* vim: set expandtab: */

?>
