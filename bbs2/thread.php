<?php
session_start();
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/classes/Threads.php';
require_once __DIR__ . '/classes/ThreadPosts.php';

$threadId = (int)($_GET['id'] ?? 0);

$threads = new Threads($pdo);
$thread = $threads->findById($threadId);

if (!$thread) {
  echo 'スレッドが見つかりません。';
  exit;
}

$posts = (new ThreadPosts($pdo))->getByThreadId($threadId);
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($thread['title']) ?> - スレッド</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container my-5" style="max-width: 800px;">
  <h1><?= htmlspecialchars($thread['title']) ?></h1>

  <?php foreach ($posts as $index => $post): ?>
    <div class="border rounded p-3 mb-3">
      <div><strong><?= htmlspecialchars($post['name'] ?: '名無しさん') ?></strong> <small class="text-muted">#<?= $index + 1 ?> 投稿日：<?= $post['created_at'] ?></small></div>
      <p><?= nl2br(htmlspecialchars($post['body'])) ?></p>
    </div>
  <?php endforeach; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <p class="mb-0"><?= htmlspecialchars($error) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <hr>
  <h5>レスを投稿する</h5>
  <form action="store_post.php" method="post">
    <input type="hidden" name="thread_id" value="<?= $threadId ?>">
    <div class="mb-3">
      <label class="form-label">名前（省略可）</label>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">本文</label>
      <textarea name="body" class="form-control" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">投稿</button>
    <a href="index.php" class="btn btn-secondary ms-2">スレッド一覧へ戻る</a>
  </form>
</body>
</html>
