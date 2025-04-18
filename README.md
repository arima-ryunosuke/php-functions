php-function
====

## Install

```json
{
    "require": {
        "ryunosuke/functions": "dev-master"
    }
}
```

## Usage

各リファレンスは https://arima-ryunosuke.github.io/php-functions/ を参照してください。
変更点は [RELEASE.md](RELEASE.md) です。

### import

```php
require __DIR__ . '/vendor/autoload.php';

// グローバルへ展開
\ryunosuke\Functions\Transporter::importAsGlobal();
// 名前空間へ展開
\ryunosuke\Functions\Transporter::importAsNamespace();
```

各関数前で assert が行われます。具体的には下記の動作です。

- 定義されていない
- 定義されていてかつそれがユーザー定義
- 定義されていてかつそれが組み込みなら Fatal Error

これは下記の動作を満たすためです。

- 一部上書きしたいかもしれない
  - スキップされるのであらかじめ定義しておくことで差し替えが可能になる
- 組み込みに新しく関数が増えるかもしれない
  - `!function_exists()` だと動いてしまうので定義時点で Fatal Error になったほうが安全

### export

下記のようにすると指定名前空間でファイル自体が吐き出されます。
こっちの利用方法がメインです。

```php
require __DIR__ . '/vendor/autoload.php';

// 任意の名前空間へ出力
file_put_contents('path/to/function.php', \ryunosuke\Functions\Transporter::exportNamespace('namespace'));
```

あとはプロジェクト固有の include.php などで吐き出したファイルを読み込めば OK です。
これの利点は名前空間を変更できる点と、管理下のディレクトリに吐き出せることでカスタムができる点です。
さらに package との関連性が切れるため、原理上競合しなくなります。

下記のように第2引数を指定すると指定した関数と依存関係にある関数のみが吐き出されます。

```php
require __DIR__ . '/vendor/autoload.php';

// 'funcA', 'funcB' だけを出力
file_put_contents('path/to/function.php', \ryunosuke\Functions\Transporter::exportNamespace('namespace', ['funcA', 'funcB']));
```

さらに第2引数にファイル名やディレクトリ名を与えるとそれらを php とみなして実際に使用されている関数のみが吐き出されます。

```php
require __DIR__ . '/vendor/autoload.php';

// /path/to/project 内で使われている関数だけを出力
file_put_contents('path/to/function.php', \ryunosuke\Functions\Transporter::exportNamespace('namespace', '/path/to/project'));
```

依存関係も解決するので、例えば `funcA` や `funcB` が `funcC` に依存していれば `funcC` も吐き出されます。
用途はちょろっとしたコード片のコピペ用です（全体は要らんけど特定のやつだけ吐き出したい用途が個人的にあった）。

上記は `composer.json` の `autoload` をよしなに読んで自動で吐き出すコマンドが用意されています。

```
vendor/bin/export-function
# composer exec export-function
```

ただし、ほとんど内部用です。

下記のように exportClass を使用すると単一静的クラスとして吐き出せます。

```php
require __DIR__ . '/vendor/autoload.php';

// name\space\Utils に単一クラスとして出力
file_put_contents('src/Utils.php', \ryunosuke\Functions\Transporter::exportNamespace('name\\space\\Utils', ['吐き出したい関数など']));
```

用途はいわゆる Utils 静的クラスです。
ただし、ほとんど内部用です。

## Development

基本的に触るのは `src/Package` 以下のみです。他の似たようなファイルは自動生成です。

同じ関数があちこちにバラけるので、IDE によるジャンプが活かせません。
phpstorm 等なら 'include' を Exclude するといいでしょう。

composer subcommand として下記が定義されています。

- composer build
  - 下記の export, test, document を全て実行します
- composer export
  - src/Package を元に自動生成ファイルを吐き出します
- composer test
  - phpunit を実行します
