<?php

namespace Pcopy\Bbs2\Validation;

class PostValidator extends BaseValidator
{

  protected function checkRequired(array|string $data): void
  {
    $this->required($data['name'] ?? '', '名前');
    $this->required($data['body'] ?? '', '投稿内容');
  }

  protected function checkMaxLength(array|string $data): void
  {
    $this->maxLength($data['name'] ?? '', 20, '名前');
    $this->maxLength($data['body'] ?? '', 200, '投稿内容');
  }
  protected function checkForbiddenWords(array|string $data): void
  {
    $this->containsForbiddenWords($data['name'] ?? '', '名前');
    $this->containsForbiddenWords($data['body'] ?? '', '投稿内容');
  }
}
