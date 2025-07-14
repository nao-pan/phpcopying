<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Pcopy\Bbs2\Validation\ForbiddenWordLoader;

#[CoversClass(ForbiddenWordLoader::class)]
class ForbiddenWordLoaderTest extends TestCase
{
  private string $testFilePath;

  protected function setUp():void
  {
    //テスト用の禁止語ファイルを作成
    $this->testFilePath = __DIR__ . '/../common/forbidden_words_test.php';
    file_put_contents($this->testFilePath, "<?php return ['禁止語1', '禁止語2'];");
  }

  protected function tearDown(): void
  {
    // テストファイルを削除
    if(file_exists($this->testFilePath)){
      unlink($this->testFilePath);
    }
  }

  public function testLoadReturnsArray(): void
  {
    $words = ForbiddenWordLoader::load($this->testFilePath);
    $this->assertIsArray($words);
    $this->assertContains('禁止語1', $words);
    $this->assertContains('禁止語2', $words);
  }

  public function testThrowsExceptionWhenFileDoesNotExist(): void
  {
    $invalidPath = __DIR__ . '/../common/non_existent_file.php';

    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('禁止語リストファイルが見つかりません');
    ForbiddenWordLoader::load($invalidPath);
  }
}
