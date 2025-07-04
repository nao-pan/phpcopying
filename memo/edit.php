<?php
require 'db.php';

//IDを取得　?? ←NULL合体演算子という　nullなら0にという意味
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("select * from ,memos where id = :id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$stmt->execute();

//fetchは持ってくる、とってくるという意味の単語
$memo = $stmt->fetch(PDO::FETCH_ASSOC); //FETCH_ASSOCは連想配列で取り出すという意味

if(!$memo){
  echo "メモが見つかりません。<a href='index.php'>戻る</a>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メモ編集</title>
</head>
<body>
  <h1>メモ編集</h1>
  <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?=$memo['id']?>">
    <textarea name="content" rows="8" cols="40"><?= htmlspecialchars($memo['content'])?></textarea><br><br>
    <button type="submit">更新する</button>
  </form>
  <p><a href="index.php">メモ一覧に戻る</a></p>
</body>
</html>

