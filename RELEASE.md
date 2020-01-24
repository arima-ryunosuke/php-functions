# RELEASE

- change: 仕様変更
- feature: 新機能
- fixbug: バグ修正
- refactor: 内部動作の変更
- `*` 付きは互換性破壊

## x.y.z

- Utility が増えてきたから然るべき場所へ移動する

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
