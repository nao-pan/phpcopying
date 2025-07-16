# ValidatorFactory テスト観点リスト

## テスト対象の機能
- `create(string $type, ?string $customPath = null): BaseValidator`

---

## テスト観点一覧

| No | テスト項目                                         | 入力値例                                      | 期待結果                                                | 備考                              |
|----|----------------------------------------------------|-----------------------------------------------|-----------------------------------------------------------|-----------------------------------|
| 1  | `type` が `'post'` の場合                          | type: `'post'`, customPath: `null`            | `PostValidator` のインスタンスが返る                      | デフォルトパスから読み込み       |
| 2  | `type` が `'thread'` の場合                        | type: `'thread'`, customPath: `null`          | `ThreadValidator` のインスタンスが返る                    | デフォルトパスから読み込み       |
| 3  | `type` が `'post'` で `customPath` を指定          | type: `'post'`, customPath: `'path/to/file'`  | 指定ファイルから禁止語を読み込み、`PostValidator` を返す | テスト用ファイルで検証可能       |
| 4  | `type` が `'thread'` で `customPath` を指定        | type: `'thread'`, customPath: `'path/to/file'`| 指定ファイルから禁止語を読み込み、`ThreadValidator` を返す|                                   |
| 5  | `type` に未対応の値を渡した場合（例: `'invalid'`）| type: `'invalid'`                             | `InvalidArgumentException` がスローされる                 | 例外の型・メッセージを確認        |
| 6  | `customPath` に存在しないファイルを指定            | customPath: `'not_exist.php'`                 | `RuntimeException` がスローされる                         | `ForbiddenWordLoader` の例外確認 |

---

## 備考
- `customPath` は `ForbiddenWordLoader::load()` に引数として渡される
- テストでは `customPath` にテスト用のファイルを動的生成することが推奨される
- `PostValidator` と `ThreadValidator` は `BaseValidator` を継承していることを前提とする
