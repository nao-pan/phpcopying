# BaseValidator テスト観点リスト

## テスト対象の機能
- `required(string $value, string $fieldName)`
- `maxLength(string $value, int $max, string $fieldName)`
- `containsForbiddenWords(string $value, string $fieldName)`
- `getErrors()`
- `hasErrors()`

---

## テスト観点一覧

| No | テスト項目                           | 入力値例                                         | 期待結果                                             | 備考 |
|----|--------------------------------------|--------------------------------------------------|------------------------------------------------------|------|
| 1  | `required`：値が空文字              | value: "", fieldName: "名前"                     | エラー：`名前は必須項目です。`                      | `trim()` で空判定 |
| 2  | `required`：値が空白のみ            | value: "   ", fieldName: "名前"                  | エラー：`名前は必須項目です。`                      | 前後空白を除去 |
| 3  | `required`：値が正常                | value: "田中", fieldName: "名前"                 | エラーなし                                           |                                                |
| 4  | `maxLength`：指定以内の長さ         | value: "あいう", max: 10, fieldName: "名前"      | エラーなし                                           | `mb_strlen()` |
| 5  | `maxLength`：指定ちょうどの長さ     | value: "あ"×10, max: 10, fieldName: "名前"       | エラーなし                                           |                                                |
| 6  | `maxLength`：指定を超える長さ       | value: "あ"×11, max: 10, fieldName: "名前"       | エラー：`名前は10文字以内で入力してください。`      |                                                |
| 7  | `containsForbiddenWords`：一致なし  | value: "こんにちは", forbiddenWords: ["禁止語"], fieldName: "本文" | エラーなし                   |                                                  |
| 8  | `containsForbiddenWords`：一致あり  | value: "これは禁止語です", forbiddenWords: ["禁止語"], fieldName: "本文" | エラー：`本文に禁止語「禁止語」が含まれています。` | `mb_strpos()` を使用 |
| 9  | `containsForbiddenWords`：複数語含む| value: "XXX禁止語YYY暴力", forbiddenWords: ["禁止語", "暴力"], fieldName: "本文" | エラー2件 | 2件の禁止語を検出 |
| 10 | `getErrors()`：エラー登録後に取得    | 上記エラー発生後                                 | エラーメッセージ配列が返る                          | 配列内容確認 |
| 11 | `hasErrors()`：エラーがある場合      | エラー発生済                                     | true を返す                                         |                                                |
| 12 | `hasErrors()`：エラーがない場合      | エラーなしの状態                                 | false を返す                                        |                                                |

---

## 備考
- `BaseValidator` は抽象クラスのため、ダミークラスを使って `required()` 等のメソッドを呼び出す形式で実施
