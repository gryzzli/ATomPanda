<?php


function smarty_function_button($params, &$smarty)
{


	if($params['link'] == "")
	{
		$router = getInstance('PandaRouter');
		//$params['link'] = HTTP_BASE_URL.'/'.$router->dir.'/'.$params['type'].'/'.$router->params_all.'/'.$params['id'];
                $params['link'] = HTTP_BASE_URL.'/'.$router->dir.'/'.$params['type'].'/'.$params['id'];
	}

	if($params['type'] == 'edit')
	{
		return '<a href="'.$params['link'].'" ><button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-edit" aria-hidden="true" ></span></button></a>';
	}
	else if($params['type'] == 'addFoto')
	{
		return '<a href="'.$params['link'].'" ><img src="'.HTTP_LAYOUT_URL.'/img/image.png" title="Dodaj fotografie"/></a>';
	}
        else if($params['type'] == 'ok')
	{
		return '<a href="'.$params['link'].'" ><button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-ok" aria-hidden="true" ></span></button></a>';
	}

	else if($params['type'] == 'del')
	{
 
		return '<a href="'.$params['link'].'" onClick="javascript:if(!confirm(\'Usunąć ?\')){return false;}"><button type="button" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></a>';
	}
}

/* vim: set expandtab: */

?>
