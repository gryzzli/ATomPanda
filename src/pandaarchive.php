<?php

class PandaArchive
{

  var $file = null;
  var $fileType =  'zip';

  function __construct($file=null)
  {
    $this->setFile($file);
  }

  function setFile($file=null)
  {
      if($file != null)
      {
	$this->file = $file;
	$koncowka = pathinfo($this->file);
	$this->fileType = strtolower($koncowka['extension']);
      }
  }


  function decompress($dir=null)
  {
	    if($dir == null) { $dir = TMP_DIR.'/'.session_id().'/'; }
	    if($this->fileType == 'zip')
	    {
		$zip = new ZipArchive;
		$res = $zip->open($this->file);
		PandaFs::mkdir($dir);
		if ($res === TRUE) 
		{
		      $zip->extractTo($dir);
		      $zip->close();
		      return PandaFs::ShowFiles($dir);
		}

	    }
  }

}