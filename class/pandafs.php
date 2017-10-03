<?php
class PandaFS
{
	static function read($plik)
	{
		if(!file_exists($plik)) { return 0; }
		$nazwa_pliku = $plik;
		$uchwyt = fopen($nazwa_pliku, "r");
		$tresc = fread($uchwyt, filesize($nazwa_pliku));
		fclose($uchwyt);
		return $tresc;

	}

	static function save($plik, $dane, $tryb="w")
	{
		PandaFs::mkdir($plik);

		$dane = stripslashes($dane);
		if(Panda::eregi('\*\.*.',$plik))
		{
			$koncowka = pathinfo($plik);
			$koncowka = $koncowka['extension'];
			$plik = dirname($plik) .'/'.time().'.'.$koncowka;
		}

		$pl   = fopen($plik,$tryb);
		fputs($pl,$dane);
		fclose($pl);
	}

	static function copy($zrodlo, $cel)
	{
		PandaFs::mkdir($cel);

		if(!Panda::eregi('\.',substr($cel,-5)))
		{
			echo substr($cel,-5);
			$koncowka = pathinfo($zrodlo);
			$koncowka = $koncowka['extension'];
			$cel = $cel .'/'.time().'.'.$koncowka;
		}
		$i=0;
		while(file_exists($cel)) { $cel = dirname($cel).'/'.$i.'_'.basename($cel); $i++; }
		copy($zrodlo, $cel);
		return basename($cel);
	}

	static function copyFromNetToTmp($url)
	{

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

	static function remove($zrodlo, $cel)
	{
		$ret = PandaFs::copy($zrodlo, $cel);
		unlink($zrodlo);
		return $ret;
	}


	static function mkdir($dir)
	{
            
                if(!is_dir($dir))
                {
		if(Panda::eregi('\.',substr($dir,-5))) { $dir = dirname($dir); }

		$dir = explode("/",$dir);
		$kat = '';
		foreach($dir as $val)
		{
                        $kat .= $val.'/';
                        if(stristr($kat, PROJECT_DIR))
                        {
                            if(!is_dir($kat)) { mkdir($kat); }
                        }
		}
                }


	}

	static function ShowFiles($dir,$limit=null)
	{
		if(is_dir($dir))
		{
			$d = dir($dir);
			$i=0;
			while (false !== ($entry = $d->read()))
			{
 		  		if(is_file($dir.'/'.$entry))
				{
					$ret[] = $entry;
					if($limit != null)
					{
						$i++;
						if($i >= $limit) { break; }

					}

				}
			}
			$d->close();
		}
		if(is_array($ret)) {  return $ret; }
		else return 0;
	}
	static function showDirs($dir,&$ret='')
	{
		if(is_dir($dir))
		{
			$d = dir($dir);
			while (false !== ($entry = $d->read()))
			{
 		  		if(is_dir($dir.'/'.$entry) && $entry != "." && $entry != "..")
				{
					$ret[] = $dir.'/'.$entry;
					pandaFS::showDirs($dir.'/'.$entry, $ret);
				}
			}
			$d->close();
		}
		if(is_array($ret)) return $ret;
		else return 0;
	}

	static function showDirs2($dir)
	{
		if(is_dir($dir))
		{
			$d = dir($dir);
			while (false !== ($entry = $d->read()))
			{
 		  		if(is_dir($dir.'/'.$entry) && $entry != "." && $entry != "..")
				{
					$ret[] = $dir.'/'.$entry;
					//pandaFS::showDirs($dir.'/'.$entry, $ret);
				}
			}
			$d->close();
		}
		if(is_array($ret))  return $ret; 
		else return 0;
	}


	static function SearchFiles($plik, $dir)
	{
		static $ret;
		if(is_dir($dir))
		{
			$d = dir($dir);
			while (false !== ($entry = $d->read()))
			{
				if($entry != ".." && $entry != ".")
				{
 		  			if(is_file($dir.'/'.$entry) && Panda::eregi($plik,$entry))
					{
						$ret[$plik][] = $dir.'/'.$entry;
					}
					elseif(is_dir($dir.'/'.$entry))
					{
						PandaFs::SearchFiles($plik, $dir.'/'.$entry);
					}
				}
			}
			$d->close();
		}
		if(is_array($ret[$plik])) return $ret[$plik];
		else return 0;
	}

	static function RmDir($dir)
	{
		if(is_dir($dir))
		{
			$d = dir($dir);
			while (false !== ($entry = $d->read()))
			{
				if($entry != ".." && $entry != ".")
				{
 		  		if(is_file($dir.'/'.$entry))    { unlink($dir.'/'.$entry);    }
				elseif(is_dir($dir.'/'.$entry)) { PandaFs::RmDir($dir.'/'.$entry); }
				}
		}
			$d->close();
			rmdir($dir);
		}

	}

	static function size($plik)
	{
		$ret = filesize($plik);
		if($ret >= 1000000) { $ret = round($ret/(1024*1024),2).' MB'; }
		if($ret >= 1000)    { $ret = round($ret/1024).' KB'; }
		return $ret;
	}

	static function RemoveAllFiles($dir)
	{
		$pliki = PandaFs::showFiles($dir);
		if(is_array($pliki))
		{
			foreach($pliki as $val)
			{
				unlink($dir.'/'.$val);
			}
		}
	}

	static function filesize($file)
	{
		$filesize = round(filesize($file)/1024);
		if($filesize > 1000) { $filesize = round($filesize / 1024,2).' MB'; }
		else { $filesize = $filesize.' KB'; }
		return  $filesize;
	}

}
?>
