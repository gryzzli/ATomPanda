<?php



class PandaSQLTable
{

	function prepareTable($table, $def)
	{
		$sql = 'CREATE TABLE '.$table.' (';
		foreach($def as $key=>$val)
		{
			if($this->type2sql($val['type']))
			{
				$sql .= "\n". $key.' ';
				$sql .= $this->type2sql($val['type']).', ';
			}
		}
		$sql = substr($sql,0,-2);
		$sql .= ') CHARACTER SET utf8';
		echo '<pre>'. $sql.'</pre>';
		return $sql;
	}

	function type2Sql($type)
	{

		switch($type)
		{
			case "text":       return "varchar(255)";
			case "textarea":   return "text";
			case "author":     return "varchar(255)";
			case "date":       return "date";
			case "timestamp":       return "timestamp";
			case "id_user":    return "int(11)";
			case "sessid":     return "varchar(255) NOT NULL default '0'";
			case "id":         return "int(11) PRIMARY KEY NOT NULL auto_increment";
			case "updated_at": return "timestamp NOT NULL default '0000-00-00 00:00:00'";
			case "created_at": return "timestamp NOT NULL ";
			case "auth":       return "tinyint(1) NOT NULL default '0'";
			case "mail":       return "varchar(255)";
			case "email":      return "varchar(255)";
			case "www":        return "varchar(255)";
			case "skype":      return "varchar(255)";
			case "googlearea":      return "varchar(255)";
			case "gg":         return "int(11)";
			case "icq":        return "int(11)";
			case "int":        return "int(11)";
			case "float":        return "float";
			case "double":        return "double";
			default: return 0;

		}
		return 0;
	}

	function type2Form($type)
	{

		switch($type)
		{
			case "text":       return "text";
			case "textarea":   return "textarea";
			case "author":     return "text";
			case "date":       return "date";
			case "timestamp":       return "date";
			case "id_user":    return "int";
			case "sessid":     return "text";
			case "id":         return "int";
			case "updated_at": return "date";
			case "created_at": return "date";
			case "auth":       return "text";
			case "www":        return "text";
			case "mail":       return "text";
			case "email":      return "text";
			case "skype":      return "text";
			case "gg":         return "int";
			case "icq":        return "int";
			case "int":	   return "int";
			case "float":	   return "int";
			case "float":	   return "int";
			case "googlearea":      return "googlearea";
		}
		return 0;

	}

	function isVisible($type)
	{
		switch($type)
		{
			case "text":       return 1;
			case "textarea":   return 1;
			case "author":     return 1;
			case "date":       return 1;
			case "id_user":    return 0;
			case "sessid":     return 0;
			case "id":         return 0;
			case "updated_at": return 0;
			case "created_at": return 0;
			case "auth":       return 0;
			case "foto":       return 0;

		}
		return 1;


	}


}