<?php
define("DB_HOST", "172.31.22.43");
define("DB_NAME", "Oluwafunmibi200631960");
define("DB_USER", "Oluwafunmibi200631960");
define("DB_PASS", "-Sq98vo2cv");
try{
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}
?>