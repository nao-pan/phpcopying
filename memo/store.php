<?php
require 'db.php';

//フォームの値を受け取る
$content = trim($_POST['content'] ?? '');

//空チェック
if($content === ''){
  echo 'メモの内容が空です。<a href="create.php>戻る</a>"';
  exit;
}

//データベースに保存
$sql = "insert into memos (content) values (:content)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':content',$content,PDO::PARAM_STR);
$stmt->execute();

//一覧ページにリダイレクト
header('Location: index.php');
exit;

?>