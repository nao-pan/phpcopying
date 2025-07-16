<?php

namespace Pcopy\Bbs2\Validation;

class ValidatorFactory
{
  public static function create(string $type, ?string $customPath = null): BaseValidator
  {
    $forbiddenWords = ForbiddenWordLoader::load($customPath);

    return match ($type) {
      'post' => new PostValidator($forbiddenWords),
      'thread' => new ThreadValidator($forbiddenWords),
      default => throw new \InvalidArgumentException("Unsupported type: $type")
    };
  }
}
