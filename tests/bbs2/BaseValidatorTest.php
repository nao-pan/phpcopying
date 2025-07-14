<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Pcopy\Bbs2\Validation\BaseValidator;

#[CoversClass(BaseValidator::class)]
class BaseValidatorTest extends TestCase
{
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

    public function testRequiredAddsErrorWhenValueIsEmpty(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前は必須項目です。', $validator->getErrors());
    }

    public function testRequiredAddsErrorWhenValueIsOnlySpaces(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('  ', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前は必須項目です。', $validator->getErrors());
    }

    public function testRequiredWhenValueIsNotEmptyThenSucceeds(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('田中太郎', '名前');
        $this->assertFalse($validator->hasErrors());
        $this->assertEmpty($validator->getErrors());
    }

    public function testMaxLengthAllowsValueWithinLimit(): void
    {
        $validator = new DummyValidator([]);
        $validator->maxLength('abcd', 4, '名前');
        $this->assertFalse($validator->hasErrors());
        $this->assertEmpty($validator->getErrors());
    }

    public function testMaxLengthAddsErrorIfValueExceedsLimit(): void
    {
        $validator = new DummyValidator([]);
        $validator->maxLength('abcde', 4, '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前は4文字以内で入力してください。', $validator->getErrors());
    }

    public function testContainsForbiddenWordsReturnsTrueWhenTextContainsForbiddenWord(): void
    {
        $validator = new DummyValidator(['禁止語1']);
        $validator->containsForbiddenWords('禁止語1', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前に禁止語「禁止語1」が含まれています。', $validator->getErrors());
    }

    public function testContainsForbiddenWordsAddErrorsWhenTextContainsTwoForbiddenWords(): void
    {
        $validator = new DummyValidator(['禁止語1', '禁止語2']);
        $validator->containsForbiddenWords('禁止語1と禁止語2', '名前');
        $this->assertTrue($validator->hasErrors());
        $this->assertContains('名前に禁止語「禁止語1」が含まれています。', $validator->getErrors());
        $this->assertContains('名前に禁止語「禁止語2」が含まれています。', $validator->getErrors());
    }

    public function testContainsForbiddenWordsPassesWhenTextHasNoMatch(): void
    {
        $validator = new DummyValidator([]);
        $validator->containsForbiddenWords('こんにちは', '名前');
        $this->assertFalse($validator->hasErrors());
        $this->assertEmpty($validator->getErrors());
    }

    public function testGetErrorsReturnsAllCollectedErrors(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('', '名前');
        $errors = $validator->getErrors();
        $this->assertIsArray($errors);
        $this->assertCount(1, $errors);
    }

    public function testHasErrorsReturnsTrueWhenErrorsExist(): void
    {
        $validator = new DummyValidator([]);
        $validator->required('', '名前');
        $this->assertTrue($validator->hasErrors());
    }
}

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
