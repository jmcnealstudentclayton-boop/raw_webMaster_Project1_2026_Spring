<?php
try {
    #connects to database
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=moviedb;charset=utf8", "root", "");
    #throw error if there is a database error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>