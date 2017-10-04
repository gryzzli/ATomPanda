<?php

class CounterMod extends PandaModController
{
	function index()
	{

	        $db = getInstance('Medoo\Medoo');
	
		$id = str_replace("//","/",$_SERVER['REQUEST_URI']);

		$row = $db->select("licznik_odwiedzin", ["count", "count2"], ['id'=>$id,'LIMIT'=>1]);

    

		if($row[0]['count'] != "")
		{

		  if(!$_SESSION['counter'][$id])
		  {
		    $db->query("UPDATE licznik_odwiedzin set count=count+1 WHERE id='".$id."'");
		   $_SESSION['counter'][$id] = 1;   

		  }
		  $db->query("UPDATE licznik_odwiedzin set count2=count2+1 WHERE id='".$id."'");
		}
		else
		{
		  $db->query("INSERT INTO licznik_odwiedzin (id) VALUES('".$id."')");
		}

		
		//print_r($db->selectOneBySql("SELECT * FROM counter"));
		echo "Tą podstronę odwedziło: ". $row[0]['count'] ." (".$row[0]['count2'].") osób";

	}


}