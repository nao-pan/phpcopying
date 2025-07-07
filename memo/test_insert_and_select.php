<?php
require_once __DIR__ . '/../db.php';

//テスト用メモの追加
$pdo->prepare("insert into memos (content) values (:content)")
  ->execute([':content' => 'テストメモ']);

//最後に追加したIDを取得
$lastId = $pdo->lastInsertId();

//メモを取得して確認
$stmt = $pdo->prepare("select * from memos where id = :id");
$stmt->execute([':id' => $lastId]);
$memo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($memo && $memo['content'] === 'テストメモ') {
  echo "テスト成功！ ID{$lastId}のメモが追加取得できました。\n";
} else {
  echo "テスト失敗";
}
