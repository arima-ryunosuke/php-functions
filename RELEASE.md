# RELEASE

- change: 仕様変更
- feature: 新機能
- fixbug: バグ修正
- refactor: 内部動作の変更
- `*` 付きは互換性破壊

## x.y.z

- no todo

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
