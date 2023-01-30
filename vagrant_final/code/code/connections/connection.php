<?php
try {
    $usr = "admin";
    $pwd = "Aa123456?";
    $pdo = new PDO('mysql:host=192.168.56.2;dbname=gexpenses;', $usr, $pwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $ex) {
    echo "Error de PDO " . $ex;
}