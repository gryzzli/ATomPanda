<?php

class PandaPagination
{
	var $perPage = 10;
	var $allItems = null;

	function __construct()
	{

	}

	function controlSqlLimit()
	{
		if($this->perPage > 0)
		{

			if(is_Array($_POST['Pagination'])) { $site = key($_POST['Pagination']); } else { $site = 0;}

			if($site != "") { $from =  $site * $this->perPage; }
			else { $from = 0; }
			return [$from,$this->perPage];
		}
		return '';

	}

	function prepareData()
	{
		if(is_Array($_POST['Pagination'])) { $site = key($_POST['Pagination']); } else { $site = 0;}

		if($site != "") { $from =  $site * $this->perPage; }
		else { $from = 0; }

		$this->from  = $from;
		$this->to    = $from+$this->perPage-1;
		if($this->to > $this->allItems-1) { $this->to = $this->allItems-1;}
	}

	function drawNaviBar()
	{
		$ret = '<div class="PaginationNaviBar">';
		$ret .='<form action="" method="post">';
		$ret .=' Strona: ';


		if(is_Array($_POST['Pagination'])) { $site = key($_POST['Pagination']); } else { $site = 0;}


		$istart = 0;

		if(($site - 5) >= 5) {  $istart = ($site - 5); }

		$istop = $istart+10;
		if(($istop * $this->perPage) > $this->allItems) { $istop = $this->allItems / $this->perPage; }
		//echo $istop;
		$buttons=0;
		if($this->allItems > 10 AND $site > 10) { $ret .= '<button name="Pagination['.($istart-5).']"> < </button>'; }
		for($i=$istart; $i <= $istop; $i++)
		{
			$buttons++;
			if($site != $i)
			{
				$ret .= '<button name="Pagination['.$i.']">'.$i.'</button>';
			}
			else
			{
				$ret .= '<button name="Pagination['.$i.']"><span style="font-size: 200%">'.$i.'</span></button>';
			}
		}
		if($this->allItems > ($i*$this->perPage)-1)
		{
			$ret .= '<button name="Pagination['.($i+4).']"> > </button>';
		}

		$ret .='</form></div>';
		if($buttons < 2) {  return ''; }
		return $ret;

	}


}