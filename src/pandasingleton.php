<?php

class PandaSingleton
{

  

    
    public static function instance($name,$instance='default',$noinit=0)
    {


        $params = null;
        if(is_array($name))
        {
            $params = $name[1];
            $name = $name[0];
        }

	$name = ucfirst($name);
	if(null == $GLOBALS['Object'][$name][$instance]['object'])
	{
            if($noinit==0)
            {
                if(isset($GLOBALS['Object'][$name][$instance]['params']))
                {
                    $params = $GLOBALS['Object'][$name][$instance]['params'];
                }
                
                echo '-'.$name.'-';
		$object = new $name($params);
            }
            else
            {
                $GLOBALS['Object'][$name][$instance]['params'] = $params;
            }
		
            if($object->noInstance!=1)
		{
			$GLOBALS['Object'][$name][$instance]['object'] =& $object;
		}
		else
		{
			return $object;
		}
	}
	return  $GLOBALS['Object'][$name][$instance]['object'];

  }
}
?>
