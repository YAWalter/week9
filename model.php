<?php

abstract class model {
    protected $tableName;
    public function save()
    {
        $tableName = get_called_class();
        $array = get_object_vars($this);
	   
	   $columns = array_flip($array);
	   array_pop($columns);
        $columnString = implode(',', $columns);
        
	   $values = array_slice($array, 1);
	   array_pop($values);
	   $valueString = implode(',', $values);
	   
	   echo htmlTags::preObj($this);
	   
        if ($this->id == '') {
            $sql = $this->insert($tableName, $columnString, $valueString);
        } else {
            $sql = $this->update($tableName, $columnString, $valueString);
        }
        $db = dbConn::getConnection();
        $statement = $db->prepare($sql);
	   echo $sql . htmlTags::lineBreak();
        $statement->execute();
       
        echo 'I just saved record: ' . $this->id;
    }
	
    private function insert($tableName, $columnString, $valueString) {
        $values = explode(',',$valueString);
	   $valStr = '';
	   foreach ($values as $i) {
		   $valStr .= '\'' . $i . '\',';
	   }
	   $valStr = rtrim($valStr, ',');
	   
	   $sql = 'INSERT INTO ' . $tableName . 
			's (' . $columnString . ') VALUES (' . $valStr. ')';
        
	   echo $sql . htmlTags::lineBreak();
	   return $sql;
    }
	
    private function update($tableName, $columnString, $valueString) {
        $array = get_object_vars($this);
	   
	   $columns = array_flip($array);
	   array_pop($columns);
	   
	   $set = '';
	   foreach ($columns as $val=>$field) {
		   $set .= $field . '=\'' . $val . '\',';
	   }
	   
	   $set = rtrim($set, ',');
	   
	   $sql = 'UPDATE ' . $tableName .
			's SET ' . $set .
			' WHERE id=' . $this->id;
	   
        echo $sql . htmlTags::lineBreak();
        echo 'I just updated record ' . $this->id;
	   return $sql;
    }
	
    public function delete() {
	   $tableName = pageBuild::getParam('table');
	   $sql = 'DELETE FROM ' . $tableName . ' WHERE id=' . $this->id;
	   
	   $db = dbConn::getConnection();
        $statement = $db->prepare($sql);
        $statement->execute();
	   
	   echo $sql . htmlTags::lineBreak();
        echo 'I just deleted record ' . $this->id;
    }
}

?>