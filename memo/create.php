<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Bundle JS（JS + Popper） -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <title>メモ作成</title>
</head>

<body>
  <div class="container mt-5">
    <h2 class="mb-4">新規メモ作成</h2>
    <form action="store.php" method="post">
      <div class="mb-3">
        <label for="content" class="form-label">メモ内容</label>
        <textarea name="content" rows="8" cols="40" class="form-control" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">保存</button>
      <a href="index.php" class="btn btn-secondary">メモ一覧に戻る</a>
    </form>

  </div>
</body>

</html>