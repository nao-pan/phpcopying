
<?php
require 'db.php';

$stmt = $pdo->query("select * from memos ORDER BY created_at DESC");
$memos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- index.php -->
 <!DOCTYPE <!DOCTYPE html>
 <html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>PHPメモ帳</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- JavaScript（モーダル動作用） -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <h1>メモ帳アプリ</h1>
    <a href='create.php'>+ 新規メモ作成</a>
    <a href='memocsv.php'>+ 別バージョン(csv)</a>
    <a href='memotxt.php'>+ 別バージョン(txt)</a>
  <hr>
  <?php foreach ($memos as $memo): ?>
    <div>
      <p><?= nl2br(htmlspecialchars($memo['content']))?></p>
      <small>作成日：<?= $memo['created_at']?></small><br>
      <a href="edit.php?id=<?= $memo['id']?>">編集</a>
  <!-- 削除ボタン(data-id属性でID保持) -->
      <button type="button"
              class="btn btn-sm btn-outline-danger"
              data-bs-toggle="modal"
              data-bs-target="#daleteModel"
              data-id="<?= $memo['id']?>">削除
      </button>
    </div>
    <hr>
  <?php endforeach; ?>
  </body>
 </html>