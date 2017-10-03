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
function smarty_block_metadescription($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    
    $HeadMod = Getinstance('HeadMod');
    if($content != "")
    {
        $HeadMod->description = $content ;     
    }
        
        return '';
    
}
?>