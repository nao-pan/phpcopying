<?php
require_once __DIR__ . '/../db.php';

//IDを取得　?? ←NULL合体演算子という　nullなら0にという意味
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("select * from memos where id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

//fetchは持ってくる、とってくるという意味の単語
$memo = $stmt->fetch(PDO::FETCH_ASSOC); //FETCH_ASSOCは連想配列で取り出すという意味

if (!$memo) {
  echo "メモが見つかりません。<a href='index.php'>戻る</a>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS（JS + Popper） -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <title>メモ編集</title>
</head>

<body>
  <div class="container mt-5">
  <h2 class="mb-4">メモ編集</h2>
  <form action="update.php" method="post">
    <div class="mb-3">
    <input type="hidden" name="id" value="<?= $memo['id'] ?>">
    <label for="content" class="form-label">メモ内容</label>
    <textarea name="content" rows="8" class="form-control" required><?= htmlspecialchars($memo['content']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">更新する</button>
    <a href="index.php" class="btn btn-secondary">メモ一覧に戻る</a>
  </form>
  </div>
</body>

</html>