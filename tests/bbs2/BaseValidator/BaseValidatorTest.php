<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Pcopy\Bbs2\Validation\BaseValidator;

#[CoversClass(BaseValidator::class)]
class BaseValidatorTest extends TestCase
{
    /**
     * 1.テスト対象：required
     *   ケース:値が空文字 
     *   期待結果:エラー 名前は必須項目です。
     */
    public function testRequiredAddsErrorWhenValueIsEmpty(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前は必須項目です。', $validator->getErrors());
    }

    /**
    * 2.テスト対象：required
    *   ケース:値が空白文字 
    *   期待結果:エラー 名前は必須項目です。
    */
    public function testRequiredAddsErrorWhenValueIsOnlySpaces(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('  ', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前は必須項目です。', $validator->getErrors());
    }

    /**
    * 3.テスト対象：required
    *   ケース:値が正常 
    *   期待結果:エラーなし
    */
    public function testRequiredWhenValueIsNotEmptyThenSucceeds(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('田中太郎', '名前');
        $this->assertFalse($validator->hasErrors());
        $this->assertEmpty($validator->getErrors());
    }

    /**
    * 4.テスト対象：maxLength
    *   ケース:値が指定以内の長さ
    *   期待結果:エラーなし
    */
    public function testMaxLengthAllowsJustUnderLimit(): void
    {
        $validator = new DummyValidator([]);
        $validator->maxLength(str_repeat('あ', 9), 10, '名前');
        $this->assertFalse($validator->hasErrors());
    }

    /**
    * 5.テスト対象：maxLength
    *   ケース:値が指定ちょうどの長さ
    *   期待結果:エラーなし
    */
    public function testMaxLengthAllowsValueWithinLimit(): void
    {
        $validator = new DummyValidator([]);
        $validator->maxLength(str_repeat('あ', 9), 9, '名前');
        $this->assertFalse($validator->hasErrors());
        $this->assertEmpty($validator->getErrors());
    }

    /**
    * 6.テスト対象：maxLength
    *   ケース:値が指定を超える長さ
    *   期待結果:エラー 名前は4文字以内で入力してください。
    */
    public function testMaxLengthAddsErrorIfValueExceedsLimit(): void
    {
        $validator = new DummyValidator([]);
        $validator->maxLength(str_repeat('あ', 9), 8, '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前は8文字以内で入力してください。', $validator->getErrors());
    }

    /**
    * 7.テスト対象：containsForbiddenWords
    *   ケース:一致なし
    *   期待結果:エラーなし
    */
    public function testContainsForbiddenWordsPassesWhenTextHasNoMatch(): void
    {
        $validator = new DummyValidator([]);
        $validator->containsForbiddenWords('こんにちは', '名前');
        $this->assertFalse($validator->hasErrors());
        $this->assertEmpty($validator->getErrors());
    }

    /**
    * 8.テスト対象：containsForbiddenWords
    *   ケース:一致あり
    *   期待結果:エラー 名前に禁止語「禁止語1」が含まれています。
    */
    public function testContainsForbiddenWordsReturnsTrueWhenTextContainsForbiddenWord(): void
    {
        $validator = new DummyValidator(['禁止語1']);
        $validator->containsForbiddenWords('禁止語1', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前に禁止語「禁止語1」が含まれています。', $validator->getErrors());
    }

    /**
    * 9.テスト対象：containsForbiddenWords
    *   ケース:複数語含む
    *   期待結果:エラー 2件 名前に禁止語「禁止語1」が含まれています。,名前に禁止語「禁止語2」が含まれています。
    */
    public function testContainsForbiddenWordsAddErrorsWhenTextContainsTwoForbiddenWords(): void
    {
        $validator = new DummyValidator(['禁止語1', '禁止語2']);
        $validator->containsForbiddenWords('禁止語1と禁止語2', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前に禁止語「禁止語1」が含まれています。', $validator->getErrors());
        $this->assertContains('名前に禁止語「禁止語2」が含まれています。', $validator->getErrors());
    }

    /**
    * 10.テスト対象：getErrors
    *    ケース:requiredでエラー発生時
    *    期待結果:エラー メッセージ配列を返す
    */
    public function testGetErrorsReturnsAllCollectedErrors(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('', '名前');
        $errors = $validator->getErrors();
        $this->assertIsArray($errors);
        $this->assertCount(1, $errors);
    }

    /**
    * 11.テスト対象：hasErrors
    *    ケース:requiredでエラー発生時
    *    期待結果:true
    */
    public function testHasErrorsReturnsTrueWhenErrorsExist(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('', '名前');
        $this->assertTrue($validator->hasErrors());
    }

    /**
    * 12.テスト対象：hasErrors
    *    ケース:エラーなしの状態
    *    期待結果:false
    */
    public function testHasErrorsReturnsFalseWhenNothingErrors(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('田中', '名前');
        $this->assertFalse($validator->hasErrors());
    }

    /**
    * 13.テスト対象：validate
    *    ケース:すべてのバリデーションでエラー
    *    期待結果:エラー3件、hasErrorでtrue
    */
    public function testValidateCollectsAllErrors(): void
    {
        $validator = new DummyValidator(['禁止語']);
        $validator->validate(['dummy' => 'data']);

        $errors = $validator->getErrors();

        $this->assertIsArray($errors);
        $this->assertNotEmpty($errors);
        $this->assertCount(3, $errors);
        $this->assertTrue($validator->hasErrors());
    }
}

/**
 * 抽象クラス BaseValidatorクラスをテストするためのダミークラス
 */
class DummyValidator extends BaseValidator
{
    public function __construct(array $forbiddenWords = [])
    {
        parent::__construct($forbiddenWords);
    }

    protected function checkRequired(array|string $data): void
    {
        $this->required('', 'フィールド');
    }

    protected function checkMaxLength(array|string $data): void
    {
        $this->maxLength('テスト文字列', 5, 'フィールド');
    }

    protected function checkForbiddenWords(array|string $data): void
    {
        $this->containsForbiddenWords('これは禁止語を含む', 'フィールド');
    }
}
