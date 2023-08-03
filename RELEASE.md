# RELEASE

- change: 仕様変更
- feature: 新機能
- fixbug: バグ修正
- refactor: 内部動作の変更
- `*` 付きは互換性破壊

## x.y.z

- Utility が増えてきたから然るべき場所へ移動する
- 使わん関数が多すぎるので整理する（次のメジャーアップ）
- sql_format がカオスなのでリファクタしないとまずい

## 1.6.5

- [fixbug] parse_uri の不具合修正
- [refactor] optional で $expected を与えたときに phpstorm が警告を出すことがあるので修正

## 1.6.4

- [change] exportClass に formatter:off を付与

## 1.6.3

- [feature] Transporter にクラス出力機能を追加
- [feature] set_trace_logger を追加
- [feature] snake_case で略語を維持できる機能
- [feature] pascal_case で複数のデリミタ文字を指定できる機能

## 1.6.2

- [feature] dataurl_encode/dataurl_decode を追加
- [feature] mb_compatible_encoding を追加
- [change] var_pretty の markdown でキーラベルを "#" で明示

## 1.6.1

- [feature] var_pretty で特定クラスを除外する機能

## 1.6.0

- [*feature] mb_monospace を追加
- [feature] var_pretty にテーブル表示する table オプションを追加
- [feature] markdown_table に構造データが来た場合の stringify オプションを追加
- [feature] csv_import にプレフィックスでグルーピングする grouping オプションを追加
- [*feature] dir_diff に unixpath オプションを追加
- [*change] dir_diff の differ の扱いを差分導出から差分検出そのものに変更
- [*feature] file_list に unixpath オプションを追加
- [*change] file_list でディレクトリに DIRECTORY_SEPARATOR を付与するように変更
- [*fixbug] cp_rf で隠しファイルが対象外になっていた不具合を修正
- [refactor] dir_diff のドキュメントが間違っていたので修正
- [*change] file_set_tree のインターフェースを変更
- [fixbug] rm_rf で glob が空振りしてリモートファイルを削除できない不具合を修正
- [refactor] http_request で httpbin にアクセスしていたので修正
- [refactor] ngram が非常に遅かったので是正
- [feature] parse_query に独自実装を追加
- [feature] groupsort を追加
- [feature] strmode/strmode2oct を追加
- [feature] mb_wordwrap を追加
- [feature] now を追加
- [feature] iterator_split を追加
- [feature] iterator_join を追加
- [feature] register_autoload_function を追加
- [feature] include_stream を追加
- [feature] str_diff のリソース対応とバイナリオプション
- [feature] str_diff に split(side-by-side) 形式を追加
- [feature] glob2regex にパスモードを追加
- [feature] str_embed のクロージャ対応と $replaced レシーバを追加
- [feature] var_pretty に通常配列でも折り返すオプションを追加
- [change] sql KEYWORD がデカくて邪魔な上、定数の意味がないので関数内に移動
- [*src] 関数毎にファイルに分割
  - 関数名定数が無くなった
  - クラス経由の直接呼び出しができなくなった

## 1.5.12

- [feature][Utility] process_async で終了処理の変更と何度でも終了処理が呼べるように修正

## 1.5.11

- [fixbug][FileSystem] file_list で存在しないディレクトリを指定すると全ファイルを漁ってしまう不具合を修正

## 1.5.10

- [fixbug][Sql] sql_format で冒頭にコメントがあると位置がズレる不具合を修正
- [feature][FileSystem] file_list の glob 対応
- [feature][FileSystem] file_matcher に subpath フィルタを追加

## 1.5.9

- [feature][Network] http_request にヘッダだけを取得する nobody オプションを追加
- [fixbug][Vars] var_export3 で use 変数が増殖する不具合を修正
- [feature][Vars] var_export3 でマジック定数の読み替え機能
- [feature][Utility] parse_namespace で cache:null にすると更新日時を見て自動判別する機能
- [feature][Utility] process_async の改善
- [fixbug][Funchand] callable_code で内部の fn に反応してしまう不具合を修正

## 1.5.8

- [tests] 負荷状態によってコケやすいテストに break を付与
- [fixbug][Date] date_timestamp で 1970 以前のミリ秒が逆数になる不具合を修正

## 1.5.6

- [feature][Arrays] iterator_chunk を追加
- [feature][FileSystem] dir_diff を追加
- [feature][FileSystem] file_equals を追加
- [fixbug][FileSystem] file_set_contents で tempnam に対応していないプロトコルに対応
- [feature][FileSystem] file_list に recursive オプションを追加
- [feature][FileSystem] memory_path のディレクトリ対応
- [change][FileSystem] ストリームラッパーと相性が悪いので realpath を normalize に変更
- [fixbug][FileSystem] path_normalize でスキームが吹き飛んでいた不具合を修正
- [feature][Strings] build_uri にオプションを追加
- [fixbug][Strings] build_query が値部分まで書き換えていた不具合を修正
- [fixbug][Strings] parse_uri が配列形式に対応していなかった不具合を修正
- [fixbug][Sql] sql_quote に配列を渡すとエラーが出る不具合を修正
- [fixbug][ClassObj] class_extends で親が void だとシグネチャエラーが発生する不具合を修正

## 1.5.5

- [feature][Vars] var_export3 のアロー関数対応
- [feature][Funchand] 限定的に collable_code のアロー関数対応
- [feature][Syntax] parse_php に greedy オプションを追加
- [fixbug][Syntax] parse_php で nest 内 end が無視されない不具合を修正
- [feature][Arrays] array_pickup のクロージャ対応
- [feature][Arrays] array_filter_map を追加
- [feature][Arrays] array_filters を追加
- [feature][Syntax] chain のバージョン2を追加
- [change][Syntax] optional の NullObject に count,jsonSerialize を実装
- [fixbug][Utility] benchmark で結果が異なるときの表示が見づらかったので修正
- [feature][Date] date_interval_second を追加
- [feature][Date] date_validate を追加
- [feature][Date] date_convert の DateTime 対応
- [fixbug][Date] 1970/01/01 以前の日付で1秒増える不具合を修正
- [fixbug][Date] date_timestamp の不具合を修正
- [fixbug][Date] date_interval の不具合を修正
- [fixbug][Date] date_convert の不具合を修正
- [change][Vars] var_pretty の string 出力を json に変更
- [feature][Vars] is_decimal を追加
- [fixbug][Sql] sql_format のリファクタ && 形式が乱れる不具合を修正
- [feature][Strings] json_import/export テンプレートリテラルのインデント削除に対応
- [feature][Strings] markdown_table の context オプション対応
- [feature][Strings] glob2regex を追加
- [feature][Strings] strtr_escaped を追加
- [feature][Strings] strpos_escaped を追加
- [feature][FileSystem] get_modified_files を追加
- [feature][FileSystem] file_slice を追加
- [feature][Funchand] eval_func の連番引数対応
- [feature][Funchand] is_callback を追加
- [feature][Utility] cache_fetch を追加
- [feature][Utility] ansi_strip を追加

## 1.5.4

- [refactor][Date] date_timestamp の効率が悪かったので改善
- [feature][Date] date_fromto のミリ秒対応
- [feature][Date] date_timestamp の DatetimeInterface 対応
- [fixbug][Date] date_timestamp がタイムゾーンに対応していなかった不具合を修正
- [fixbug][Strings] htmltag が php8.1 で deprecated を出す不具合を修正
- [feature][Arrays] array_find_last を実装
- [feature][Network] cidr の強化

## 1.5.3

- [feature][Strings] json_import の特殊フラグ対応
- [feature][Strings] strpos_quoted に見つかった文字を格納する参照引数を追加
- [feature][Vars] var_pretty に minify オプションを追加
- [feature][Utility] cacheobject に keys/clean メソッドを実装
- [fixbug][Arrays] array_rank が 8.1 で deprecated になる不具合を修正
- [fixbug][FileSystem] rm_rf でリンク先まで消えてしまう不具合を修正

## 1.5.2

- [change][bin] stub 生成を修正
- [feature][Arrays] array_rank を追加
- [feature][Utility] function_configure で様々な挙動を変える機能
- [feature][Syntax] chain の機能改善
- [refactor][Strings] str_common_prefix がO(n^2)になっていたのを改善
- [feature][Strings] str_bytes を追加
- [feature][Strings] json_import のテンプレートリテラル対応
- [fixbug][Strings] css_selector の修正
- [fixbug][Funchand] function_parameter を修正
- [fixbug][Network] http_request の parser でセミコロンを含むときに呼ばれない不具合を修正
- [fixbug][Date] date_alter で $format が引き継がれない不具合を修正

## 1.5.1

- [fixbug][Strings] concat に null が来たときに非推奨エラーになる不具合を修正
- [fixbug] インターフェースが mark as text されてしまう不具合を修正

## 1.5.0

- [*change] php8.1 対応
- [*change] クラスのエクスポート機能を削除
- [*change] 互換性のために残していたコードを削除
- [feature][Arrays] array_revise を追加
- [feature][Arrays] array_find_recursive を追加
- [feature][FileSystem] file_set_tree を追加
- [feature][FileSystem] file_list に相対パスオプションを追加
- [feature][Utility] getenvs/setenvs を追加
- [fixbug][Vars] var_export2 で stdclass を出したときに set_state になっていた不具合を修正
- [fixbug][Classobj] get_object_properties に Closure を与えると意図しない結果になっていた不具合を修正

## 1.4.26

- [change][all] php8.1の暫定対応
- [change][all] 対応バージョンを php7.4 に格上げ
- [feature][Transporter] deprecated が定数にも伝播するように変更
- [feature][Date] date_alter を追加
- [feature][Classobj] class_aliases を追加
- [feature][Classobj] type_exists を追加
- [refactor][Network] getipaddress の改善
- [feature][Math] calculate_formula を追加
- [fixbug][Strings] build_uri/parse_uri に記号を渡すと誤作動する不具合を修正
- [feature][Strings] mb_ellipsis を追加
- [feature][Strings] mb_str_pad を追加
- [feature][Strings] str_common_prefix を追加
- [refactor][Strings] json_import の実装を変更
- [feature][Strings] json_export の json5 対応とオプションを追加
- [feature][Arrays] array_append/prepend を追加
- [fixbug][FileSystem] file_get_arrays で知らないエンコーディングが来たらエラーになる不具合を修正
- [feature][Vars] flagval を追加
- [fixbug][Vars] var_pretty でリストが{}で出力される不具合を修正
- [change][bin/exclude-internal] .idea がない表示は行わない

## 1.4.25

- [feature][FileSystem] file_get_arrays を追加
- [feature][Utility] process_parallel を追加
- [feature][Utility] process_async を追加
- [feature][Classobj] auto_loader を追加
- [feature][Vars] var_hash を追加
- [feature][Arrays] array_random を追加
- [feature][Arrays] array_map_recursive に自身にも適用する引数を追加
- [feature][Arrays] array_count に再帰フラグを追加
- [feature][Strings] csv_export/import の配列対応
- [fixbug][Utility] parse_namespace の不具合を修正
- [fixbug][Date] date_convert に小数部が0の数値文字列を与えると即死する不具合を修正
- [fixbug][Syntax] parse_php でオプション次第ではキャッシュが効かない不具合を修正

## 1.4.24

- [fixbug][Sql] sql_format で WITH があるとインデントが乱れる不具合を修正
- [refactor][Strings] str_diff のリファクタ
- [change][Vars] encrypt のバージョンアップ
- [feature][Arrays] array_extend を追加
- [feature][Classobj] class_replace の無名クラス対応
- [feature][Classobj] class_extends に implements 引数を追加
- [change][Utility] cacheobject の仕様変更
- [change][Network] http_request(s) の仕様変更

## 1.4.23

- [fixbug][all] 必要のないところで arrayval を再帰的に行っていた不具合を修正
- [feature][FileSystem] path_parse を追加
- [fixbug][FileSystem] path_normalize に "/" "./" などを与えると空文字になる不具合を修正
- [feature][FileSystem] file_pos の配列対応
- [fixbug][FileSystem] path_resolve の型引数が誤っていたので修正
- [fixbug][Utility] arguments で thrown と複数短縮オプションでオプションが得られない不具合を修正

## 1.4.22

- [feature][Strings] markdown_table にオプション引数を導入
- [fixbug][Utility] arguments で空白があるだけで空短縮オプションになってしまう不具合を修正
- [feature][Vars] var_export3 の無名クラス対応
- [feature][Classobj] get_object_properties の無名クラス対応
- [change][FileSystem] path_resolve の $PATH 対応
- [fixbug][FileSystem] file_tree で空ディレクトリがあると notice が出ていた不具合を修正
- [fixbug][Funchand] callable_code で同一行に複数定義がある場合に間違った結果を返す不具合を修正

## 1.4.21

- [fixbug][Vars] var_export3 のクロージャ出力の不具合を修正
- [change][Vars] encrypt/decrypt のバージョニング
- [change][Vars] var_pretty の仕様変更
- [feature][Vars] var_stream を追加
- [feature][Utility] parse_annotation の改行対応

## 1.4.19

- [all] support php8
- [Sql] 特定の SQL で妙なインデントが生まれる不具合を修正
- [Strings] html_attr を追加
- [Strings] html_strip で必要な空白まで消えてしまう不具合を修正
- [Syntax] strip_php の第2引数をオプション化
- [Network] ping の不具合を修正

## 1.4.18

- [feature][Funchand] ope_func に new/clone を追加
- [feature][Arrays] array_group のキー対応
- [feature][Classobj] reflect_types 修正

## 1.4.17

- [feature][Classobj] reflect_types を追加
- [feature][FileSystem] file_pos の負数の位置指定が聞いていない不具合を修正
- [feature][Vars] attr_get が例外を投げる不具合を修正
- [feature][Vars] phpval を追加
- [feature][Strings] build_query/parse_query を追加
- [feature][Strings] render_template を追加
- [feature][Strings] html_strip を追加
- [feature][Strings] unique_string を追加
- [feature][Strings] json_import の json5 対応
- [feature][Syntax] strip_php を追加
- [feature][Syntax] parse_php に phtml と short_open_tag オプションを追加
- [feature][Utility] benchmark で opcache が使われないことがある不具合を修正

## 1.4.16

- [feature][Arrays] array_lookup のクロージャ対応
- [refactor][Arrays] last_keyvalue を高速化
- [feature][Utility] cacheobject を追加
- [feature][Syntax] 行や桁の範囲を指定するオプションを実装
- [feature][Funchand] namedcallize の内部クラスとコンストラクタ対応
- [feature][Strings] paml の不具合修正と機能改善
- [feature][Classobj] const_exists の class 対応
- [fixbug][Classobj] class_extends の参照渡しに対応
- [change][Strings] php8 の標準関数と被ったので str_contains を str_exists にリネーム

## 1.4.15

- [feature][FileSystem] file_matcher の追加と file_(list|tree) の修正
- [feature][Date] date_timestamp のベースなし相対表記に対応
- [feature][Funchand] parameter_wiring の数値指定と順番の規約
- [feature][Vars] var_export3 を追加
- [feature][Vars] encrypt/decrypt を追加
- [feature][Syntax] indent_php で基準行の指定に対応
- [feature][Syntax] parse_php で行と桁に対応
- [fixbug][Classobj] const_exists で存在しないクラスを指定すると死ぬ不具合を修正
- [fixbug][Classobj] get_object_properties で内部クラスのプロパティが取れない不具合を修正
- [feature][Math] decimal を追加

## 1.4.14

- support php7.4
- [fixbug] Revert "[Strings] preg_splice の limit 対応"

## 1.4.13

- [feature][Utility] number_serial を追加
- [fixbug][Classobj] get_class_constants が php 7.4 で動かなかったので修正
- [feature][Arrays] array_schema を追加
- [feature][Arrays] array_maps の可変引数呼び出し対応
- [fixbug][Vars] varcmp の不具合修正と新機能

## 1.4.12

- [change][Vars] var_pretty の仕様変更
- [fixbug][FileSystem] rm_rf に glob を渡せるように変更
- [fixbug][FileSystem] file_mimetype を追加
- [change][Network] http_head の返り値をヘッダに変更
- [change][Strings] preg_splice の limit 対応
- [change][Arrays] コールバック関数に連番が渡ってくるように変更

## 1.4.11

- [fixbug][Date] date_convert で DateTimeInterface の対応が漏れていたので修正
- [fixbug][Utility] profiler が誤作動する不具合を修正

## 1.4.10

- [feature][FileSystem] path_relative を追加
- [fixbug][Vars] var_pretty で空配列が [null] になる不具合を修正
- [feature][Utility] process の proc_open の配列対応
- [fixbug][Utility] php7.4 で profiler が動かなかったので修正

## 1.4.9

- [feature][Strings] css_selector を追加
- [feature][Sql] sql_format で when ～ then の複合条件が見づらかったのを修正
- [feature][Strings] paml_import に {} を配列とみなすオプションを追加
- [feature][Vars] var_pretty のオプション化と最大制限を追加

## 1.4.8

- [feature][Strings] csv_export のヘッダなしに対応
- [feature][Funchand] ope_func にオペランド引数を追加

## 1.4.7

- [feature][Strings] str_guess の配列返し対応
- [feature][Syntax] chain で型に応じて呼ぶ関数を分岐するように変更
- [feature][Funchand] parameter_wiring/func_wiring を追加

## 1.4.6

- [feature][Funchand] parameter_default を追加
- [feature][Vars] attr_exists/attr_get を追加
- [feature][Arrays] array_select を追加
- [feature][Arrays] array_rekey のコールバック対応
- [feature][Arrays] array_where のシンプルクロージャの対応と自身引数の追加
- [feature][Arrays] array_merge2 を追加
- [feature][Arrays] array_put に追加条件引数を追加
- [fixbug][Utility] profiler で正規表現フィルタが働いていない不具合を修正
- [fixbug][Arrays] arrayize で連番キーが死んでしまう不具合を修正

## 1.4.5

- [feature][composer] export-function と exclude-internal コマンドを用意
- [feature][Strings] str_chunk を追加
- [feature][Utility] profiler を追加
- [feature][Arrays] array_flatten のクロージャ対応
- [feature][Network] http_request を追加
- [feature][FileSystem] file_pos を追加
- [fixbug][Sql] sql_quote でエスケープシーケンスの扱いがおかしかった不具合を修正

## 1.4.4

- [feature][Arrays] array_kvmap を追加
- [feature][Date] date_fromto を追加
- [feature][Syntax] indent_php を追加
- [feature][Utility] parse_annotation の複数行対応

## 1.4.3

- [feature][Syntax] try_return を追加
- [feature][Strings] preg_matches を追加

## 1.4.2

- [feature][Arrays] array_aggregate を追加
- [feature][Utility] parse_annotation を追加
- [feature][Utility] resolve_symbol を追加
- [feature][Utility] parse_namespace を追加
- [feature][Strings] str_diff を追加
- [feature][Strings] strpos_quoted を追加
- [feature][Strings] strpos_array を追加
- [feature][Syntax] highlight_php を追加
- [fixbug][Syntax] parse_php で連番が崩れていた不具合を修正
- [fixbug][Vars] var_export2 で $ がエスケープされない不具合を修正
- [fixbug][Sql] sql_format の不具合を修正
- [change][Vars] var_pretty のスタックトレースを逆順に変更

## 1.4.1

- [change][all] 対応バージョンを php7.2 に変更
- [fixbug][Syntax] blank_if で 0.0 が空扱いになっていた不具合を修正
- [feature][Vars] var_type に $valid_name 引数を追加
- [feature][Vars] si接頭辞を定数に逃がしてマイクロ（u）に対応
- [feature][Utility] process のリソース型対応
- [change][Sql] sql_format を修正
  - 特定条件においてコメントが吹き飛ぶ不具合を修正
  - SELECT オプションは SELECT と同レベルに置く
  - 関数コールではない数式のカッコはネストしないように変更

## 1.4.0

- [*change] 使用頻度の低い関数を削除
  - [Arrays] array_filter_not: not_func 呼び出し時で十分
  - [Arrays] array_filter_eval: eval_func 呼び出し時で十分
  - [Funchand] composite: クロージャで十分
  - [Funchand] return_arg: 普通にベタ書きで十分
  - [Funchand] closurize: Closure::fromCallable で十分
  - [Syntax] returns: 即時 new とか clone 用だったがもはや不要
  - [Syntax] ifelse: ?? や blank_if で十分
  - [Vars] is_iterable: php 7.1 にそのものズバリがあるので不要
- [*change][Vars] is_iterable を削除
- [*change][Funchand] delegate の内部実装を変更
- [change][Arrays] array_lookup の内部実装を変更

## 1.3.11

- [feature][Arrays] array_map_key の値対応
- [fixbug][Arrays] array_filter_key で標準関数を呼ぶとエラーになることがある不具合を修正
- [change][Strings] quoteexplode の limit 対応
- [feature][Strings] paml_export/paml_import を追加
- [feature][Classobj] get_class_constants を追加
- [feature][Classobj] class_uses_all を追加
- [feature][Funchand] callable_code のリフレクション対応
- [feature][Vars] arrayable_key_exists を追加

## 1.3.10

- [feature] php7.3 対応
- [feature][Vars] si_prefix のクロージャ対応
- [feature][FileSystem] dirmtime を追加

## 1.3.9

- [feature][Utility] add_error_handler を追加
- [fixbug][Utility] cachedir が競合する不具合を修正
- [fixbug][Classobj] class_replace で常に保存されていた不具合を修正

## 1.3.8

- [feature][Strings] strrstr を追加
- [feature][Classobj] class_replace のオーバーライド対応
- [feature][Classobj] class_extends のオーバーライド対応
- [feature][Funchand] function_parameter の型宣言対応

## 1.3.7

- [feature][Arrays] array_explode を追加
- [feature][Arrays] array_flatten の Iterator 対応
- [change][Arrays] array_add の第一引数が必須になっていたので修正
- [feature][Arrays] array_where で配列 OR に対応
- [feature][Classobj] class_replace の trait 対応
- [feature][Date] date_convert の DateTime 対応
- [change][FileSystem] file_set_contest の相対パス対応とアトミック化
- [feature][FileSystem] path_is_absolute のスキーム対応
- [feature][Sql] sql_format の mysql ユーザ変数対応
- [feature][Syntax] call_if を追加
- [feature][Syntax] chain の遅延引数モードを追加
- [change][Utility] error の完全デフォルトを STDERR に変更
- [feature][Vars] var_type の無名クラス対応
- [change][Transporter] 必要なときのみ定数が定義されるように変更
- [feature][Transporter] exportClass を追加

## 1.3.6

- [change][Vars] var_pretty で return 時はスタックトレースを出さないように変更
- [feature][Utility] backtrace に offset オプションを追加
- [feature][Strings] ltsv_import/ltsv_export を追加
- [feature][Strings] mb_trim を追加

## 1.3.5

- [feature][Math] normal_rand を追加
- [feature][Math] clamp を追加
- [feature][Funchand] abind を追加
- [feature][Arrays] array_fill_gap を追加
- [feature][Arrays] array_rekey を追加
- [feature][Strings] str_anyof を追加
- [feature][Strings] str_embed を追加
- [feature][Strings] ngram を追加
- [change][Strings] str_guess の内部実装を変更
- [feature][Syntax] blank_if を追加
- [fixbug][Sql] sql_bind でクオートやコメント内でも埋め込まれてしまう不具合を修正
- [feature][Vars] is_empty の空 stdClass 対応
- [feature][Utility] stacktrace にオプションを追加
  - 引数包含オプション
  - デリミタオプション
  - 機密マスクオプション
- [feature][Transporter] ファイル内で使用している関数の出力機能

## 1.3.4

- [fixbug][Classobj] get_object_properties で親の private フィールドが含まれていない不具合を修正
- [feature][Utility] is_ansi を追加
- [feature][Utility] ansi_colorize を追加
- [feature][Vars] var_pretty を追加
- [feature][Vars] varcmp の SORT_STRICT 対応
- [fixbug][Arrays] array_strpad で値関係を指定していないのに処理が走る不具合を修正
- [feature][Arrays] array_distinct を追加
- [feature][Network] ping を追加
- [change][Transporter] グローバル側で定数が重複する可能性があるので if を追加

## 1.3.3

- [feature][Syntax] evaluate を追加

## 1.3.2

- [feature][Date] date_convert を追加
- [feature][Date] date_timestamp を追加
- [feature][Funchand] func_method のコンストラクタ対応
- [feature][Funchand] func_new を追加
- [feature][Syntax] try_null を追加
- [feature][Arrays] is_indexarray を追加
- [fixbug][Syntax] parse_php で cache: false を指定しても溜め込まれる不具合を修正
  - false を指定しても溜め込まれていた

## 1.3.1

- [feature][Arrays] array_pickup の $keys が配列しか受け付けていなかったのを修正
- [feature][Arrays] array_remove を追加
- [feature][Syntax] evaluate を追加
- [feature][Funchand] function_parameter を追加
- [feature][Classobj] class_extends を追加
- [feature][Classobj] const_exists を追加
- [fixbug][Classobj] class_replace でロックが掛かっていなかったので修正
- [refactor][Classobj] class_loader の内部実装を変更

## 1.3.0

- [*change] 対応バージョンを php 7.1 に格上げ
- [*change][all] empty より is_empty のほうがふさわしい箇所を変更
- [*change][all] キャッシュの仕様を変更
  - 変な依存が気持ち悪いので無名クラスで実装し直した
  - デフォルト設定をキャッシュを使う方向に寄せた
- [*change][Arrays] array_unset でキーに配列を与えた場合の未指定デフォルト値は空配列にする
- [*change][Vars] is_empty の $countable_object 引数を削除
- [*change][Vars] si_prefix の互換性コードを削除
- [*change][Vars] var_export2 で出力のみ改行を出すように変更
- [change][Funchand] closurize をネイティブ呼び出しに変更
- [refactor][all] 7.1 から iterable 疑似型が使えるので使用する
- [feature][Transporter] エクスポート時に(定数)呼び出しを単純化するように変更

## 1.2.10

- [feature][FileSystem] file_suffix を追加
- [feature][FileSystem] memory_path を追加
- [feature][Strings] ob_include/include_string を追加
- [feature][Strings] csv 関係の修正
  - 入出力両方でコールバックを指定できるように修正
  - csv_export で出力リソースを指定できるように修正
  - csv_import でヘッダ読み換えができるように修正
- [feature][Strings] str_submap を追加
- [fixbug][Strings] str_subreplace を修正
  - $case_insensitivity の時に負数を指定すると例外が飛ぶ不具合を修正
  - 見つからない場合にも例外が飛んでいた不具合を修正

## 1.2.9

- [feature][Strings] str_ellipsis を追加
- [feature][Strings] str_array を追加
- [feature][Strings] mb_substr_replace を追加
- [feature][Strings] markdown_list を追加
- [feature][Strings] namespace_split を追加
- [feature][Arrays] array_pos_key を追加
- [feature][Arrays] array_map_recursive を追加
- [feature][Syntax] switchs を追加
- [feature][Utility] date_interval を追加
- [feature][Utility] arguments でオプション的文字列を引数として扱えるオプションを追加
- [fixbug][Utility] stacktrace で引数が取れていなかった&&文字列がおかしかった不具合を修正
- [feature][Network] http_requests でデフォルトオプションを指定できるように修正
- [feature][Transporter] exportNamespace で関数指定を実装

## 1.2.8

- [feature][Transporter] 定数の doccomment 出力に対応
- [refactor][Transporter] 出力表現を変更
- [refactor][Vars] var_export2 の内部処理を変更
- [fixbug][Strings] json_import が 7.0 に対応していなかったので修正

## 1.2.7

- [feature][Strings] markdown_table を追加
- [feature][Strings] htmltag を追加
- [feature][Strings] str_guess を追加
- [feature][Strings] damerau_levenshtein を追加
- [feature][Strings] ini_import/ini_export を追加
- [feature][Strings] csv_import/csv_export を追加
- [feature][Strings] json_import/json_export を追加
- [feature][Funchand] namedcallize を追加
- [fixbug][Sql] sql_format で特殊構文で改行がなされない不具合を修正
- [fixbug][Strings] multiexplode で複数デリミタ＋負数を与えると文字列が変わってしまう不具合を修正
- [change][Vars] var_export2 の文字列表現をダブルクオートに変更
  - php としては壊れていない
- [change][Funchand] ope_func の仕様変更
  - 引数が減った。減る方向なので互換性は壊れていない

## 1.2.6

- [feature][Arrays] arrays を追加
- [feature][Arrays] array_where で連想配列を渡すと個別でANDできるようになった
- [change][Arrays] array_difference にただの配列を渡すと Warning が出る不具合を修正
- [feature][Strings] quoteexplode の複数分割文字対応
- [feature][Network] getipaddress を追加
- [feature][Network] incidr を追加
- [fixbug][Syntax] chain で内部関数が呼べなかった不具合を修正
- [fixbug][Utility] arguments のエスケープ対応

## 1.2.5

- [feature][Arrays] array_put を追加
- [feature][Arrays] array_zip の iterable 対応
- [feature][Arrays] array_depth の最大指定
- [feature][Strings] preg_replaces を追加
- [feature][Syntax] parse_php を追加
- [feature][Vars] console_log を追加
- [feature][Funchand] callable_code を追加
- [feature][Funchand] func_method を追加
- [feature][Classobj] class_replace の配列対応
- [feature][Network] http_requests を追加
- [feature][Sql] sql_quote を追加
- [feature][Sql] sql_bind を追加
- [feature][Sql] sql_format を追加
- [change][FileCache] クリアするファイル種別を指定
- [change][All] 定数も出力するように変更

## 1.2.4

- [refactor][All] php7.2 でテストがコケていたので修正
- [feature][FileSystem] file_rewrite_contents を追加
- [feature][Strings] str_chop を追加
- [feature][Arrays] array_zip を追加
- [feature][Arrays] array_cross を追加
- [feature][Arrays] array_fill_callback を追加
- [fixbug][Funchand] eval_func が激遅だった不具合を修正
- [change][Vars] is_empry の仕様を変更
  - countable object で count() > 0 なら false を返せるようになった（当面はフラグで互換性維持）

## 1.2.3

- [feature][Strings] starts_with/ends_with の配列対応
- [feature][Utility] stacktrace を追加
- [feature][Vars] si_prefix の単位指定対応
- [feature][Vars] si_unprefix を追加
- [feature][Funchand] ope_func を追加
- [feature][Syntax] chain を追加

## 1.2.2

- [feature][Utility] backtrace を追加
- [feature][Vars] is_stringable を追加
- [feature][Vars] is_arrayable を追加
- [feature][Classobj] object_dive を追加
- [feature][Funchand] is_bindable_closure を追加
- [feature][Arrays] array_pickup のキー読み替え対応
- [feature][Arrays] array_difference を追加
- [fixbug][Arrays] array_keys_exist で値が null だと false を返す不具合を修正
- [fixbug][Arrays] array_dive で配列以外が来ると notice が出る不具合を修正
- [fixbug][Arrays] 一部の関数が ArrayAccess で動作しない不具合を修正
- [fixbug][Arrays] array_maps でメソッドの後の普通のコールバックが誤作動する不具合を修正

## 1.2.1

- [feature][Arrays] array_pickup を追加
- [feature][Strings] parse_uri を追加
- [feature][Strings] build_uri を追加
- [feature][Vars] si_prefix を追加
- [fixbug][Arrays] array_shrink_key のオブジェクト対応
- [fixbug][Utility] benchmark の平均時間が1000倍されていた不具合を修正
- [fixbug][Vars] arrayval が recursive で挙動が違う不具合を修正

## 1.2.0

- [*change] php 7.0 未満を切り捨て
- [*change] パッケージ・phar のサポートを廃止（すべてシンプルな関数として利用する）

## 1.1.7

- [feature][Utility] process を追加
- [feature][Utility] get_uploaded_files を追加
- [change][Vars] var_html の表示形式を変更
- [feature][Classobj] get_object_properties を追加
- [feature][Arrays] array_mix を追加
- [feature][Arrays] array_kmap を追加
- [feature][Arrays] array_get のクロージャ対応
- [feature][Arrays] array_sprintf の $format 省略（vsprintf）に対応
- [feature][Arrays] array_each の callback に第3引数（0からの連番）を追加

## 1.1.6

- [feature][Vars] varcmp を追加
- [feature][Vars] var_apply/var_applys を追加
- [feature][Vars] numval を追加
- [feature][Vars] arrayval を追加
- [feature][Funchand] func_user_func_array を高速化
- [feature][Arrays] kvsort を追加
- [feature][Arrays] array_unset のクロージャ対応
- [feature][Utility] arguments を追加
- [feature][Utility] timer を追加
- [fixbug][Utility] benchmark の参照渡し対応

## 1.1.5

- [feature][Syntax] throw_if を追加
- [feature][Arrays] array_keys_exists を追加
- [feature][Arrays] array_each の第3引数を省略した場合の自動検出
- [feature][Strings] concat を追加
- [feature][Vars] is_empty を追加
- [feature][Transporter] オールインワン吐き出し機能の実装
- [fixbug][Transporter] デフォルト値の出力がおかしかった不具合を修正

## 1.1.4

- [feature][FileSystem] fnmatch_and/or を追加
- [feature][Strings] quoteexplode を追加
- [change][Strings] str_subreplace で非配列引数を受け入れられるように変更
- [change][Strings] random_string で random_compat を使うように変更

## 1.1.3

- [fixbug][Strings] str_between を修正
- [feature][Arrays] array_each を追加
- [feature][Funchand] by_builtin を追加
- [feature][Strings] preg_splice を追加
- [feature][Strings] multiexplode を追加
- [feature][Strings] str_putcsv の複数行対応
- [feature][Vars] is_iterable を追加
- [feature][Vars] is_countable を追加
- [feature][Transporter] polyfill で組み込み関数のチェックを無効化できるように変更

## 1.1.2

- [feature][Utility] error を追加

## 1.1.1

- [change][ClassObj] detect_namespace がファイル名を受けられるように修正
- [fixbug][FileSystem] file_tree が特定条件下でエラーを吐いていたので修正
- [feature][FileSystem] cp_rf を追加
- [fixbug][Vars] var_export2 でネストされた null が "NULL" になっていたのを修正
- [fixbug][Transporter] package エクスポートのパッケージ名が異なっていたので修正
- [feature][Transporter] phar 吐き出し機能の実装

## 1.1.0

- [*change] 対応バージョンを 5.6 以降に変更
- [*change] クラスベースに変更
- [feature] クラスごとエクスポートに対応
- [*change] 読み込みクラスを Transporter にリネーム
- [*change][Classobj] has_class_methods を削除
- [feature][Classobj] detect_namespace を追加
- [feature][Strings] str_subreplace を追加
- [feature][Strings] str_between を追加
- [feature][Vars] numberify を追加
- [feature][Vars] var_type を追加
- [fixbug][Vars] var_export2 の位置合わせを修正
- [feature][FileSystem] dirname_r を追加
- [feature][FileSystem] path_normalize を追加
- [feature][FileSystem] path_resolve を追加
- [feature][FileSystem] path_is_absolute を追加
- [feature][Syntax] try_finally を追加
- [change][Syntax] try_* 系の引数を指定可能に変更
- [feature][Arrays] array_set の配列対応
- [feature][Arrays] array_strpad を追加
- [feature][Arrays] array_sprintf を追加
- [feature][Arrays] array_implode を追加
- [feature][Arrays] array_shuffle を追加
- [feature][Arrays] array_maps を追加
- [feature][Arrays] array_find を追加
- [feature][Arrays] in_array_and を追加
- [feature][Arrays] in_array_or を追加
- [change][Arrays] array_exists を deprecated
- [feature][Utility] cache のキャッシュ削除機能を追加
- [feature][Math] Math を追加
  - minimun
  - maximum
  - mode
  - mean
  - median
  - average
  - sum
  - random_at
  - probability
- [*change][Arrays] array_convert のコールバック引数を変更
  - キー, 値, 元配列, 大本配列 -> キー, 値, 今まで処理したキー配列

## 1.0.8

- [feature][FileCache] umask 次第では自分以外読めないファイルが出来上がるので chmod を設定

## 1.0.7

- [feature][strings] preg_capture 追加
- [feature][funchand] function_alias 追加
- [feature][syntax] optional に第2引数追加
- [fixbug][syntax] optional が export 時に動かない不具合を修正

## 1.0.6

- [refactor] 定義済み関数をスキップするように変更
- [refactor] 名前空間 export した場合はキャッシュが無効になるように変更
- [change][classobj] has_class_methods を deprecated にした
- [feature][array] array_nest 追加
- [feature][array] array_count 追加
- [feature][strings] str_putcsv 追加
- [feature][filesystem] tmpname 追加
- [feature][funchand] composite 追加
- [fixbug][funchand] call_safely で@付きの場合は例外を投げないように修正
- [feature][utility] cache 追加
- [*change][utility] benchmark を修正
  - 引数順と出力形態を変更
  - 互換性破壊だが運用で使う関数ではないのでバージョンは上げない

## 1.0.5

- [feature][syntax] ifelse 追加
- [feature][funchand] delegate 追加
- [fixbug][funchand] nbind の引数数問題修正
- [feature][classobj] stdclass 追加
- [feature][array] array_lookup 追加
- [*change][array] array_get で配列を与えたときの結果順序を変更
- [change][array] array_group の階層化に対応
- [feature][array] array_dive の配列対応
- [feature][array] array_set に第4引数を追加
- [feature][array] array_flatten 追加
- [feature][var] var_html 追加
- [feature][var] is_recursive 追加
- [*fixbug][var] var_export2 の不具合を修正
  - 再帰構造を渡すと無限ループになっていた
  - 「スカラー値のみなら」が「スカラー値を含むなら」になっていた
  - オブジェクトの private フィールドがヌル文字付きで出力されていた

## 1.0.4

- [feature][array] array_of 追加
- [feature][array] array_all 追加
- [feature][array] array_any 追加
- [feature][array] array_group 追加
- [feature][array] array_convert 追加
- [feature][array] prev_key 追加
- [feature][array] next_key 追加
- [feature][array] array_order のキー対応
- [feature][var] stringify 追加
- [feature][funchand] func_user_func_array 追加
- [feature][funchand] call_safely 追加
- [feature][funchand] ob_capture 追加
- [feature][funchand] return_arg 追加
- [feature][filesystem] mkdir_p 追加
- [feature][filesystem] file_list 追加
- [feature][filesystem] file_tree 追加
- [feature][utility] benchmark 追加
- [fixbug][classobj] class_loader でうまく発見できない不具合を修正
- [fixbug][classobj] class_replace でクラス名がおかしくなる不具合を修正
- [fixbug][funchand] reflect_callable がスコープを見ていた不具合を修正

## 1.0.3

- [feature][strings] str_contains 追加
- [feature][funchand] not_func 追加
- [feature][funchand] eval_func 追加
- [feature][array] array_where 追加
- [change][array] array_get の配列対応
- [*change][array] array_insert のキー対応

## 1.0.2

- [feature][array] array_set 追加
- [feature][array] array_add 追加
- [feature][syntax] optional 追加

## 1.0.1

- [change][array] array_unset の複数対応
- [feature][array] array_order 追加
- [feature][array] array_shrink_key 追加
- [feature][var] is_primitive 追加
- [*change][array] $default を与えないと例外を飛ばす仕様を廃止
  - 「例外が飛ばなくなった」方向なのでバージョンは上げない

## 1.0.0

- 公開
