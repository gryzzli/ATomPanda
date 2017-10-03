<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.translate.php
 * Type:     block
 * Name:     translate
 * Purpose:  translate a block of text
 * -------------------------------------------------------------
 */
function smarty_block_metakeywords($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    
    $HeadMod = Getinstance('HeadMod');
    if($content != "")
    {
        $HeadMod->keywords = $content ;     
    }
        
        return '';
    
}
?>