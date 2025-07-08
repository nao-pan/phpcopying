<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/classes/Posts.php';

$posts = Posts::all($pdo);
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
    <?php if (count($posts) === 0): ?>
      <p>投稿はまだありません。</p>
    <?php else: ?>
      <?php foreach ($posts as $post): ?>
        <div class="border rounded p-3 mb-3">
          <h5><?= htmlspecialchars($post->name) ?></h5>
          <p><?= nl2br(htmlspecialchars($post->comment)) ?></p>
          <small class="text-muted">投稿日：<?= $post->created_at ?></small>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <hr>
  <form action="regist.php" method="post" class="mb-4">
    <div class="mb-3">
      <label for="name" class="form-label">名前</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="comment" class="form-label">コメント</label>
      <textarea name="comment" id="comment" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">投稿する</button>
  </form>
</body>

</html>