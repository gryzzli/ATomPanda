<?php

class HeadMod extends PandaModController
{

	var $css   = array();
	var $java  = array();
        var $other = array();
        var $script = array();
        
        var $title;
        var $description;
        var $keywords;
        var $generator;
        
        var $cssi = 0;
        var $jsi = 0;
	function index()
	{
		$ret = '';
		if($this->title != "") { $ret .= '<title>'.$this->title.'</title>'."\n"; }

		if($this->description != "") { $ret .= '<meta name="description"  content="'.$this->description.'" />'."\n"; }
		if($this->keywords != "")    { $ret .= '<meta name="keywords"     content="'.$this->keywords.'" />'."\n"; }
		if($this->generator != "")   { $ret .= '<meta name="Generator"    content="'.$this->generator.'" />'."\n"; }

		foreach($this->css as $val)
		{
                                $ret .= "\n".'<link rel="stylesheet" href="'.HTTP_BASE_URL.'/layout/css/'.$val.'"  type="text/css"/>'."\n";
                }

		foreach($this->java as $val)
		{
                            if(!Panda::ereg("\/\/", $val))
                            {
                               $ret .= "\n".'<script type="text/javascript" charset="utf-8" src="'.HTTP_BASE_URL.'/layout/js/'.$val.'"></script>';    
                            }
                            else
                            {
                                $ret .= "\n".'<script type="text/javascript" charset="utf-8" src="'.$val.'"></script>';    
                            }
                }
                foreach($this->other as $val)
		{
			$ret .= "\n".$val;
		}
                
                foreach($this->script as $val)
		{
			$ret .= "\n<script>\n".$val."\n</script>";
		}

		echo $ret;
	}
        
        function css($val)
        {
            $this->css[$val] = $val;
        }
        
        function java($val)
        {
            $this->java[$val] = $val;
           
        }
        
        function js($val)
        {
              $this->java($val);
        }
         
        function other($val)
        {
            $this->other[] = $val;
        }
        function script($val)
        {
            $this->script[] = $val;
        }
        
        
        


}