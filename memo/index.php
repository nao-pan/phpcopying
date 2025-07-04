
<?php
require 'db.php';
session_start();
$stmt = $pdo->query("select * from memos ORDER BY created_at DESC");
$memos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$showToast = false;
if(!empty($_SESSION['delete_success'])){
  $showToast = true;
  unset($_SESSION['delete_success']);
}

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
    <div class="mb-3 d-flex gap-2 flex-wrap">
      <a href="create.php" class="btn btn-success">新規メモ作成</a>
      <a href="memocsv.php" class="btn btn-outline-secondary">別バージョン（CSV）</a>
      <a href="memotxt.php" class="btn btn-outline-secondary">別バージョン（TXT）</a>
    </div>
  <hr>
  <?php foreach ($memos as $memo): ?>
    <div>
      <p><?= nl2br(htmlspecialchars($memo['content']))?></p>
      <small>作成日：<?= $memo['created_at']?></small><br>
      <a href="edit.php?id=<?= $memo['id'] ?>" class="btn btn-outline-primary btn-sm">編集</a>
  <!-- 削除ボタン(data-id属性でID保持) -->
      <button type="button"
              class="btn btn-outline-danger btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#deleteModal"
              data-id="<?= $memo['id']?>">削除
      </button>
    </div>
    <hr>
  <?php endforeach; ?>
  <!-- モーダル本体 -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">削除の確認</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>
      <div class="modal-body">
        このメモを本当に削除しますか？
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-danger" id="modalDeleteBtn">削除する</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
      </div>
    </div>
  </div>
</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="deleteToast" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        ✅ メモを削除しました。
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
  //モーダル連携処理
  const deleteModal = document.getElementById('deleteModal');
  const deleteBtn = document.getElementById('modalDeleteBtn');

  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const memoId = button.getAttribute('data-id');
    deleteBtn.href = `delete.php?id=${memoId}`;
  });

  //削除成功トースト処理
  <?php if ($showToast): ?>
    const deleteToast = document.getElementById('deleteToast');
    const toast = new bootstrap.Toast(deleteToast);
    toast.show();
  <?php endif; ?>
});

</script>


  </body>
 </html>