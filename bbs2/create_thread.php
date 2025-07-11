<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>新規スレッド作成</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="container my-5" style="max-width: 600px;">
  <h1 class="mb-4">スレッド作成</h1>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <p class="mb-0"><?= htmlspecialchars($error) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form action="store_thread.php" method="post">
    <div class="mb-3">
      <label class="form-label">スレッドタイトル</label>
      <input type="text" name="title" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">作成する</button>
    <a href="index.php" class="btn btn-secondary ms-2">戻る</a>
  </form>
</body>

</html>