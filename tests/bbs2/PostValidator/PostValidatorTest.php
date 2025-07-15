<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Pcopy\Bbs2\Validation\PostValidator;

#[CoversClass(PostValidator::class)]
class PostValidatorTest extends TestCase
{
  private PostValidator $validator;

  protected function setUp(): void
  {
    $this->validator = new PostValidator(['禁止語']);
  }

  /**
   * 1.テスト対象：validate
   *   ケース:正常データ
   *   期待結果:エラーなし
   */
  public function testValidDataPassesValidation(): void
  {
    $this->validator->validate(['name' => '田中', 'body' => 'こんにちは']);
    $this->assertFalse($this->validator->hasErrors());
    $this->assertEmpty($this->validator->getErrors());
  }

  /**
   * 2.テスト対象:checkRequired
   *   ケース:名前が空
   *   期待結果:エラー 名前は必須項目です。
   */
  public function testCheckRequiredWhenNameIsEmpty(): void
  {
    $this->validator->validate(['name' => '', 'body' => 'こんにちは']);
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前は必須項目です。', $this->validator->getErrors());
  }

  /**
   * 3.テスト対象:checkRequired
   *   ケース:投稿内容が空
   *   期待結果:エラー 投稿内容は必須項目です。
   */
  public function testCheckRequiredBodyIsEmpty(): void
  {
    $this->validator->validate(['name' => '田中', 'body' => '']);
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('投稿内容は必須項目です。', $this->validator->getErrors());
  }

  /**
   * 4.テスト対象:checkRequired
   *   ケース:名前と投稿内容が空
   *   期待結果:エラー2件
   */
  public function testCheckRequiredWhenNameAndBodyAreEmpty(): void
  {
    $this->validator->validate(['name' => '', 'body' => '']);
    $errors = $this->validator->getErrors();

    $this->assertCount(2, $errors);
    $this->assertTrue($this->validator->hasErrors());
  }


  /**
   * 5.テスト対象:checkMaxLength
   *   ケース:名前が21文字
   *   期待結果:エラー 名前は20文字以内で入力してください。
   */
  public function testCheckMaxLengthWhenNameIsOverLimit(): void
  {
    $this->validator->validate(['name' => str_repeat('あ', 21), 'body' => str_repeat('あ', 200)]);
    $errors = $this->validator->getErrors();

    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前は20文字以内で入力してください。', $errors);
  }

  /**
   * 6.テスト対象:checkMaxLength
   *   ケース:投稿内容が201文字
   *   期待結果:エラー 投稿内容は200文字以内で入力してください。
   */
  public function testCheckMaxLengthWhenBodyIsOverLimit(): void
  {
    $this->validator->validate(['name' => str_repeat('あ', 20), 'body' => str_repeat('あ', 201)]);
    $errors = $this->validator->getErrors();

    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('投稿内容は200文字以内で入力してください。', $errors);
  }

  /**
   * 7.テスト対象:checkMaxLength
   *   ケース:名前と投稿内容が共に超過
   *   期待結果:エラー2件
   */
  public function testCheckMaxLengthWhenNameAndBodyAreOverLimit(): void
  {
    $this->validator->validate(['name' => str_repeat('あ', 21), 'body' => str_repeat('あ', 201)]);
    $errors = $this->validator->getErrors();

    $this->assertCount(2, $errors);
    $this->assertTrue($this->validator->hasErrors());
  }

  /**
   * 8.テスト対象:checkContainsForbiddenWords
   *   ケース:名前に禁止語あり
   *   期待結果:エラー 名前に禁止語「禁止語」が含まれています。
   */
  public function testCheckForbiddenWordsWhenNameContainsForbiddenWord(): void
  {
    $this->validator->validate(['name' => '禁止語です', 'body' => 'こんにちは']);
    $errors = $this->validator->getErrors();

    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前に禁止語「禁止語」が含まれています。', $errors);
  }

    /**
   * 9.テスト対象:checkContainsForbiddenWords
   *   ケース:投稿内容に禁止語あり
   *   期待結果:エラー 投稿内容に禁止語「禁止語」が含まれています。
   */
  public function testCheckForbiddenWordsWhenBodyContainsForbiddenWord(): void
  {
    $this->validator->validate(['name' => '山田', 'body' => '禁止語です。']);
    $errors = $this->validator->getErrors();

    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('投稿内容に禁止語「禁止語」が含まれています。', $errors);
  }

  /**
   * 10.テスト対象:checkContainsForbiddenWords
   *    ケース:名前と投稿内容共に禁止語あり
   *    期待結果:エラー2件
   */
  public function testCheckForbiddenWordsWhenNameAndBodyContainsForbiddenWord(): void
  {
    $this->validator->validate(['name' => '禁止語です', 'body' => '禁止語が含まれています']);
    $errors = $this->validator->getErrors();

    $this->assertCount(2, $errors);
    $this->assertTrue($this->validator->hasErrors());
  }
}
