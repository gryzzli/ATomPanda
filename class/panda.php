<?php

class Panda
{
	static function Error($error)
	{
	      if(!@array_search($error,$_SESSION['Panda']['Mesages']['Error']))
	      {
		$_SESSION['Panda']['Mesages']['Error'][] = $error;
	      }
	}

	static function Message($message)
	{
		$_SESSION['Panda']['Mesages']['Message'][] = $message;
	}

	static function Notice($message)
	{
		$_SESSION['Panda']['Mesages']['Notice'][] = $message;
	}

	static function Debug($message)
	{
		$_SESSION['Panda']['Mesages']['Debug'][] = $message;
	}
        
       static function ereg($pattern, $subject, &$matches = []) { return preg_match('/'.$pattern.'/', $subject, $matches); } 
       static function eregi($pattern, $subject, &$matches = []) { return preg_match('/'.$pattern.'/i', $subject, $matches); } 
       static function ereg_replace($pattern, $replacement, $string) { return preg_replace('/'.$pattern.'/', $replacement, $string); } 
       static function eregi_replace($pattern, $replacement, $string) { return preg_replace('/'.$pattern.'/i', $replacement, $string); } 
       static function split($pattern, $subject, $limit = -1) { return preg_split('/'.$pattern.'/', $subject, $limit); } 
       static function spliti($pattern, $subject, $limit = -1) { return preg_split('/'.$pattern.'/i', $subject, $limit); } 

}