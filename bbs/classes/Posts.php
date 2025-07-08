<?php

class Posts
{
  public int $id;
  public string $name;
  public string $comment;
  public string $created_at;

  public function __construct(array $data)
  {
    $this->id = $data['id'] ?? 0;
    $this->name = $data['name'] ?? '';
    $this->comment = $data['comment'] ?? '';
    $this->created_at = $data['created_at'] ?? '';
  }

  //静的メソッド：全件取得
  public static function all(PDO $pdo): array
  {
    $stmt = $pdo->query("select * from posts order by created_at desc");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_map(fn($row) => new Posts($row), $results);
  }

  //投稿の保存メソッド
  public function save(PDO $pdo): bool
  {
    $stmt = $pdo->prepare("insert into posts(name,comment) values(:name,:comment)");
    return $stmt->execute([
      'name' => $this->name,
      'comment' => $this->comment
    ]);
  }
}
