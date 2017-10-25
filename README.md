php-function
====

## Install

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/arima-ryunosuke/php-functions.git"
        }
    ],
    "require": {
        "ryunosuke/functions": "dev-master"
    }
}
```

## Usage

各リファレンスは docs/index.html を参照してください。

### import

```php
require __DIR__ . '/vendor/autoload.php';

// グローバルへ展開
\ryunosuke\Functions\Loader::importAsGlobal();
// 名前空間へ展開
\ryunosuke\Functions\Loader::importAsNamespace();
```

グローバル展開はまさにグローバルへ展開されます。
名前空間展開は `\ryunosuke\Functions\functionname` で定義されます。

php 5.6 未満だと関数の use が出来ないのでグローバルのほうが利便性があるでしょう。
5.6 以降なら名前空間の方がいいでしょう（use が増えますけど）。

### export

下記のようにすると指定ディレクトリへ指定名前空間でファイル自体が吐き出されます。

```php
require __DIR__ . '/vendor/autoload.php';

// 任意の名前空間へ出力
\ryunosuke\Functions\Loader::exportToNamespace('/path/to/namespace', 'vendor\\Functions');
```

あとはプロジェクト固有の include.php などで吐き出したファイルを読み込めば OK です。
これの利点は名前空間を変更できる点と、管理下のディレクトリに吐き出せることでカスタムができる点です。
逆に言えば既存の処理しか使わないなら任意名前空間に吐き出すメリットはあまりありません。

### constant

少し変わった仕様として、関数名と同名の定数も定義されます。
グローバル展開はともかく、名前空間展開していると `array_map` などに文字列として渡すのがとてもしんどくなりますが、この定数を使えば IDE による補完＋チェック付きで渡すことが出来ます。

```php
require __DIR__ . '/vendor/autoload.php';

use const ryunosuke\Functions\strcat;

\ryunosuke\Functions\Loader::importAsNamespace();

// しんどい
array_map('\\ryunosuke\\Functions\\strcat', ['something array']);
// らくちん
array_map(strcat, ['something array']);
```

ただし、上記の通り定数 use が可能な 5.6 以降でないとあまり意味はありません。

### cache

リクエスト間でのパフォーマンス向上のため、雑なキャッシュが組み込まれています。
下記のようにするとキャッシュがオンになります。

```php
require __DIR__ . '/vendor/autoload.php';

\ryunosuke\Functions\Cacher::initialize(new \ryunosuke\Functions\FileCache('/path/to/cache'));
```

initialize に渡すオブジェクトは PSR-16 の simple-cache 実装オブジェクトです。
組み込みの FileCache は有効期限とかそういったリッチな機能は一切ありません。
また、ファイル名や行数でキャッシュしたりするので、有効にした場合は必ずデプロイ後にクリアしてください。

## Development

基本的に触るのは `src/package` 以下のみです。他の似たようなファイルは自動生成です。

同じ関数があちこちにバラけるので、IDE によるジャンプが活かせません。
phpstorm 等なら下記のディレクトリを Exclude するといいでしょう。

- src/global
- src/namespace
- tests/namespace

composer subcommand として下記が定義されています。

- composer build
  - 下記の export, test, document を全て実行します
- composer export
  - src/package を元に自動生成ファイルを吐き出します
- composer test
  - phpunit を実行します
- composer test-coverage
  - カバレッジ付きで phpunit を実行します
- composer document
  - docs/html 以下にドキュメントを生成します
