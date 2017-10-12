<?php




class PandaRouter
{

	var $dir;
	var $controller;
	var $method;
	var $methodAlternative;
	var $params;
	var $params_all;
	var $paramsAlternative;
        var $lang = '';

	function __construct()
	{
		$this->get();
	}

	function redirectBack()
	{
		header("Location: ".$_SERVER['HTTP_REFERER'] );
		die();
	}

	function redirect($url)
	{
	    header("Location: ".$url);
	    die();
	}
        
        function redirectPermanent($url)
        {
            header("Location: ".$url, true, 301);

	    die();
        }
        function redirectPermanentReplace($replace,$replaceto = "")
        {
            $url = str_replace($replace,$replaceto, HTTP_BASE_URL.$_SERVER['REQUEST_URI']);
            
            
            header("Location: ".$url, true, 301);

	    die();
        }

	function get()
	{
		//$tmp = explode("/",$_SERVER["REQUEST_URI"]);
                
                
                
                
                        
                $path = str_replace(WEB_PATH,"",str_replace(WEB_PATH.'/public_html',"",$_SERVER["REQUEST_URI"]));
               // $path = str_replace("site/index.php/pl","",$path);
               // $path = str_replace("site/index.php/en","/en",$path);
                
                //echo $path;
                
                $tmp = explode("/",$path);
               
              
                
                
		$urlArray = array();
		foreach($tmp as $val) { if(trim($val) != "") { $urlArray[] = $val; }}

                if(strtolower($urlArray[0]) == "pl")
                {
                    array_splice($urlArray,0,1);
                }
                else if(strtolower($urlArray[0]) == "en" || strtolower($urlArray[0]) == "fr")
                {
                     $this->lang = strtolower($urlArray[0]);
                     array_splice($urlArray,0,1);
                     
                     $tmp = PandaConfig::get('router/redirection.'.$this->lang);
                     
                     foreach($tmp as $key=>$val)
                     {
                         
                         $ok=0;
                         if(Panda::eregi("\/",$key))
                         {
                            
                              $tmp2 = explode("/",$key);
                              foreach($tmp2 as $key2=>$val2)
                              {
                                 
                                  if(strtolower($urlArray[$key2]) == $val2)
                                  {
                                      $ok=1;
                                      
                                  }
                                  else {
                                      $ok = 0;
                                  }
                              }
                              
                              if($ok == 1)
                              {
                            
                                  
                                   array_splice($urlArray,0,count($tmp2));
                                   $tmp2 = explode("/",$val);
                                   for($i=count($tmp2)-1; $i >= 0; $i--)
                                   {
                                       array_unshift($urlArray, $tmp2[$i]);
                                   }
                                
                                  break;
                              }
                             
                             
                         }
                         
                        
                         
                         if(strtolower($urlArray[0]) == $key)
                         {
                             $urlArray[0] = $val;   
                             break;
                         }
                     }                  
                      
                    
                }

		$urlArray2 = $urlArray;
		foreach($urlArray2 as $key => $val)
		{
                 //   echo WEB_DIR.'/'.implode("/",$urlArray2).'/'.$urlArray2[count($urlArray2)-1].'.main.php';
                   //         echo '<br/>';
                   
			if(file_exists(strtolower(WEB_DIR.'/'.implode("/",$urlArray2).'/'.$urlArray2[count($urlArray2)-1].'.main.php')))
			{


			$this->dir =  strtolower(implode("/",$urlArray2));
			$this->controllerFile = strtolower($urlArray2[count($urlArray2)-1].'.main.php');
			$this->controller     = str_replace('-','',str_replace("~","",$urlArray2[count($urlArray2)-1])).'Main';
			$this->name     = $urlArray2[count($urlArray2)-1];

			if($urlArray[count($urlArray2)] != "")
			{
				$this->method = $urlArray[count($urlArray2)];
				$this->methodAlternative = 'index';

				for($i=count($urlArray)-$key+1; $i < count($urlArray); $i++)
				{
					$this->params[] = $urlArray[$i];
					if(is_numeric($this->params[0])) { $this->id = $this->params[0]; }
					$this->params_all  .= $urlArray[$i].'/';
				}

			}
			else
			{
				$this->method = index;
				for($i=count($urlArray)-$key+1; $i < count($urlArray); $i++)
				{
					$this->params[] = $urlArray[$i];
					if(is_numeric($this->params[0])) { $this->id = $this->params[0]; }
					$this->params_all  .= $urlArray[$i].'/';
				}
			}


				for($i=count($urlArray)-$key; $i < count($urlArray); $i++)
				{
					$this->paramsAlternative[] = $urlArray[$i];
					if(is_numeric($this->paramsAlternative[0])) { $this->id = $this->paramsAlternative[0]; }
					$this->paramsAlternative_all .= $urlArray[$i].'/';
				}

			//break;
			return 1;
			}
                        
			else
			{
				unset($urlArray2[count($urlArray2)-1]);
			}

		}
			$this->dir =  '';
			$this->controllerFile = 'default.main.php';
			$this->controller     = 'DefaultMain';
			$this->name     = "Default";



	}

	function MethodNotExists()
	{
		$this->params     = $this->paramsAlternative;
		$this->params_all = $this->paramsAlternative_all;
		$this->method     = 'index';
	}

}