<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/classes/Posts.php';
require_once __DIR__ . '/classes/Validator.php';

session_start();



$name = trim($_POST['name'] ?? '');
$comment = trim($_POST['comment'] ?? '');

$validator = new Validator();
$validator->validateAll($_POST);
if ($validator->hasErrors()) {
    $_SESSION['errors'] = $validator->getErrors();
    header('Location: index.php');
    exit;
}

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
?>