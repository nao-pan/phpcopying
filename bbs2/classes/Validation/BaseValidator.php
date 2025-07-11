<?php

namespace Pcopy\Bbs2\Validation;

abstract class BaseValidator
{
  private array $errors = [];
  private array $forbiddenWords;

  public function __construct(array $forbiddenWords)
  {
    $this->forbiddenWords = $forbiddenWords;
  }

  //テンプレートメソッド
  public function validate(array|string $data): void
  {
    $this->checkRequired($data);
    $this->checkMaxLength($data);
    $this->checkForbiddenWords($data);
  }

  //サブクラスごとに実装
  abstract protected function checkRequired(array|string $data): void;
  abstract protected function checkMaxLength(array|string $data): void;
  abstract protected function checkForbiddenWords(array|string $data): void;

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
