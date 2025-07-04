<?php
$filename = 'memos.csv';

//POST情報をcsv書き込み
if($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST['memo'])){
  $memo = trim($_POST['memo']);
  $datetime = (date('Y-m-d H:i:s'));
  $fp = fopen($filename, 'a');
  fputcsv($fp, [$memo, $datetime]);
  fclose($fp);
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
    $memos = [];
    //csv情報を読み込み
    if(file_exists($filename)){
      $fp = fopen($filename, 'r');
      while(($data = fgetcsv($fp)) !== false){
        $memos[] = $data;
      }
      fclose($fp);
    };
    ?>
    <ul>
      <?php foreach ($memos as $entry): ?>
        <li>
          <?= htmlspecialchars($entry[1], ENT_QUOTES, 'UTF-8') ?>
          :
          <?= htmlspecialchars($entry[0], ENT_QUOTES, 'UTF-8') ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </body>
 </html>