<?php
$host ='localhost';
$db = 'php_copying_app';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try{
  $pdo = new PDO($dsn,$user,$pass,[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);
}catch(PDOException $e){
  echo '接続失敗'. $e->getMessage();
  exit;
}

?>