<?php

namespace ryunosuke\Test\Package;

class SqlTest extends AbstractTestCase
{
    function test_sql_quote()
    {
        that((sql_quote)(null))->is('NULL');
        that((sql_quote)(false))->is('0');
        that((sql_quote)(true))->is('1');
        that((sql_quote)(123))->is('123');
        that((sql_quote)(1.23))->is('1.23');
        that((sql_quote)('123'))->is('123');
        that((sql_quote)('1.23'))->is('1.23');
        that((sql_quote)('hoge'))->is("'hoge'");
        that((sql_quote)("ho'ge"))->is("'ho\'ge'");
        that((sql_quote)('ho"ge'))->is("'ho\"ge'");
        that((sql_quote)("ho\r\n\tge"))->is("'ho\\r\\n\\tge'");
    }

    function test_sql_bind()
    {
        that((sql_bind)('select ?', 1))->is('select 1');
        that((sql_bind)('select ?, ?', [1, 2]))->is('select 1, 2');
        that((sql_bind)('select :name', ['name' => 1]))->is('select 1');
        that((sql_bind)('select ":name", :name, :name', ['name' => 1]))->is('select ":name", 1, 1');
        that((sql_bind)('select ?, :hoge, ?, :fuga', [1, 2, 'hoge' => 3, 'fuga' => 4]))->is('select 1, 3, 2, 4');
        that((sql_bind)('select ?, :hoge, ?, :fuga', ['a', 'b', 'hoge' => 'c', 'fuga' => 'd']))->is("select 'a', 'c', 'b', 'd'");
        that((sql_bind)("select /* this is comment? */ '?'
-- this is :comment
?, :comment
", ['a', 'comment' => 'b']))->is("select /* this is comment? */ '?'
-- this is :comment
'a', 'b'
");
    }

    function test_sql_format_create()
    {
        that((sql_format)('
CREATE TABLE t_table (
  id   INT(10) UNSIGNED NOT NULL COMMENT "primary",
  name VARCHAR(32)      NOT NULL COMMENT "table_name" COLLATE "utf8_bin",
  PRIMARY KEY (id),
  INDEX idx_name (name),
  CONSTRAINT fk_name FOREIGN KEY (name) REFERENCES t_other (other_name) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT="TableComment"
COLLATE="utf8_bin"
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC
'))->IsEqualTrimming('
CREATE TABLE t_table (
  id INT(10) UNSIGNED NOT NULL COMMENT "primary",
  name VARCHAR(32) NOT NULL COMMENT "table_name" COLLATE "utf8_bin",
  PRIMARY KEY(id),
  INDEX idx_name(name),
  CONSTRAINT fk_name FOREIGN KEY(name) REFERENCES t_other(other_name) ON UPDATE CASCADE ON DELETE CASCADE 
) COMMENT = "TableComment" COLLATE = "utf8_bin" ENGINE = InnoDB ROW_FORMAT = DYNAMIC
');

        that((sql_format)('CREATE TABLE IF NOT EXISTS t_table (id INT(10) UNSIGNED NOT NULL COMMENT "primary")'))->IsEqualTrimming('
CREATE TABLE IF NOT EXISTS t_table(
  id INT(10) UNSIGNED NOT NULL COMMENT "primary" 
)
');

        that((sql_format)('CREATE INDEX part_of_name ON customer (name, id)'))->IsEqualTrimming('
CREATE INDEX part_of_name ON customer(name, id)
');
    }

    function test_sql_format_drop()
    {
        that((sql_format)('drop table tbl'))->IsEqualTrimming('
drop table tbl
');

        that((sql_format)('drop table IF EXISTS  tbl'))->IsEqualTrimming('
drop table IF EXISTS tbl
');
    }

    function test_sql_format_alter()
    {
        that((sql_format)('ALTER TABLE TABLE_NAME
  ADD COLUMN colA INT(11)  NULL DEFAULT NULL COMMENT "comment1" AFTER hoge,
  ADD COLUMN colB DATETIME NULL DEFAULT NULL COMMENT "comment2" AFTER fuga,
  DROP COLUMN colC,
  CHANGE COLUMN colD colD TINYINT(1) DEFAULT 0 NOT NULL COMMENT "comment4",
  ADD INDEX idx_name(name),
  add CONSTRAINT fk_name FOREIGN KEY (name) REFERENCES t_other (other_name) ON UPDATE CASCADE ON DELETE CASCADE
'))->IsEqualTrimming('
ALTER TABLE TABLE_NAME 
  ADD COLUMN colA INT(11) NULL DEFAULT NULL COMMENT "comment1" AFTER hoge,
  ADD COLUMN colB DATETIME NULL DEFAULT NULL COMMENT "comment2" AFTER fuga,
  DROP COLUMN colC,
  CHANGE COLUMN colD colD TINYINT(1) DEFAULT 0 NOT NULL COMMENT "comment4",
  ADD INDEX idx_name(name),
  add CONSTRAINT fk_name FOREIGN KEY(name) REFERENCES t_other(other_name) ON UPDATE CASCADE ON DELETE CASCADE
');
    }

    function test_sql_format_select()
    {
        // select
        that((sql_format)('select
    T.*,
    exists(select * from t_sub S where (S.id = T.id)) as e,
    greatest(ifnull(a, 9), ifnull(b, 9)) as g
  from (select * from t_table where (status = "active")) T
  left outer join t_join1 on t_join1.id = t_table.id
  right join t_join2 on t_join2.id = (select max(id) from t_sub where (A and B))
  inner join t_join3 using (id)
  where (a and (b and (c and (d in (1,2,3)))))
  group by id having count(misc) > 10 order by id desc limit 10 offset 5'))->IsEqualTrimming('
select
  T.*,
  exists(
    select
      * 
    from
      t_sub S 
    where
      (S.id = T.id)
  ) as e,
  greatest(
    ifnull(a, 9),
    ifnull(b, 9)
  ) as g 
from
  (
    select
      * 
    from
      t_table 
    where
      (status = "active")
  ) T 
left outer join
  t_join1 on t_join1.id = t_table.id 
right join
  t_join2 on t_join2.id = (
    select
      max(id)
    from
      t_sub 
    where
      (A and B)
  )
inner join
  t_join3 using(id)
where
  (
    a 
    and (
      b 
      and (
        c 
        and (d in(1, 2, 3))
      )
    )
  )
group by
  id 
having
  count(misc) > 10 
order by
  id desc 
limit
  10 
offset
  5
');

        // for update
        that((sql_format)('select * from t_table for update'))->IsEqualTrimming('
select
  * 
from
  t_table 
for update
');

        // lock in share mode
        that((sql_format)('select * from t_table lock in share mode'))->IsEqualTrimming('
select
  * 
from
  t_table 
lock in share mode
');

        // select option
        that((sql_format)('select distinct straight_join t.a, t.b from table t'))->IsEqualTrimming('
select distinct straight_join 
  t.a,
  t.b 
from
  table t
');
    }

    function test_sql_format_insert()
    {
        // insert
        that((sql_format)('insert into t_table (a,b,c) values (1,2,3), (4,5,6)'))->IsEqualTrimming('
insert into
  t_table(a, b, c)
values
  (1, 2, 3),
  (4, 5, 6)
');

        // insert set
        that((sql_format)('insert into t_table set a=1, b=2, c=3'))->IsEqualTrimming('
insert into
  t_table 
set
  a = 1,
  b = 2,
  c = 3
');

        // insert select
        that((sql_format)('insert into t_table (a,b,c) select a,b,c from t_table2 T2'))->IsEqualTrimming('
insert into
  t_table(a, b, c)
select
  a,
  b,
  c 
from
  t_table2 T2
');

        // insert duplicate key
        that((sql_format)('insert OPTIONS into t_table set a=1, b=2, c=3 on duplicate key update x=values(a)'))->IsEqualTrimming('
insert OPTIONS into
  t_table 
set
  a = 1,
  b = 2,
  c = 3 
on duplicate key update
  x = values(a)
');
    }

    function test_sql_format_replace()
    {
        // insert
        that((sql_format)('replace into t_table (a,b,c) values (1,2,3), (4,5,6)'))->IsEqualTrimming('
replace into
  t_table(a, b, c)
values
  (1, 2, 3),
  (4, 5, 6)
');

        // insert set
        that((sql_format)('replace into t_table set a=1, b=2, c=3'))->IsEqualTrimming('
replace into
  t_table 
set
  a = 1,
  b = 2,
  c = 3
');

        // insert select
        that((sql_format)('replace into t_table (a,b,c) select a,b,c from t_table2 T2'))->IsEqualTrimming('
replace into
  t_table(a, b, c)
select
  a,
  b,
  c 
from
  t_table2 T2
');

        // insert duplicate key
        that((sql_format)('replace DELAYED into t_table set a=1, b=2, c=3 on duplicate key update x=values(a)'))->IsEqualTrimming('
replace DELAYED into
  t_table 
set
  a = 1,
  b = 2,
  c = 3 
on duplicate key update
  x = values(a)
');
    }

    function test_sql_format_update()
    {
        // update
        that((sql_format)('update t_table set a=1, b=2, c=3 where x IN (1,2,3)'))->IsEqualTrimming('
update
  t_table 
set
  a = 1,
  b = 2,
  c = 3 
where
  x IN(1, 2, 3)
');

        // update multi1
        that((sql_format)('update t1, t2 as D set t1.a=D.a, t1.b=D.b where t1.id=D.id'))->IsEqualTrimming('
update
  t1,
  t2 as D 
set
  t1.a = D.a,
  t1.b = D.b 
where
  t1.id = D.id
');

        // update multi2
        that((sql_format)('update t_table T join t_join J using(id) set T.v = J.v where A and B'))->IsEqualTrimming('
update
  t_table T 
join
  t_join J using(id)
set
  T.v = J.v 
where
  A 
  and B
');
    }

    function test_sql_format_delete()
    {
        // delete
        that((sql_format)('delete from t_table where x IN (1,2,3)'))->IsEqualTrimming('
delete
from
  t_table 
where
  x IN(1, 2, 3)
');

        // delete multi
        that((sql_format)('DELETE t1, t2 FROM t1 INNER JOIN t2 INNER JOIN t3 WHERE t1.id=t2.id AND t2.id=t3.id'))->IsEqualTrimming('
DELETE
  t1,
  t2 
FROM
  t1 
INNER JOIN
  t2 
INNER JOIN
  t3 
WHERE
  t1.id = t2.id 
  AND t2.id = t3.id
');
    }

    function test_sql_format_modify()
    {
        // delete multi
        that((sql_format)('INSERT INTO test(id, name)
SELECT 100,"aaa" FROM dual WHERE (NOT EXISTS(SELECT * FROM test WHERE id = 100))
ON DUPLICATE KEY UPDATE id = VALUES(id),name = VALUES(name)
'))->IsEqualTrimming('
INSERT INTO
  test(id, name)
SELECT
  100,
  "aaa" 
FROM
  dual 
WHERE
  (
    NOT EXISTS(SELECT * FROM test WHERE id = 100)
  )
ON DUPLICATE KEY UPDATE
  id = VALUES(id),
  name = VALUES(name)
');
    }

    function test_sql_format_comment()
    {
        that((sql_format)("
-- this is quoted `comment`
select 
-- a
  a,
  -- b
  b,
  c -- c
  
from
  -- this is indent comment
  (
  -- this is inner comment
  select * -- this is trailing comment
  from table_name) as t
  -- this is inner comment
  order by null"))->IsEqualTrimming("
-- this is quoted `comment`
select
  -- a
  a,
  -- b
  b,
  c -- c
from
  -- this is indent comment
  (
    -- this is inner comment
    select
      * -- this is trailing comment
    from
      table_name 
  ) as t -- this is inner comment
order by
  null
");

        that((sql_format)('
/*
  this
  is
  block
  comment1
*/
select *
from
  /*
    this
    is
    block
    comment2
  */
  (
    /*
      this
      is
      block
      comment3
    */
  select *
  from table_name)'))->IsEqualTrimming('
/*
  this
  is
  block
  comment1
*/
select
  * 
from
  /*
    this
    is
    block
    comment2
  */
  (
    /*
      this
      is
      block
      comment3
    */
    select
      * 
    from
      table_name 
  )
');
    }

    function test_sql_format_options()
    {
        // misc
        that((sql_format)("select (A and (B and (C and (D and (E)))))", ['indent' => "\t", 'nestlevel' => 4]))->IsEqualTrimming("
select
	(
		A 
		and (B and (C and (D and (E))))
	)
");

        // case
        that((sql_format)("/* comment */select 'abc' str, 123 as num, t.xxx from t_table t", ['case' => true]))->IsEqualTrimming("
/* comment */
SELECT
  'abc' str,
  123 AS num,
  t.xxx 
FROM
  t_table t
");
        that((sql_format)("/* comment */SELECT 'abc' str, 123 as num, t.xxx FROM t_table t", ['case' => false]))->IsEqualTrimming("
/* comment */
select
  'abc' str,
  123 as num,
  t.xxx 
from
  t_table t
");

        // highlight auto
        that((sql_format)("/* comment */select '<abc>' str, 123 as num, t.xxx from t_table t", ['highlight' => true, 'case' => 'ucfirst']))->IsEqualTrimming("
\e[33m/* comment */\e[m
\e[1mSelect\e[m
  \e[31m'<abc>'\e[m str,
  \e[36m123\e[m \e[1mAs\e[m num,
  t.xxx 
\e[1mFrom\e[m
  t_table t
");

        // highlight cli
        that((sql_format)("/* comment */select '<abc>' str, 123 as num, t.xxx from t_table t", ['highlight' => 'cli']))->IsEqualTrimming("
\e[33m/* comment */\e[m
\e[1mselect\e[m
  \e[31m'<abc>'\e[m str,
  \e[36m123\e[m \e[1mas\e[m num,
  t.xxx 
\e[1mfrom\e[m
  t_table t
");

        // highlight html
        that((sql_format)("/* comment */select '<abc>' str, 123 as num, t.xxx from t_table t", ['highlight' => 'html']))->IsEqualTrimming("
<span style='color:#FF8000;'>/* comment */</span>
<span style='font-weight:bold;'>select</span>
  <span style='color:#DD0000;'>&#039;&lt;abc&gt;&#039;</span> str,
  <span style='color:#0000BB;'>123</span> <span style='font-weight:bold;'>as</span> num,
  t.xxx 
<span style='font-weight:bold;'>from</span>
  t_table t
");

        // highlight exception
        that(sql_format)("", ['highlight' => 'hoge'])->wasThrown('highlight must be');
    }

    function test_sql_format_other()
    {
        // mysql set variable
        that((sql_format)("set @hoge=123,@fuga=456"))->IsEqualTrimming("
set
  @hoge = 123,
  @fuga = 456
");

        // contain tag
        that((sql_format)("select '{:RM'"))->IsEqualTrimming("
select
  '{:RM'
");

        // placeholder
        that((sql_format)("select ?, ?
where :id and :status"))->IsEqualTrimming("
select
  ?,
  ? 
where
  :id 
  and :status
");

        // literal
        that((sql_format)("select '\n ' from `dual`"))->IsEqualTrimming("
select
  '
 ' 
from
  `dual`
");

        // between
        that((sql_format)('select (id between A and B) as bw from t_table where status or id between A and B'))->IsEqualTrimming('
select
  (id between A and B) as bw 
from
  t_table 
where
  status 
  or id between A and B
');

        // case when end
        that((sql_format)('select
case a when 1 then 10 when 2 then 20 end as x,
case when a=1 then 10 when a=2 then 20 else null end as y,
case when count(ifnull(a, 1)) end z,
case when a=1 and b=2 and c=3 then 123 when ((a=4) and (b=5) and (c=6)) then 456 else 789 end as mul
from t_table
where exists(select * from T where case a when 1 then 10 when 2 then 20 end = 99 and (other_cond))
'))->IsEqualTrimming('
select
  case a 
    when 1 then 10 
    when 2 then 20 
  end as x,
  case 
    when a = 1 then 10 
    when a = 2 then 20 
    else null 
  end as y,
  case 
    when count(
      ifnull(a, 1)
    )
  end z,
  case 
    when a = 1 and b = 2 and c = 3 then 123 
    when (
      (a = 4) 
      and (b = 5) 
      and (c = 6)
    ) then 456 
    else 789 
  end as mul 
from
  t_table 
where
  exists(
    select
      * 
    from
      T 
    where
      case a 
        when 1 then 10 
        when 2 then 20 
      end = 99 
      and (other_cond)
  )
');

        // transaction
        that((sql_format)('begin;
select * from t_table where id in (1,2,3);
update t_table set name = "hoge" where id in (1,2,3);
commit;'))->IsEqualTrimming('
begin 
;
select
  * 
from
  t_table 
where
  id in(1, 2, 3)
;
update
  t_table 
set
  name = "hoge" 
where
  id in(1, 2, 3)
;
commit 
;
');

        // semicoron
        that((sql_format)('select 1; select 2;'))->IsEqualTrimming('
select
  1 
;
select
  2 
;
');

        // union
        that((sql_format)('select 1 union all select 2'))->IsEqualTrimming('
select
  1 
union all
select
  2
');

        that((sql_format)('select * from ((select *  from T1) union (select *  from T2)) as T'))->IsEqualTrimming('
select
  * 
from
  (
    (select * from T1)
  union 
    (select * from T2)
  ) as T
');

        // for mysql load data
        that((sql_format)('LOAD DATA INFILE "/tmp/test.txt" INTO TABLE test FIELDS TERMINATED BY ","  LINES STARTING BY "xxx"'))->IsEqualTrimming('
LOAD DATA INFILE "/tmp/test.txt" INTO TABLE test 
  FIELDS TERMINATED BY "," LINES STARTING BY "xxx"
');

        // with
        that((sql_format)('
WITH RECURSIVE cte AS
(
  SELECT * from t_something1 where (A and B)
  UNION ALL
  SELECT * from t_something2 where (C and D)
)
SELECT (1 + 2) as t FROM cte'))->IsEqualTrimming('
WITH RECURSIVE cte AS(
  SELECT
    * 
  from
    t_something1 
  where
    (A and B)
  UNION ALL
  SELECT
    * 
  from
    t_something2 
  where
    (C and D)
)
SELECT
  (1 + 2) as t 
FROM
  cte
');

        // keyword function
        that((sql_format)('select left(a, 1), right(b, 1) from t_from left join t_left on 1 right join t_right using(x)'))->IsEqualTrimming('
select
  left(a, 1),
  right(b, 1)
from
  t_from 
left join
  t_left on 1 
right join
  t_right using(x)
');

        // nest comment select
        that((sql_format)('select (/* comment */select a from tt where A and (B and C)) as x'))->IsEqualTrimming('
select
  (
    /* comment */
    select
      a 
    from
      tt 
    where
      A 
      and (B and C)
  ) as x
');
    }
}
