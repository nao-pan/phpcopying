<?php

use Pcopy\Bbs2\Validation\PostValidator;
use Pcopy\Bbs2\Validation\ThreadValidator;
use Pcopy\Bbs2\Validation\ValidatorFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ValidatorFactory::class)]
class ValidatorFactoryTest extends TestCase
{
  private $testFilePath;
  protected function setUp(): void
  {
    $this->testFilePath = __DIR__ . '/tmp_forbidden_words.php';
    file_put_contents($this->testFilePath, "<?php return ['禁止語1', '禁止語2'];");
  }

  protected function tearDown(): void
  {
    if (file_exists($this->testFilePath)) {
      unlink($this->testFilePath);
    }
  }

  /**
   * 1.テスト対象:create
   *   ケース:typeがpost
   *   期待結果:PostValidatorのインスタンスが返る
   */
  public function testCreateReturnsPostValidatorInstance(): void
  {
    $validator = ValidatorFactory::create('post');
    $this->assertInstanceOf(PostValidator::class, $validator);
  }

  /**
   * 2.テスト対象:create
   *   ケース:typeがthread
   *   期待結果:ThreadValidatorのインスタンスが返る
   */
  public function testCreateReturnsThreadValidatorInstance(): void
  {
    $validator = ValidatorFactory::create('thread');
    $this->assertInstanceOf(ThreadValidator::class, $validator);
  }

  /**
   * 3.テスト対象:create
   *   ケース:typeがpost pathあり
   *   期待結果:ThreadValidatorのインスタンスが返る 禁止語エラー
   */
  public function testCreateReturnsPostValidatorWithCustomPath(): void
  {
    $validator = ValidatorFactory::create('post',$this->testFilePath);
    $this->assertInstanceOf(PostValidator::class, $validator);

    $validator->containsForbiddenWords('禁止語1を含みます', 'フィールド');
    $errors = $validator->getErrors();

    $this->assertNotEmpty($errors);
    $this->assertStringContainsString('禁止語1', $errors[0]);
  }

  /**
   * 4.テスト対象:create
   *   ケース:typeがthread pathあり
   *   期待結果:ThreadValidatorのインスタンスが返る 禁止語エラー
   */
  public function testCreateReturnsThreadValidatorWithCustomPath(): void
  {
    $validator = ValidatorFactory::create('thread',$this->testFilePath);
    $this->assertInstanceOf(ThreadValidator::class, $validator);

    $validator->containsForbiddenWords('禁止語1を含みます', 'フィールド');
    $errors = $validator->getErrors();

    $this->assertNotEmpty($errors);
    $this->assertStringContainsString('禁止語1', $errors[0]);
  }

  /**
   * 5.テスト対象:create
   *   ケース:typeが存在しない値
   *   期待結果:InvalidArgumentExceptionがスローされる 
   */
  public function testCreateThrowsExceptionWhenTypeIsInvalid(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Unsupported type: invalid');
    ValidatorFactory::create('invalid');
  }

  /**
   * 6.テスト対象:create
   *   ケース:pathが存在しない値
   *   期待結果:RuntimeExceptionがスローされる 
   */
  public function testCreateThrowsExceptionWhenPathIsInvalid(): void
  {
    $path = __DIR__ . 'not_exist.php';
    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage("禁止語リストファイルが見つかりません。: $path");
    ValidatorFactory::create('thread',$path);
  }
}
