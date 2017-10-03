<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */



function smarty_modifier_www($text)
{
    return '<a href="http://'.$text.'" target="_new">'.$text.'</a>';
}

/* vim: set expandtab: */

?>
