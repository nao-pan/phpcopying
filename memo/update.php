<?php
require_once __DIR__ . '/../db.php';
session_start();
//フォームの値を受け取る
$id = (int)($_POST['id'] ?? 0);
$content = trim($_POST['content'] ?? '');

//空チェック
if ($id <= 0 || $content === '') {
  echo '不正な入力です。<a href="create.php">戻る</a>';
  exit;
}

//データベースに保存
$sql = "update memos set content = :content where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

//セッションに成功フラグを立てる
$_SESSION['update_success'] = true;

//一覧ページにリダイレクト
header('Location: index.php');
exit;
?>