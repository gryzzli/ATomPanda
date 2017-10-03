<?php

class PandaDatabase
{

	var $db=null;

	function __construct($config=null)
	{
		$this->config = $config;
	}

	function connect()
	{

		$this->db =& MDB2::factory($this->config['dsn'], $this->config['options']);
		#echo $this->config['dsn'];
		if (PEAR::isError($this->db)) { die($this->db->getMessage()); }
	

	}

	function selectOneBySql($sql)
	{
		$res =& $this->db->query($sql);
		if (PEAR::isError($res)) {  Panda::Error($res->getMessage()); $this->lastErrNo = $res->getCode(); Panda::debug($res->getDebugInfo()); }
		else
		{
			return $res->fetchrow(MDB2_FETCHMODE_ASSOC);
		}
	}


	function selectAllBySql($sql)
	{
	    
		$res =& $this->db->query($sql);
		if (PEAR::isError($res)) {  Panda::Error($res->getMessage()); $this->lastErrNo = $res->getCode(); Panda::debug($res->getDebugInfo()); }
		else
		{
		    return $res->fetchAll(MDB2_FETCHMODE_ASSOC);
		}
	}

	function setOrder($order)
	{
		$this->order = 'ORDER BY '.$order;
	}

	function selectAll($table)
	{
	
		
		if($this->order != "" AND !Panda::eregi("ORDER",$this->order)) { $this->order = ' ORDER BY '.$this->order; }
		$res =& $this->db->query('SELECT * FROM '.$table .' '. $this->where.' '.$this->order .' '.$this->limit);

	
		if (PEAR::isError($res)) { Panda::Error($res->getMessage().' ('.$table.')'); $this->lastErrNo = $res->getCode(); Panda::debug($res->getDebugInfo()); }
		else
		{
			return $res->fetchAll(MDB2_FETCHMODE_ASSOC);
		}
	}

	function selectAllCount($table)
	{

		$res =& $this->db->query('SELECT COUNT(*) as count  FROM '.$table .' '. $this->where.'  LIMIT 1');
		if (PEAR::isError($res)) { Panda::Error($res->getMessage().' ('.$table.')'); $this->lastErrNo = $res->getCode(); Panda::debug($res->getDebugInfo()); }
		else
		{
			 $ret = $res->fetchrow(MDB2_FETCHMODE_ASSOC);
			 return $ret['count'];
		}
		return 0;
	}

	function selectOneById($table,$id)
	{
		$res =& $this->db->query('SELECT * FROM '.$table.' WHERE id='.$id);
		if (PEAR::isError($res)) { Panda::debug($res->getDebugInfo()); $this->lastErrNo = $res->getCode(); return 0;  }
		return $res->fetchrow(MDB2_FETCHMODE_ASSOC);
	}

	function selectOneByIdCount($table,$id)
	{
		$res =& $this->db->query('SELECT COUNT(*) as count FROM '.$table.' WHERE id='.$id.' LIMIT 1');
		if (PEAR::isError($res)) { Panda::debug($res->getDebugInfo()); return 0;  }
		$row =  $res->fetchrow(MDB2_FETCHMODE_ASSOC);
		return $row['count'];
	}


	function lastInsertId()
	{
		return mysql_insert_id($this->db->connection);

	}

	function insertFromArray($table, $data)
	{
		;
		if(is_array($data))
		{
                        foreach($data As $key => $val)
                        {
                                $kolumny  .= "`".trim($key)."`, ";
				//$wartosci2 .= '?, ';
				$wartosci2 .= '\''.str_replace('\'','\\\'',$val).'\', ';
                                $wartosci[] = $val;
                        }

                        $kolumny  = substr($kolumny, 0, -2);
                        $wartosci2 = substr($wartosci2,0, -2);

                        $sql = "REPLACE INTO ".$table." (".$kolumny.") VALUES (".$wartosci2.")";
			//echo $sql;
			$e =& $this->db->query($sql);
			//$prep = $this->db->prepare($sql);
			//$exe  = $this->db->execute($prep, $wartosci);
			//echo $sql;

			if (PEAR::isError($e)) { Panda::Debug($e->getDebugInfo());  $this->lastErrNo = $e->getCode();  Panda::Error($e->getMessage().' ('.$table.')'); return 0; }
			return 1;

		}
	}

	function delete($table, $id)
	{
		if($id != "")
		{
			$e =& $this->db->query("DELETE FROM $table WHERE id=$id");
		}
	}


	function sql($sql)
	{
			$e =& $this->db->query($sql);
			if (PEAR::isError($e)) { Panda::Error($e->getMessage().' ('.$table.')'); $this->lastErrNo = $e->getCode(); Panda::debug($e->getDebugInfo()); }
	}



}