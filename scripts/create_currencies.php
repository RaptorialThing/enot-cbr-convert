<?php

try {
    require dirname(__FILE__).'/../config/database.php';
    $pdo = new \PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset='.CHARSET, USERNAME, PASSWORD);
    $sql = "
            CREATE TABLE  IF NOT EXISTS `currencies` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `cbr_id` varchar(30) NOT NULL,
              `num_code` int(3) unsigned NOT NULL,
              `char_code` varchar(3) NOT NULL,
              `nominal` int(10) unsigned NOT NULL,
              `name` varchar(120) NOT NULL,
              `value` varchar(120) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=".CHARSET.";
    ";
    $pdo->query($sql);
    echo "Table currencies created \n"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage()."\n";
}
