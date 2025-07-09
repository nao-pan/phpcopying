<?php
session_start();
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/classes/Threads.php';

$threads =  new Threads($pdo);
$allThreads = $threads->getAll();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>スレッド一覧</title>
</head>

<body>
  <div class="container my-5">
    <h1>スレッド一覧</h1>

    <ul class="list-group">
      <?php foreach ($allThreads as $thread): ?>
        <li class="list-group-item">
          <a href="thread.php?id=<?= $thread['id'] ?>">
            <?= htmlspecialchars($thread['title']) ?>
          </a>
          <br>
          <small>作成日時：<?= $thread['created_at'] ?></small>
      </li>
      <?php endforeach; ?>
    </ur>

    <a href="create_thread.php">新規スレッド作成</a>
</body>

</html>