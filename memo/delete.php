<?php
require 'db.php';
//IDを安全に取得
$id = (int)($_GET['id'] ?? 0);

if($id <= 0){
  echo '不正なIDです。<a href="index.php">戻る</a>';
  exit;
}

$stmt = $pdo->prepare("delete from memos where id = :id");
$stmt->bindValue(':id', $id,PDO::PARAM_INT);
$stmt->execute();

header('Location: index.php');
exit;
?>