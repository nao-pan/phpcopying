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
    $this->validator = new Validator();
  }

  /**
  * @covers Validator::required
  */
  public function test_required_adds_error_when_value_is_empty(){
    $this->validator->required('', '名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前は必須項目です。', $this->validator->getErrors());
  }

  /**
   * @covers Validator::maxLength
   */
  public function test_maxLength_allows_value_within_limit(){
    $this->validator->maxLength('abc', 4, '名前');
    $this->assertFalse($this->validator->hasErrors());
  }

  /**
  * @covers Validator::maxLength
  */
  public function test_maxLength_adds_error_if_value_exceeds_limit(){
    $this->validator->maxLength('abcde', 4, '名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前は4文字以内で入力してください。', $this->validator->getErrors());
  }

  /**
   * @covers Valodator::containsForbiddenWords
   */
  public function test_containsForbiddenWords_returns_true_when_text_contains_forbidden_word(){
    $this->validator->containsForbiddenWords('ばか','名前');
    $this->assertTrue($this->validator->hasErrors());
    $this->assertContains('名前に禁止語「ばか」が含まれています。',$this->validator->getErrors());
  }
    
}