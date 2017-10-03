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
function smarty_block_h($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    
    $HeadMod = Getinstance('HeadMod');
    if($content != "")
    {
        $HeadMod->title= $HeadMod->title.' - '.$content ;     
    }
        
    if(!isset($params['type'])) { $params['type'] = 'h1'; }
    if(!isset($params['noprint'])) 
    { 
        return '<'.$params['type'].'>'.$content.'</'.$params['type'].'>';
    }
    else
    {
        return '';
    }
}
?>