<?php

namespace Pcopy\Bbs2\Validation;

class ThreadValidator extends BaseValidator
{
  public function validate(array|string $title): void
  {
    $this->checkRequired($title);
    $this->checkMaxLength($title);
    $this->checkForbiddenWords($title);
  }

  protected function checkRequired(array|string $title): void
  {
    $this->required($title ?? '', 'タイトル');
  }

  protected function checkMaxLength(array|string $title): void
  {
    $this->maxLength($title ?? '', 20, 'タイトル');
  }
  protected function checkForbiddenWords(array|string $title): void
  {
    $this->containsForbiddenWords($title ?? '', 'タイトル');
  }
}
