<?php

class Threads
{
  public $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  //スレッドの全件取得
  public function getAll()
  {
    $stmt = $this->pdo->query("select * from threads order by created_at desc");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  //投稿の保存メソッド
  public function create($title)
  {
    $stmt = $this->pdo->prepare("insert into threads(title) values(:title)");
    $stmt->bindvalue(':title', $title, PDO::PARAM_STR);
    $stmt->execute();
  }

  //ID検索
  public function findById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM threads WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  //
  public function isExist($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM threads WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
