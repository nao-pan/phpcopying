<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Pcopy\Bbs2\Validation\ThreadValidator;

#[CoversClass(ThreadValidator::class)]
class ThreadValidatorTest extends TestCase
{
  private ThreadValidator $validator;

  protected function setUp(): void
  {
    $this->validator = new ThreadValidator(['禁止語1','禁止語2']);
  }

  /**
   * 1.テスト対象：validate
   *   ケース:正常データ
   *   期待結果:エラーなし
   */
  public function testValidDataPassesValidation(): void
  {
    $this->validator->validate('スレッドタイトル');
    $this->assertFalse($this->validator->hasErrors());
    $this->assertEmpty($this->validator->getErrors());
  }

  /**
   * 2.テスト対象:checkRequired
   *   ケース:タイトルが空文字
   *   期待結果:エラー タイトルは必須項目です。
   */
  public function testCheckRequiredWhenTitleIsEmpty(): void
  {
    $this->validator->validate('');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('タイトルは必須項目です。', $this->validator->getErrors());
  }

  /**
   * 3.テスト対象:checkRequired
   *   ケース:タイトルが空白文字
   *   期待結果:エラー タイトルは必須項目です。
   */
  public function testCheckRequiredWhenTitleIsSpaces(): void
  {
    $this->validator->validate('   ');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('タイトルは必須項目です。', $this->validator->getErrors());
  }

  /**
   * 4.テスト対象:checkMaxLength
   *   ケース:タイトルが20文字
   *   期待結果:エラーなし
   */
  public function testCheckMaxLengthWhenTitleIsJustLimit(): void
  {
    $this->validator->validate(str_repeat('あ', 20));

    $this->assertFalse($this->validator->hasErrors());
    $this->assertEmpty($this->validator->getErrors());
  }

    /**
   * 5.テスト対象:checkMaxLength
   *   ケース:タイトルが21文字
   *   期待結果:エラー タイトルは20文字以内で入力してください。
   */
  public function testCheckMaxLengthWhenTitleIsOverLimit(): void
  {
    $this->validator->validate(str_repeat('あ', 21));
    $errors = $this->validator->getErrors();

    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('タイトルは20文字以内で入力してください。', $errors);
  }

  /**
   * 6.テスト対象:checkContainsForbiddenWords
   *   ケース:タイトルに禁止語なし
   *   期待結果:エラーなし
   */
  public function testCheckForbiddenWordsWhenTitleNotContainsForbiddenWord(): void
  {
    $this->validator->validate('こんにちは');
    $errors = $this->validator->getErrors();

    $this->assertFalse($this->validator->hasErrors());
    $this->assertEmpty($this->validator->getErrors());
  }

  /**
   * 7.テスト対象:checkContainsForbiddenWords
   *   ケース:タイトルに禁止語あり
   *   期待結果:エラー タイトルに禁止語「禁止語1」が含まれています。
   */
  public function testCheckForbiddenWordsWhenTitleContainsForbiddenWord(): void
  {
    $this->validator->validate('禁止語1を含みます');
    $errors = $this->validator->getErrors();

    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('タイトルに禁止語「禁止語1」が含まれています。', $errors);
  }

    /**
   * 8.テスト対象:checkContainsForbiddenWords
   *   ケース:投稿内容に禁止語あり
   *   期待結果:エラー2件
   */
  public function testCheckForbiddenWordsWhenTitleContainsTwoForbiddenWords(): void
  {
    $this->validator->validate('禁止語1と禁止語2を含みます');
    $errors = $this->validator->getErrors();

    $this->assertCount(2, $errors);
    $this->assertTrue($this->validator->hasErrors());
  }

}
