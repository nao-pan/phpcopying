<?php

class Validator
{
  private array $errors = [];
  private array $forbiddenWords;

  public function __construct(array $forbiddenWords)
  {
    $this->forbiddenWords = $forbiddenWords;

    // 以下の設計（引数なしで読み込みしセット）を行っていたが、禁止語配列をここで読み込みセットするのは設計上問題あり
    // テストがしにくい上に、このクラスが呼ばれる度に読み込むことになる。

    // $forbiddenWordsPath = __DIR__ . '/../common/forbidden_words.php';
    // if (file_exists($forbiddenWordsPath)) {
    //   $this->forbiddenWords = require $forbiddenWordsPath;
    // } else {
    //   $this->forbiddenWords = []; //ファイルが見つからない場合空に
    // }
  }

  //文字列の必須チェック
  public function required(string $value, string $fieldName): void
  {
    if (trim($value) === '') {
      $this->errors[] = "{$fieldName}は必須項目です。";
    }
  }

  //最大文字数チェック
  public function maxLength(string $value, int $max, string $fieldName): void
  {
    if (mb_strlen($value) > $max) {
      $this->errors[] = "{$fieldName}は{$max}文字以内で入力してください。";
    }
  }

  //禁止語チェック
  public function containsForbiddenWords(string $value, string $fieldName): void
  {
    foreach ($this->forbiddenWords as $word) {
      if (mb_strpos($value, $word) !== false) {
        $this->errors[] = "{$fieldName}に禁止語「{$word}」が含まれています。";
      }
    }
  }

  public function validatePost(array $data): void
  {
    //必須入力チェック
    $this->required($data['name'] ?? '', '名前');
    $this->required($data['body'] ?? '', '投稿内容');

    //最大文字数チェック
    $this->maxLength($data['name'] ?? '', 20, '名前');
    $this->maxLength($data['body'] ?? '', 200, '投稿内容');

    //禁止語チェック
    if (!empty($this->forbiddenWords)) {
      $this->containsForbiddenWords($data['name'] ?? '', '名前');
      $this->containsForbiddenWords($data['body'] ?? '', '投稿内容');
    }
  }

  public function validateThreadTitle($title): void
  {
    //必須入力チェック
    $this->required($title ?? '', 'タイトル');

    //最大文字数チェック
    $this->maxLength($title ?? '', 20, 'タイトル');

    //禁止語チェック
    if (!empty($this->forbiddenWords)) {
      $this->containsForbiddenWords($title ?? '', 'タイトル');
    }
  }

  //エラーメッセージの取得
  public function getErrors(): array
  {
    return $this->errors;
  }

  //エラーがあるか判定
  public function hasErrors(): bool
  {
    return !empty($this->errors);
  }
}
