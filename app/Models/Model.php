<?php

namespace App\Models;
use App\Database;

class Model
{
    static public function all()
    {
        $conn = Database::getConn();
        $stmt = $conn->prepare("SELECT * FROM ".static::$table.";");
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    static public function where($params)
    {

        $conn = Database::getConn();
        
        if (empty($params[array_key_first($params)])) {
            return false;
        } 
 
        $stmt = $conn->prepare( "SELECT * FROM ".static::$table." WHERE ".array_key_first($params)." = :value ;");
        $stmt->bindParam(':value',$params[array_key_first($params)]);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);    

        $res = $stmt->fetchAll();
        return $res;    
    }

    static public function create($params)
    {

        if (in_array(null,$params)) {
            return false;
        }

        $conn = Database::getConn();
        $keys = array_keys($params);
        $bindFields = [];
        foreach ($keys as $value) {
            $bindFields[] = ":".$value;
        }
        $fieldStr = "(" . implode(", ",$keys) . ")";
        $bindFieldStr = "(" . implode(", ",$bindFields) . ")";
        $stmt = $conn->prepare("INSERT INTO ".static::$table." ".$fieldStr." VALUES ".$bindFieldStr.";");
        for ($i=0;$i<count($bindFields);$i++) {
            $stmt->bindParam($bindFields[$i],$params[$keys[$i]]);
        }
        $stmt->execute();       

        $last_id = $conn->lastInsertId();

        if ($last_id) {
            return $last_id;        
        } else {
            return false;
        }
    }

    static public function update($params)
    {
 
        if (in_array(null,$params)) {
            return false;
        }

        $conn = Database::getConn();
        $id = array_shift($params);
        $keys = array_keys($params);
        $updFields = [];
        foreach ($keys as $key) {
            $updFields[$key] = $key."=".":".$key;
        }
        $updFieldStr = implode(", ",$updFields);

        $stmt = $conn->prepare("UPDATE " . static::$table . " SET " . $updFieldStr . " WHERE id=".$id.";");
        foreach ($params as $key=>$value) {
            $stmt->bindParam(":".$key,strval($value));
        }
        $stmt->execute();       

        return $id;   
    }

    static public function insertOrUpdate($params)
    {

      if (in_array(null,$params)) {
            return false;
        }

        $conn = Database::getConn();
        $keys = array_keys($params);
        $bindFields = [];
        $bindDuplicate = [];
        foreach ($keys as $value) {
            $bindFields[] = ":".$value;
            $bindDuplicate[$value] = $value."=".":".$value;
        }
        $fieldStr = "(" . implode(", ",$keys) . ")";
        $bindFieldStr = "(" . implode(", ",$bindFields) . ")";
        $bindDuplicateStr = implode(", ",$bindDuplicate);
        $stmt = $conn->prepare("INSERT INTO ".static::$table." ".$fieldStr." VALUES ".$bindFieldStr." ON DUPLICATE KEY UPDATE ".$bindDuplicateStr.";");
        for ($i=0;$i<count($bindFields);$i++) {
            $stmt->bindParam($bindFields[$i],$params[$keys[$i]]);
        }
        $stmt->execute();       

        return true;

    }

    static public function get($id)
    {
        return static::where([ "id" => $id ]);
    }
}
