<?php

try {
    require dirname(__FILE__).'/../config/database.php';
    $pdo = new \PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset='.CHARSET, USERNAME, PASSWORD);
    $sql = "
        CREATE TABLE IF NOT EXISTS`users` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `login` varchar(30) NOT NULL,
    `password` varchar(32) NOT NULL,
    `hash` varchar(32) NOT NULL default '',
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=".CHARSET." AUTO_INCREMENT=1 ;
    ";
    $pdo->query($sql);
    echo "Table users created \n"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage()."\n";
}
