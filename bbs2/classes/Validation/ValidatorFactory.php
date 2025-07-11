<?php

namespace Pcopy\Bbs2\Validation;

class ValidatorFactory
{
  public static function create(string $type): BaseValidator
  {
    $forbiddenWords = ForbiddenWordLoader::load();

    return match ($type) {
      'post' => new PostValidator($forbiddenWords),
      'thread' => new ThreadValidator($forbiddenWords),
      default => throw new \InvalidArgumentException("Unsupported type: $type")
    };
  }
}
