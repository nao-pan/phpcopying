<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../bbs2/classes/Validator.php';
/**
 * @covers Validator
 */
class ValidatorTest extends TestCase
{
  private Validator $validator;

  protected function setUp(): void
  {
    $this->validator = new Validator(['禁止語1', '禁止語2']);
  }

  /**
   * @covers Validator::required
   */
  public function test_required_adds_error_when_value_is_empty()
  {
    $this->validator->required('', '名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前は必須項目です。', $this->validator->getErrors());
  }

    /**
   * @covers Validator::required
   */
  public function test_required_adds_error_when_value_is_only_spaces()
  {
    $this->validator->required('  ', '名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前は必須項目です。', $this->validator->getErrors());
  }

  /**
   * @covers Validator::required
   */
  public function test_required_when_value_is_not_empty_then_succeeds()
  {
    $this->validator->required('田中太郎', '名前');
    $this->assertFalse($this->validator->hasErrors());
        $this->assertEmpty($this->validator->getErrors());
  }

  /**
   * @covers Validator::maxLength
   */
  public function test_maxLength_allows_value_within_limit()
  {
    $this->validator->maxLength('abcd', 4, '名前');
    $this->assertFalse($this->validator->hasErrors());
        $this->assertEmpty($this->validator->getErrors());
  }

  /**
   * @covers Validator::maxLength
   */
  public function test_maxLength_adds_error_if_value_exceeds_limit()
  {
    $this->validator->maxLength('abcde', 4, '名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前は4文字以内で入力してください。', $this->validator->getErrors());
  }

  /**
   * @covers Validator::containsForbiddenWords
   */
  public function test_containsForbiddenWords_returns_true_when_text_contains_forbidden_word()
  {
    $this->validator->containsForbiddenWords('禁止語1', '名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前に禁止語「禁止語1」が含まれています。', $this->validator->getErrors());
  }

    /**
   * @covers Validator::containsForbiddenWords
   */
  public function test_containsForbiddenWords_add_errors_when_text_contains_two_forbidden_words()
  {
    $this->validator->containsForbiddenWords('禁止語1と禁止語2', '名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前に禁止語「禁止語1」が含まれています。', $this->validator->getErrors());
    $this->assertContains('名前に禁止語「禁止語2」が含まれています。', $this->validator->getErrors());
  }

      /**
   * @covers Validator::containsForbiddenWords
   */
  public function test_containsForbiddenWords_passes_when_text_has_no_match()
  {
    $this->validator->containsForbiddenWords('こんにちは', '名前');
    $this->assertFalse($this->validator->hasErrors());
    $this->assertEmpty($this->validator->getErrors());
  }
}
