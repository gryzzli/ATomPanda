<?php

class PandaModel
{
    
        var $limit;
    
	function __construct()
	{

		//$this->db = getInstance('PandaDatabase');
                $this->db = getInstance('medoo');
              
		//if($this->table == "") { Panda::Error("Variable \$table is not set"); }
		//$this->db->order = '';
		//$this->db->where = '';
	}

	function add($data)
	{
		if(!isset($data['id']))
                {
                    $ret = $this->db->insert($this->table, $data);
                   
                }
                else
                {
                    $id = $data['id'];
                    unset($data['id']);
                    $this->db->update($this->table,$data,['id'=>$id]);
                   echo $this->db->last_query();
                }
		if($this->db->lastErrNo == -18) { $this -> CreateTableFromDefinition(); $ret = $this->db->insert($this->table, $data); }
		return $ret;
	}

	function del($id)
	{
		$this->db->delete($this->table,['id'=>$id]);
	}

	function update($id, $data)
	{
		return $this->db->update($this->table,$data,['id'=>$id]);

	}
        
        function _where()
        {
            $ret = array();
            if($this->limit != "")
            {
               
                $ret['LIMIT']=$this->limit;
            }
            if($this->order != "")
            {
                $ret["ORDER"]=$this->order;
            }
            if($this->where != "")
            {
           
                $ret = array_merge($ret, $this->where);
            }
          
       
            return $ret;
        }

	function get($id=null)
	{
		if($id == null)
		{
                    
                    
			$ret =  $this->db->select($this->table,"*",$this->_where());
                       //// echo $this->db->last_query();
                       // echo '<pre>';
                       // print_r(debug_print_backtrace());
                       // echo '</pre>';
                       

		}
		else
		{
			$ret =  $this->db->get($this->table, "*",['id'=>$id]);
                        
                  
		}
		if($this->db->lastErrNo == -18) { $this -> CreateTableFromDefinition(); $ret =  $this->db->select($this->table,"*"); }
		return $ret;
	}

	function getCount($id=null)
	{
		if($id == null)
		{
			$ret =  $this->db->count($this->table);

		}
		else
		{
			$ret =  $this->db->count($this->table, ['id'=>$id]);
		}
		if($this->db->lastErrNo == -18) { $this -> CreateTableFromDefinition(); $ret =  $this->db->selectAll($this->table); }
		return $ret;
	}


	// $query2 = 'SELECT COUNT(*) as ile '.strrchr($query,"FORM");
          //              //$query2    = preg_replace("/SELECT (.*) FROM/","SELECT COUNT(*) as ile FROM",$query);
            //            $wszystkie = $this->SelectOne($query2);




	function CreateTableFromDefinition()
	{
		$table = new PandaSQLTable();
		//echo '<pre>';
		//echo $table->prepareTable($this->table, $this->Definition());
		$this->db->sql($table->prepareTable($this->table, $this->Definition()));
	}


}