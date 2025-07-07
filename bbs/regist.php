<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . 'Posts.php';

$name = trim($_POST['name'] ?? '');
$comment = trim($_POST['comment'] ?? '');

$post = new Posts([
  'name' => $name,
  'comment' => $comment
]);

if($post->save($pdo)){
  header('Location: index.php');
  exit;
}else{
  echo '保存に失敗しました。<a href="index.php">戻る</a>';
}