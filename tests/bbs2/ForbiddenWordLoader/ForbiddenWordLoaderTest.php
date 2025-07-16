<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Pcopy\Bbs2\Validation\ForbiddenWordLoader;

#[CoversClass(ForbiddenWordLoader::class)]
class ForbiddenWordLoaderTest extends TestCase
{
  private string $testFilePath;
  private string $testFilePathAsNotArray;

  protected function setUp():void
  {
    //テスト用の禁止語ファイルを作成
    $this->testFilePath = __DIR__ . '/../../common/forbidden_words_test.php';
    file_put_contents($this->testFilePath, "<?php return ['禁止語1', '禁止語2'];");

    //テスト用の配列ではない禁止語ファイルを作成
    $this->testFilePathAsNotArray = __DIR__ . '/../../common/forbidden_word_not_array_test.php';
    file_put_contents($this->testFilePathAsNotArray, "<?php return 'これは文字列です';");
  }

  protected function tearDown(): void
  {
    // テストファイルを削除
    if(file_exists($this->testFilePath)){
      unlink($this->testFilePath);
    }
    if(file_exists($this->testFilePathAsNotArray)){
      unlink($this->testFilePathAsNotArray);
    }
  }

  /**
   * 1.テスト対象:load
   *   ケース:ロード先がある場合
   *   期待結果:エラーなし
   */
  public function testLoadReturnsArray(): void
  {
    $words = ForbiddenWordLoader::load($this->testFilePath);
    $this->assertIsArray($words);
    $this->assertContains('禁止語1', $words);
    $this->assertContains('禁止語2', $words);
  }

    /**
   * 2.テスト対象:load
   *   ケース:ロード先が見つからない場合
   *   期待結果:エラー 禁止語リストファイルが見つかりません。
   */
  public function testThrowsExceptionWhenFileDoesNotExist(): void
  {
    $invalidPath = __DIR__ . '/../common/non_existent_file.php';

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('禁止語リストファイルが見つかりません。: '.$invalidPath);
    ForbiddenWordLoader::load($invalidPath);
  }

  /**
   * 3.テスト対象:load
   *   ケース:ロード先ファイルが配列以外を返す時
   *   期待結果:エラー 禁止語リストファイルは配列を返す必要があります。
   */
  public function testThrowsUnexpectedValueExceptionWhenFileReturnNotArray(): void
  {
    $this->expectException(\UnexpectedValueException::class);
    $this->expectExceptionMessage('禁止語リストファイルは配列を返す必要があります。: '.$this->testFilePathAsNotArray);
    ForbiddenWordLoader::load($this->testFilePathAsNotArray);
  }
}
