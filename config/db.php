<?php 
$username = 'root';
$pwd = 'root';
$dbname = 'auth';
$dns = "mysql:host=localhost; dbname=$dbname;charset=utf8";


try {
    $conn = new PDO($dns, $username, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die (json_encode(['message' => $e->getMessage()]));
}                   