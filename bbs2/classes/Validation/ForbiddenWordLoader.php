<?php

namespace Pcopy\Bbs2\Validation;

/**
 * 禁止語を読み込むクラス
 */
class ForbiddenWordLoader
{
  public static function load(): array
  {
    $path = __DIR__ . '../../common/forbidden_words.php';
    if (!file_exists($path)) {
      throw new \RuntimeException("禁止語リストファイルが見つかりません。: $path");
    }
    return require_once $path;
  }
}
