<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メモ作成</title>
</head>
<body>
  <h1>新規メモ作成</h1>
  <form action="store.php" method="post">
    <textarea name="content" rows="8" cols="40" placeholder="ここにメモを記入してください"></textarea><br><br>
    <button type="submit">保存</button>
  </form>
  <a href="index.php">メモ一覧に戻る</a>
</body>
</html>