<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */



function smarty_modifier_email($text)
{
    return '<a href="mailto:'.$text.'">'.$text.'</a>';
}

/* vim: set expandtab: */

?>
