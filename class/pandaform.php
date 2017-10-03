<?php

class PandaForm
{

	var $_hidden = array();
	var $_required = array();
        var $tinymce = 0;

	function __construct($name='form')
	{
		static $name2;

		if($name2 == '') { $name2 = $name;}
		else { $name2++; $name = $name2; }
		$this->name = $name;
		$this->data = $_POST[$this->name];

	}

	function start()
	{
		$ret = '<form method="post" action="" enctype="multipart/form-data">'."\n";

		foreach($this->_hidden as $key=>$val)
		{
			if($this->_id[$key] != "") { $id = 'id="'.$this->_id[$key].'"'; } else { $id = ""; }
			$ret .= '<input '.$id.' type="hidden" name="'.$this->name.'['.$key.']" value="'.$val.'"/>'."\n";
		}

		return $ret;
	}

	function stop()
	{


		return '</form>';
	}


	function antyBot()
	{
		$value = $this->data['_antybot'];
		if($this->_getRequired('_antybot') != "") { $style = 'Style="Background-color: #FF9A9C;"'; }
		$ret = '<input  type="hidden" value="1" name="'.$this->name.'[_ss]"/>';
		//if($_REQUEST["PHPSESSID"] != "")
		//{
                    
		  return $ret.'Wpisz tekst: <b>'.substr(session_id(),4,1).''.substr(session_id(),7,1).'</b> w tym polu --> '.$this->_getRequired('_antybot').' <input '.$style.' type="text" name="'.$this->name.'[_antybot]" value="'.$value.'"/>';
		//}
		//else
		//{
		//  return $ret.'Wpisz tekst: <b>'.(date("d")-date("m")).'</b> w tym polu --> '.$this->_getRequired('_antybot').' <input '.$style.' type="text" name="'.$this->name.'[_antybot]" value="'.$value.'"/>';
		//}
	}


	function submit($value="Zapisz")
	{
		return '<input type="submit" name="'.$this->name.'[_submit]" value="'.$value.'"/>';
	}


	function googlearea($name)
	{
	  $value = $this->data[$name];
	  $this->_id[$name] = "googlearea";
	  $onloadmod = getInstance('onloadMod');
	  $onloadmod->add('buildMap()');

	   $ret =   '<div id="map" style="width: 100%; height: 500px;"> </div>
		    <div id="status" style="width: 100%"></div>
		     <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAA1fAvo09AqnBxLrddDtyB5RTlt8efZf6hrL1buWQ5terf9vOvtBQVLTSY2K6iMnuulEFxrlOuyZBi7Q" type="text/javascript"></script>
		    
		  ';
	  $ret .= ' <script type="text/javascript">
		   function addSavedPoints()
		   {
			';
			foreach(explode("; ",$value) as $val) 
			{ 
			  if($val != "")
			  {
			    $ex = explode(",",str_replace(")","",str_replace("(","",$val)));
			    $ret .= 'addPoint(new GLatLng('.$ex[0].', '.$ex[1].'));'."\n"; 
			    
			  }
			}
		  
			 if(is_array($ex)) { $ret .=  "\n map.setCenter(new GLatLng(".$ex[0].", ".$ex[1]."), 17); \ndrawOverlay();"; };
			
          $ret .=  '}
	  </script>';

           $ret .= '<input id="googlearea" type="hidden" name="'.$this->name.'['.$name.']" />'."\n";
	   $ret .='    <a  onclick="clearMap();">Wyszyść zaznaczenie</a>
		   <script src="/lib/google/map/area.js" type="text/javascript"></script>
';
	  return $ret;
	}

	function text($name)
	{

		$value = $this->data[$name];
		$style = $this->_getStyle($name,'text');
		$req = $this->_getRequired($name);

		return $req.'<input type="text" style="'.$style.'" name="'.$this->name.'['.$name.']" value="'.htmlentities($value).'"/>';
	}

	function password($name)
	{

		$value = $this->data[$name];
		$style = $this->_getStyle($name,'text');
		$req = $this->_getRequired($name);
		return $req.'<input type="password" style="'.$style.'" name="'.$this->name.'['.$name.']" value="'.$value.'"/>';
	}

	function int($name)
	{

		$value = $this->data[$name];
		$style = $this->_getStyle($name,'int');
		$req = $this->_getRequired($name);

		return $req.'<input type="text" style="'.$style.'" name="'.$this->name.'['.$name.']" value="'.$value.'"/>';
	}

	function checkbox($name)
	{
		$value = $this->data[$name];
             
		$style = $this->_getStyle($name);
		if($value == "1") { $checked = 'checked'; }

		return '<input type="checkbox" style="'.$style.'" value="1" name="'.$this->name.'['.$name.']" '.$checked.'/>';

	}

	function textarea($name)
	{
		$value = $this->data[$name];
		$style = $this->_getStyle($name,'textarea');
		$req = $this->_getRequired($name);
		return $req.'<textarea style="'.$style.'" name="'.$this->name.'['.$name.']">'.$value.'</textarea>';
	}

	function richtextarea($name)
	{
		$value = $this->data[$name];
		$style = $this->_getStyle($name,'textarea');
		$req = $this->_getRequired($name);

                $ret = "";
                 if(!$this->tinymce)
                 {
                     $ret = '<script type="text/javascript" src="'.HTTP_BASE_URL.'/lib/tinymce/tinymce.min.js"></script>';
                     $this->tinymce = 1;
                 }

		$ret .=  '
		
		<script type="text/javascript">
		tinyMCE.init({
                        
			selector                           : "#'.$this->name.'_'.$name.'",
			content_css                        : "'.HTTP_LAYOUT_URL.'/css/template.css",
			language                           : "pl",
                        plugins                            : "advlist autolink link image lists charmap print preview",

			convert_urls 			   : false
			});

		</script>';




		return $ret.''.$req.'<textarea  style="'.$style.'" id="'.$this->name.'_'.$name.'" name="'.$this->name.'['.$name.']">'.$value.'</textarea>';
	}

	function simpletextarea($name)
	{
		$value = $this->data[$name];
		$style = $this->_getStyle($name,'textarea');
		$req = $this->_getRequired($name);



                $ret = "";
		 if(!$this->tinymce)
                 {
                     $ret = '<script type="text/javascript" src="'.HTTP_BASE_URL.'/lib/tinymce/tinymce.min.js"></script>';
                     $this->tinymce = 1;
                 }

		$ret .=  '
		<script language="javascript" type="text/javascript">
		tinymce.init({
                        
			selector                           : "#'.$this->name.'['.$name.']",
			content_css                        : "'.HTTP_LAYOUT_URL.'/css/template.css",
			language                           : "pl",
			convert_urls 			   : false
			});

		</script>';




		return $ret.''.$req.'<textarea style="'.$style.'" id="'.$this->name.'['.$name.']" name="'.$this->name.'['.$name.']">'.$value.'</textarea>';
	}

	function hidden($name, $value)
	{
		$this->_hidden[$name] = $value;
	}


	function addOptions($name,$options)
	{
	       if(is_array($options) )
	       {
	         $this->_options[$name] = $options;
	       }
	       else
	       {
		$this->_options[$name][] = $options;
		}
	}

	function date($name)
	{
		$value = $this->data[$name];
		if($value == '') { $value = date('Y-m-d H:i'); }
		$style = $this->_getStyle($name,'date');
		return '<input type="text" style="'.$style.'" name="'.$this->name.'['.$name.']" value="'.$value.'"/>';
	}

        
	function select($name)
	{

		$value = $this->data[$name];

		$ret .= '<select name="'.$this->name.'['.$name.']">';
		foreach($this->_options[$name] as $key=>$val)
		{
			if($val == $value) { $ret .= '<option value="'.$key.'" selected>'.$val.'</option>'."\n"; }
			else { $ret .= '<option value="'.$key.'">'.$val.'</option>'."\n"; }

		}

		$ret .= '</select>';
		return $ret;
	}

	function imageOptions()
	{

		 switch($this->data['_imageOptions']['size'])
		{
			case ''        : $none    = 'selected'; break;
			case 'Orginal' : $orginal = 'selected'; break;
			case 'Max600'  : $max600  = 'selected'; break;
			case 'Max800'  : $max800  = 'selected'; break;
			case 'Max1000' : $max1000  = 'selected'; break;
			case 'Max1200' : $max1200  = 'selected'; break;
			case 'Max1400' : $max1400  = 'selected'; break;
			case 'Max1600' : $max1600  = 'selected'; break;

		}

		$ret = 'Rozmiar: <select name="'.$this->name.'[_imageOptions][size]">
			   <option '.$none.'    value="">Według ustawień systemowych</option>
		           <option '.$orginal.' value="Orginal">Rozmiar orginalny</option>
			   <option '.$max600.'  value="Max600">Max: 600px</option>
			   <option '.$max800.'  value="Max800">Max: 800px</option>
			   <option '.$max1000.' value="Max1000">Max: 1000px</option>
			   <option '.$max1200.' value="Max1200">Max: 1200px</option>
			   <option '.$max1400.' value="Max1400">Max: 1400px</option>
			   <option '.$max1600.' value="Max1600">Max: 1600px</option>
		        </select>';
		$ret .= '<br/>Znak wodny: <input type="checkbox"  name="'.$this->name.'[_imageOptions][watermark]"/>';


		return $ret;


	}

	function fileFromDisk()
	{
		$ret = '<input type="file" name="'.$this->name.'_file"/>
		<input type="submit" value="załaduj" name="'.$this->name.'[_zaladuj]"/>';
        	return $ret;
	}

	function fileFromNet()
	{
		$ret = '<input type="text" style="width: 268px" name="'.$this->name.'[_url][file]" value="http://"/
                        <input type="submit" value="załaduj" name="'.$this->name.'[_zaladuj]"/>';
        	return $ret;
	}

	function required($data)
	{
		foreach($data as $val)
		{
			$this->_required[$val] = 1;
		}
	}

	function addRequired($data)
	{
		$this->_required[$data] = 1;
	}


	function style($name,$style)
	{
		$this->_style[$name] = $style;
	}

	function addStyle($name,$style,$value)
	{
		$this->_style[$name][$style] = $value;
	}

	function _getStyle($name,$type='')
	{


		if($type=='textarea')
		{
			if($this->_style[$name]['height'] == "") { $this->addStyle($name,'height','200px'); }
		}

		if($type=='date')
		{
			if($this->_style[$name]['width'] == "") { $this->addStyle($name,'width','12em'); }
		}

		if($this->_style[$name]['width'] == "") { $this->addStyle($name,'width','99%'); }

		if(is_array($this->_style[$name]))
		{
			foreach($this->_style[$name] as $key=>$val)
			{
				$ret .= $key.': '.$val.';';
			}
		}
		return $ret;
	}

	function isSubmit()
	{

		if($_POST[$this->name]['_submit'] != "")
		{
		//	if(substr($_REQUEST["PHPSESSID"],4,1).''.substr($_REQUEST["PHPSESSID"],7,1) == $_POST[$this->name]['_antybot'])
		//	{
				$this->getSubmitData();

				return 1;
			//}
		}

		return 0;
	}

	function isValid()
	{

		$this->_isValidChecked = 1;
		foreach($this->_required as $key => $val)
		{
			if(trim($_POST[$this->name][$key]) == "") {  return 0; }
		}

		if($_POST[$this->name]['_ss'] == 1)
		{
                   
			//print_R($_POST); 
			if($_POST[$this->name]['_antybot'] != "")
			{
                            
			  if(substr(session_id(),4,1).''.substr(session_id(),7,1) != $_POST[$this->name]['_antybot'])
			  {
                               
				  $this->_required['_antybot'] = 1;
				  return 0;
			  }
			  else {  }
			}
                        else
                        {
                            return 0;
                        }
			

		}

		return 1;


	}

	function _getRequired($name)
	{

		if($this->isSubmit() AND $this->_required[$name] == 1 AND $this->data[$name] == "")
		{
			return '<div  style="font-size: 70%; color: red; position: absolute; padding-left: 5px;">To pole jest wymagane</div>';
		}
	}

	function getSubmitData()
	{

		foreach($_POST[$this->name] as $key=>$val)
		{
			if(!preg_match("/^_/",$key)) { $this->submitData[$key] = $val; }
		}

	}

	function Save($plik='file')
	{
		if($_FILES[$this->name.'_'.$plik]['name'] != "")
		{

                	if($_FILES[$this->name.'_'.$plik]['tmp_name'] == "") { return 0; }
			PandaFs::copy($_FILES[$this->name.'_'.$plik]['tmp_name'], TMP_DIR."/".$_FILES[$this->name.'_'.$plik]['name']);
			$ret = TMP_DIR."/".$_FILES[$this->name.'_'.$plik]['name'];
			return $ret;
		}
		elseif($_POST[$this->name]['_url'][$plik] != "" && $_POST[$this->name]['_url'][$plik] != "http://")
		{
			$url  = $_POST[$this->name]['_url'][$plik];
			$plk  = basename($url);
			$url  = str_replace("%5C", "/", $url);
			$f    = fopen($url,"r");
			$f2   = fopen(TMP_DIR."/".$plk,"w+");
			while ($r=fread($f,8192) ) { fwrite($f2,$r); }
			fclose($f2);
			fclose($f);
			$ret  = TMP_DIR."/".$plk;
			return $ret;
		}
		else { return 0; }
	}




}