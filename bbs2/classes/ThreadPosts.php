<?php

class ThreadPosts
{
  public $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  //ID選択されたスレッドの投稿取得
  public function getByThreadId(int $threadId): array
  {
    $stmt = $this->pdo->prepare("select * from thread_posts where thread_id = :id order by created_at asc");
    $stmt->bindvalue(':id', $threadId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  //投稿の保存メソッド
  public function save(int $threadId, string $name, string $body): bool
  {
    $stmt = $this->pdo->prepare("insert into thread_posts(thread_id, name, body) values(:thread_id, :name, :body)");
    return $stmt->execute([
      ':thread_id' => $threadId,
      ':name' => $name,
      'body' => $body
    ]);
  }
}
