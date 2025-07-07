<?php
require_once __DIR__ . '/../db.php';
session_start();
//フォームの値を受け取る
$content = trim($_POST['content'] ?? '');

//空チェック
if ($content === '') {
  echo 'メモの内容が空です。<a href="create.php>戻る</a>"';
  exit;
}

//データベースに保存
$sql = "insert into memos (content) values (:content)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->execute();

//セッションに成功フラグを立てる
$_SESSION['create_success'] = true;

//一覧ページにリダイレクト
header('Location: index.php');
exit;
