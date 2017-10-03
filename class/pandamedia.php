<?php

class PandaMedia
{

	var $tableVideo = 'PandaMedia_video';
	var $tableImage = 'PandaMedia_image';
	var $tableAudio = 'PandaMedia_audio';
	function __construct()
	{
		$this->db = getInstance('Medoo');
                $this->description = "Grzybowice.pl ". Date("Y");

	}

	function add($plik, $dir,$typ='media')
	{
		if($typ == 'plik')
		{
			PandaFs::Remove($plik,MEDIA_DIR.'/file/'.$dir.'/'.basename($plik));
		}
		else
		{
			$typ2 = $this->_fileType($plik);
			if($typ2 == 'compressed')
			{
			    
			    $archive = new PandaArchive($plik);
			    $files =  $archive->decompress(TMP_DIR.'/'.session_id().'/');
			    foreach($files as $val)
			    {
			     
			      $this->add(TMP_DIR.'/'.session_id().'/'.$val,$dir,$typ);

			    }

			    
			}
			else
			{
			  if($typ2 == 'image')
			  {
                          
				  $fotoFile = PandaFs::Remove($plik, MEDIA_DIR.'/'.$typ2.'/'.$dir.'/big/'.basename($plik));
				  $foto = new PandaFoto();
				  if($this->resize != '0' OR $this->resize == "")
				  {
                                     
					  if($this->resize != "") { $foto -> max = $this->resize; }
					  $foto ->resize(MEDIA_DIR.'/'.$typ2.'/'.$dir.'/big/'.$fotoFile, MEDIA_DIR.'/'.$typ2.'/'.$dir.'/big/'.$fotoFile);
				  }
                                  if($this->description != "")
                                  {
                                    $foto->description(MEDIA_DIR.'/'.$typ2.'/'.$dir.'/big/'.$fotoFile, $this->description);
                                  }
                                  $foto ->thumbinal(MEDIA_DIR.'/'.$typ2.'/'.$dir.'/big/'.$fotoFile, MEDIA_DIR.'/'.$typ2.'/'.$dir.'/'.$fotoFile);
				  $this->resize = null;
			  }
			  else
			  {
				  PandaFs::Remove($plik, MEDIA_DIR.'/'.$typ2.'/'.$dir.'/'.basename($plik));
			  }
			}
		}
	}

	function delDir($dir)
	{
		//PandaFS::showfiles(MEDIA_DIR.'/'. $dir);
	}

	function rotateleft($file)
	{

	    $this->_clean($file);
	    $info = $this->_infoFromFile($file);


	$imagick = new Imagick();
$imagick->readImage(dirname($info['fullpath']).'/'.basename($info['fullpath']));
$imagick->rotateImage(new ImagickPixel(), -90);
$imagick->writeImage(dirname($info['fullpath']).'/'.basename($info['fullpath']));
$imagick->clear();
$imagick->destroy(); 

	$imagick = new Imagick();
$imagick->readImage(dirname($info['fullpath']).'/big/'.basename($info['fullpath']));
$imagick->rotateImage(new ImagickPixel(), -90);
$imagick->writeImage(dirname($info['fullpath']).'/big'.basename($info['fullpath']));
$imagick->clear();
$imagick->destroy(); 


	}


	function del($file)
	{

		$this->_clean($file);
		$info = $this->_infoFromFile($file);

      
            

		if($info['type'] == 'image')
		{
			@unlink(dirname($info['fullpath']).'/'.basename($info['fullpath']));
			@unlink(dirname($info['fullpath']).'/big/'.basename($info['fullpath']));
			if($info['id'] != "0" AND $info['id'] != "")
			{
				$this->db->query("DELETE FROM ".$this->tableImage." WHERE id='".$info['id']."'");
			}
		}
		if($info['type'] == 'video')
		{
			unlink($info['fullpath']);
			if($info['id'] != "0" AND $info['id'] != "")
			{
				$this->db->query("DELETE FROM ".$this->tableVideo." WHERE id='".$info['id']."'");
			}
		}
		if($info['type'] == 'audio')
		{
			unlink($info['fullpath']);
			if($info['id'] != "0" AND $info['id'] != "")
			{
				$this->db->query("DELETE FROM ".$this->tableAudio." WHERE id='".$info['id']."'");
			}
		}

	}

	function _fileType($plik)
	{
		$koncowka = pathinfo($plik);
		//echo $koncowka['extension'];
		switch(strtolower($koncowka['extension']))
		{
			case 'png'   : $typ2 = 'image'; break;
			case 'jpg'   : $typ2 = 'image'; break;
			case 'jpeg'  : $typ2 = 'image'; break;
			case 'gif'   : $typ2 = 'image'; break;
			case 'tiff'  : $typ2 = 'image'; break;
			case 'bmp'   : $typ2 = 'image'; break;

			case 'flv'  : $typ2 = 'video'; break;
			case 'avi'  : $typ2 = 'video'; break;
			case 'mpeg' : $typ2 = 'video'; break;
			case 'mpg'  : $typ2 = 'video'; break;

			case 'mp3'  : $typ2 = 'audio'; break ;
			case 'wma'  : $typ2 = 'audio'; break ;

			case 'doc' : $typ2 = 'document'; break;
			case 'pdf' : $typ2 = 'document'; break;
			case 'odt' : $typ2 = 'document'; break;
			case 'ppt' : $typ2 = 'document'; break;
      
		        case 'zip' : $typ2 = 'compressed'; break;
		        case 'tar' : $typ2 = 'compressed'; break;
                        case 'bz2' : $typ2 = 'compressed'; break;
			    

		      
		}
		return $typ2;
	}

	function info($file)
	{
		$this->_clean($file);
		$info = $this->_infoFromFile($file);
		//print_r($info);
		//echo $file;
		if($info['type'] == 'video') { $table = $this->tableVideo; } else { $table = $this->tableImage; }

		$row = $this->db->get($table, "*",['dir'=>$info['dir'], 'file'=>$info['file']]);
               // echo "SELECT * FROM ".$table." WHERE dir='".$info['dir']."' AND file = '".$info['file']."'";
		//echo $this->db->lastErrNo;
		if($this->db->lastErrNo == -18) { $this->_createDB(); }
		if($row != "")
		{
			$ret = $row;
			$ret['type'] = $info['type'];
			$ret['fullpath'] = MEDIA_DIR.'/'.$ret['type'].'/'.$ret['dir'].'/'.$ret['file'];
		}
		else
		{
                        //$row = $this->db->selectOneBySQL("SELECT name FROM fotografie WHERE id='".substr(strrchr($info['dir'], "/"), 1)."'");
                        $row = $this->db->get("fotografie", "name",['id'=>substr(strrchr($info['dir'], "/"), 1)]);
                        
                        $ret['name'] = $row;
			if($info['type'] != 'image') { $ret['name'] = $info['file']; }
			$ret['file'] = $info['file'];
			$ret['type'] = $info['type'];
			$ret['dir']  = $info['dir'];
			$ret['size'] = PandaFS::filesize(MEDIA_DIR.'/'.$ret['type'].'/'.$ret['dir'].'/'.$ret['file']);
			
		}
		$tmp = getimagesize(MEDIA_DIR.'/'.$ret['type'].'/'.$ret['dir'].'/'.$ret['file']);

		$ret['width'] = $tmp[0];
		$ret['height'] = $tmp[1];
		
		return $ret;

	}

	function update($data)
	{
		//$this->_clean($file);
	//	$info = $this->_infoFromFile($file);
		if($data['type'] == 'video') { $table = $this->tableVideo; } else { $table = $this->tableImage; }
		unset($data['type'],$data['fullpath']);
		//if($data['id'] != "")
		$this->db->insert($table, $data);
	}


	function _clean(&$data)
	{
		$data = str_replace(MEDIA_DIR,'',$data);
		$data =  str_replace('//','/',$data);
		if(substr($data,0,1) == '/') { $data = substr($data,1); }
		if(substr($data,-1) == '/') { $data = substr($data,0,-1); }
		return $data;
	}

	function _infoFromFile($file)
	{
		$ex = explode('/',$file);
		$ret['type'] = $ex[0];            unset($ex[0]);
		$ret['file'] = end($ex); unset($ex[key($ex)]);
		$ret['dir']  = implode('/',$ex);
		$ret['fullpath'] = MEDIA_DIR.'/'.$ret['type'].'/'.$ret['dir'].'/'.$ret['file'];
		return $ret;
	}


	function _createDB()
	{

		$this->db->query('CREATE TABLE IF NOT EXISTS `'.$this->tableVideo.'` (
  `id` int(11) NOT NULL auto_increment ,
  `dir` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;');

$this->db->query('CREATE TABLE IF NOT EXISTS `'.$this->tableImage.'` (
  `id` int(11) NOT NULL auto_increment,
  `dir` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;');

$this->db->query('CREATE TABLE IF NOT EXISTS `'.$this->tableAudio.'` (
  `id` int(11) NOT NULL auto_increment,
  `dir` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;');



	}


}