<?php

namespace Pcopy\Bbs2\Validation;

/**
 * 禁止語を読み込むクラス
 */
class ForbiddenWordLoader
{
    private const DEFAULT_PATH = __DIR__ . '/../../common/forbidden_words.php';

    /**
     * 禁止語リストを読み込む
     *
     * @param string|null $customPath 任意のファイルパス（省略時はデフォルト）
     * @return array 禁止語の配列
     * @throws \RuntimeException ファイルが存在しない、または内容が不正な場合
     */
    public static function load(?string $customPath = null): array
    {
        $path = $customPath ?? self::DEFAULT_PATH;

        if (!file_exists($path)) {
            throw new \RuntimeException("禁止語リストファイルが見つかりません。: $path");
        }

        $words = require $path;

        if (!is_array($words)) {
            throw new \UnexpectedValueException("禁止語リストファイルは配列を返す必要があります。: $path");
        }

        return $words;
    }
}