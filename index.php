<?php
$filename = 'memos.txt';

if($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST['memo'])){
  $memo = trim($_POST['memo']);
  $datetime = (date('Y-m-d H:i:s'));
  $line ="[$datetime] $memo";
  file_put_contents($filename, $line . PHP_EOL, FILE_APPEND);
}
?>

<!-- index.php -->
 <!DOCTYPE <!DOCTYPE html>
 <html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>PHPメモ帳</title>
    <link rel="stylesheet" href="">
  </head>
  <body>
    <h1>メモ帳アプリ</h1>
    <form method="POST" action="index.php">
      <textarea name="memo" rows="5" cols="40" placeholder="ここにメモを記入してください"></textarea><br>
      <button type="submit">保存</button>
    </form>

    <?php
    $memos = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES) : [];
    ?>
    <ul>
      <?php foreach ($memos as $line): ?>
        <li><?= htmlspecialchars($line, ENT_QUOTES, 'UTF-8') ?></li>
      <?php endforeach; ?>
    </ul>
  </body>
 </html>