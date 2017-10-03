<?php

class UniwersalTableCompBuild
{

	function makeIndexRowTable(&$model,$file,&$parent)
	{
		//echo '<pre>';
		//print_r( $model->Definition());
		$ret .= '<div class="add"><a href="{{$Panda.RequestWeb}}/add">Dodaj</a></div>';
		$ret .= '<div id="uniwersalTable"> {{$pagination}}
{{foreach item=item from=$data}}
<table class="rowTable">
';

$isFoto = 0;
		foreach($model->Definition() as $key => $val)
		{




			if((!is_array($parent->indexPage['show']) AND PandaSQLTable::isVisible($val['type'])) OR in_array($key,$parent->indexPage['show']))
			{

				$title = $key;
				if($val['title'] != "") { $title = $val['title']; }
				$ret .='{{if $item.'.$key.' != "" AND $item.'.$key.' != "0"}}<tr><th>'.$title.'</td><td>{{$item.'.$key.'}}</td></tr>{{/if}}'."\n";
			}
			if($val['type'] == 'foto')
			{
			        $isFoto = 1;
				$ret .= '<tr><td colspan="2">{{Mod mod=media display=all type=image dir=$item.id}}</td></tr>';
			}
		}
if(is_array($parent->indexPage['show'])) {	$ret .= '<tr><td colspan="2"><A style="font-size: 150%;" href="{{$Panda.RequestWeb}}/more/{{$item.id}}">Więcej...</A></td></tr>'; }
$ret .='
{{if $user->checkperms() OR $user->isovner($item)}}
<tr><td colspan="2">
	{{button type="del" link="`$Panda.RequestWeb`/delete/`$item.id`"}}
   	{{button type="edit" link="`$Panda.RequestWeb`/edit/`$item.id`"}}';

if($isFoto) {  $ret .= '   {{button type="addFoto" link="`$Panda.RequestWeb`/addFoto/`$item.id`"}}'; }
$ret .='</td></tr>
{{/if}}';

$ret .= '
</td></tr>
</table>
{{/foreach}}
{{$pagination}}
</div>
</div>
';

	PandaFS::Save($file,$ret);
	}



	function makeIndexColTable(&$model,$file,&$parent)
	{
		//echo '<pre>';
		//print_r( $model->Definition());
		$ret .= '<div class="add"><a href="{{$Panda.RequestWeb}}/add">Dodaj</a></div>';
		$ret .= '{{$pagination}}<table class="table">';
		$ret.= '<thead><tr>';
		foreach($model->Definition() as $key => $val)
		{


			if((!is_array($parent->indexPage['show']) AND PandaSQLTable::isVisible($val['type'])) OR in_array($key,$parent->indexPage['show']))
			{
				$title = $key;
				if($val['title'] != "") { $title = $val['title']; }
				$ret.= '<td><b>'.$title.'<b/></td>';
			}

		}
		$ret.='</tr></thead>';

$ret .='
{{foreach item=item from=$data}}
<tr>
';

$isFoto = 0;
		foreach($model->Definition() as $key => $val)
		{


			if((!is_array($parent->indexPage['show']) AND PandaSQLTable::isVisible($val['type'])) OR in_array($key,$parent->indexPage['show']))
			{

				$title = $key;
				if($val['title'] != "") { $title = $val['title']; }
				if($val['type'] == 'gg') { $ret .='<td>{{$item.'.$key.'|gg}}</td>'; }
				else if($val['type'] == 'mail') { $ret .='<td>{{$item.'.$key.'|mail}}</td>'; }
				else if($val['type'] == 'www') { $ret .='<td>{{$item.'.$key.'|www}}</td>'; }
				else
				{
					$ret .='<td>{{$item.'.$key.'}}</td>';
				}

			if($val['type'] == 'foto')
			{
				$isFoto = 1;
				$ret .= '<td>{{Mod mod=media display=all type=image dir=$item.id}}</td>';
			}
			}
			if($val['type'] == 'foto')
			{
				$isFoto = 1;

			}
		}
if(is_array($parent->indexPage['show'])) {	$ret .= '<td><A href="{{$Panda.RequestWeb}}/more/{{$item.id}}">Więcej...</A></td>'; }
$ret .='
{{if $user->checkperms() OR $user->isovner($item)}}
<td>
	{{button type="del" link="`$Panda.RequestWeb`/delete/`$item.id`"}}
   	{{button type="edit" link="`$Panda.RequestWeb`/edit/`$item.id`"}}';

if($isFoto) {  $ret .= '   {{button type="addFoto" link="`$Panda.RequestWeb`/addFoto/`$item.id`"}}'; }
$ret .='
{{/if}}</td>';


$ret .= '
</td>
</tr>
{{/foreach}}
</table>{{$pagination}}';

	PandaFS::Save($file,$ret);
	}



	function makeMore(&$model, $file, &$parent)
	{
	
		$ret = '  <div class="add"><a href="{{$Panda.RequestWeb}}">Powrót</a></div>
			  <h1>'.$parent->title.'</h1>';
		$ret .= '<div id="UniversalTable"><table id="table">';

		foreach($model->Definition() as $key => $val)
		{

			if(PandaSQLTable::isVisible($val['type']))
			{

				$title = $key;
				if($val['title'] != "") { $title = $val['title']; }

				if($val['type'] == "googlearea")
{
  $ret .='
{{if $data.'.$key.' != "" AND $data.'.$key.' != "0"}}
<tr>
	<td colspan="2">{{Mod mod=googlearea data=$data.'.$key.'}} </td>
</tr>

{{/if}}';
}
else

{
				$ret .='
{{if $data.'.$key.' != "" AND $data.'.$key.' != "0"}}
<tr>
	<td><b>'.$title.'<b/></td>
	<td>{{$data.'.$key.'}}</td>
</tr>

{{/if}}';
}


			}
			if($val['type'] == 'foto')
			{
				 $isFoto = 1;
				$ret .= '{{Mod mod=media display=all type=image dir=$item.id}}';
			}
		}
		$ret .='

{{if $user->checkperms() OR $user->isovner($item)}}
<div class="operations">
    {{button type="del" link="`$Panda.RequestWeb`/delete/`$data.id`"}}
   	{{button type="edit" link="`$Panda.RequestWeb`/edit/`$data.id`"}}';

 if($isFoto) {  $ret .= '{{button type="addFoto" link="`$Panda.RequestWeb`/addFoto/`$data.id`"}}'; }
$ret .='</div>
{{/if}}';



		$ret .= '</table>{{Mod mod=media display=all type=image dir=$data.id}}</div>';
		PandaFS::Save($file,$ret);
	}


	function makeAddFoto(&$model,$file)
	{
		$ret .= '<div class="add"><a href="{{$Panda.RequestWeb}}">Powrót</a></div>{{$form->start()}}';
		$ret .= '<table style="width: 100%">';
		$ret .= '<tr><td>Fotografia z dysku: </td><td>{{$form->fileFromDisk()}}</td></tr>';
		$ret .= '<tr><td>Fotografia z sieci: </td><td>{{$form->fileFromNet()}}</td></tr>';
		$ret .= '<tr><td></td><td>{{$form->submit()}}</td></tr>';
		$ret .= '</table>';
		$ret .= '{{$form->stop()}}';

		PandaFS::Save($file,$ret);
	}


	function makeAdd(&$model,$file,&$parent)
	{
		$ret = '<div class="add"><a href="{{$Panda.RequestWeb}}">Powrót</a></div> <h1>'.$parent->title.'</h1>';
		$ret .= '<h2>Dodaj</h2>';
		$ret .= '{{$form->start()}}';
		$ret .= '<table style="width: 100%">';
		foreach($model->Definition() as $key => $val)
		{

			if(PandaSQLTable::isVisible($val['type']))
			{
				$title = $key;
				if($val['title'] != "") { $title = $val['title']; }
				$ret .='<tr><td> '.$title.'</td><td> {{$form->'.PandaSQLTable::type2form($val['type']).'('.$key.')}} </td></tr>'."\n";
			}
		}
		if($parent->antyBot) { $ret .= '<tr><td></td><td>{{$form->antyBot()}}</td></tr>'; }
		$ret .= '<tr><td></td><td>{{$form->submit()}}</td></tr>';
		$ret .= '</table>';
		$ret .= '{{$form->stop()}}';

		PandaFS::Save($file,$ret);
	}

}