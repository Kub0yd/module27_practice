<?php
// header("Location: ./index.php");
    $host = 'localhost';
    $db = 'u2038502_default';
    // $user = "u2038502_default";
    // $password = "cdrtyhbvfg7";
    $user = "root";
    $password = "";
    $db = new PDO("mysql:host=$host;dbname=$db", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    
?>