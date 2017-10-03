<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */



function smarty_modifier_gg($text)
{
	if($text != "" && $text != 0)
	{
    		return '<img src="http://www.gadu-gadu.pl/users/status.asp?id='.$text.'&styl=1" title="'.$text.'"/>';
	}
}

/* vim: set expandtab: */

?>
