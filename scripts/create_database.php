<?php
try {
    require dirname(__FILE__).'/../config/database.php';
    $pdo = new \PDO('mysql:host='.HOST.';charset='.CHARSET, USERNAME, PASSWORD);
    $sql = "CREATE DATABASE IF NOT EXISTS " . DBNAME . ";";
    $pdo->query($sql);
    echo "Database ".DBNAME." created \n"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage()."\n";
}
