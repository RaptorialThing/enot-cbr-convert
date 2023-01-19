<?php

namespace App;

class Database
{
    static protected $db;

    protected function __construct(\PDO $db)
    {
        //
    }

    static public function getConn()
    {
        if (is_null(self::$db)) {
            
            try {
            include_once dirname(__FILE__).'/../config/database.php';
            $db = new \PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset='.CHARSET, USERNAME, PASSWORD);
            self::$db = $db; 
            } catch (PDOException $e) {
               return  "Connection failed: " . $e->getMessage()."\n";
            }
        }
        
        return self::$db;
    }
}
