<?php

class Validator
{
  private array $errors = [];
  private array $forbiddenWords;

  public function __construct(string $forbiddenWordsPath = __DIR__ . '/../common/forbidden_words.php')
  {
    if (file_exists($forbiddenWordsPath)) {
      $this->forbiddenWords = require $forbiddenWordsPath;
    } else {
      $this->forbiddenWords = []; //ファイルが見つからない場合空に
    }
  }

  //文字列の必須チェック
  public function reqired(string $value, string $fieldName): void
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

  public function validateAll(array $data): void
  {
    //必須入力チェック
    $this->reqired($data['name'] ?? '', '名前');
    $this->reqired($data['comment'] ?? '', 'コメント');

    //最大文字数チェック
    $this->maxLength($data['name'] ?? '', 20, '名前');
    $this->maxLength($data['comment'] ?? '', 200, 'コメント');

    //禁止語チェック
    if (!empty($this->forbiddenWords)) {
      $this->containsForbiddenWords($data['name'] ?? '', '名前');
      $this->containsForbiddenWords($data['comment'] ?? '', 'コメント');
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
