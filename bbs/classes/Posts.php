<?php

class Posts
{
  private PDO $pdo;
  public int $id = 0;
  public string $name = '';
  public string $comment = '';
  public string $created_at = '';

  public function __construct(PDO $pdo,array $data = [])
  {
    $this->pdo = $pdo;
    if(!empty($data)){
      $this->id = $data['id'] ?? 0;
      $this->name = $data['name'] ?? '';
      $this->comment = $data['comment'] ?? '';
      $this->created_at = $data['created_at'] ?? '';
    }
  }

  //全件取得
  public function getAll(): array
  {
    $stmt = $this->pdo->query("select * from posts order by created_at desc");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_map(fn($row) => new self($this->pdo,$row), $results);
  }

  //投稿の保存メソッド
  public function save(): bool
  {
    $stmt = $this->pdo->prepare("insert into posts(name,comment) values(:name,:comment)");
    return $stmt->execute([
      'name' => $this->name,
      'comment' => $this->comment
    ]);
  }
}
