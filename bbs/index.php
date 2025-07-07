<?php
require_once __DIR__ . '/../db.php';

$stmt = $pdo->query("select * from posts order by created_at desc");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>掲示板アプリ</title>
</head>
<body>
  <div class="container mt-4">
    <h1 class="mb-4">掲示板</h1>

    <a href="post.php" class="btn btn-primary mb-3">＋新規投稿</a>

    <?php if(count($posts) === 0): ?>
      <p>投稿はまだありません。</p>
    <?php else: ?>
      <?php foreach($posts as $post): ?>
        <div class="border rounded p-3 mb-3">
          <h5><?= htmlspecialchars($post['name'])?></h5>
          <p><?= nl2br(htmlspecialchars($post['comment']))?></p>
          <small class="text-muted">投稿日：<?= $post['created_at']?></small>
        </div>
      <?endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>