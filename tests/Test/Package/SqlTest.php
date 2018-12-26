<?php

namespace ryunosuke\Test\Package;

class SqlTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_sql_quote()
    {
        $this->assertEquals('NULL', (sql_quote)(null));
        $this->assertEquals('0', (sql_quote)(false));
        $this->assertEquals('1', (sql_quote)(true));
        $this->assertEquals('123', (sql_quote)(123));
        $this->assertEquals('1.23', (sql_quote)(1.23));
        $this->assertEquals('123', (sql_quote)('123'));
        $this->assertEquals('1.23', (sql_quote)('1.23'));
        $this->assertEquals("'hoge'", (sql_quote)('hoge'));
        $this->assertEquals("'ho\'ge'", (sql_quote)("ho'ge"));
        $this->assertEquals("'ho\\\"ge'", (sql_quote)('ho"ge'));
    }

    function test_sql_bind()
    {
        $this->assertEquals('select 1', (sql_bind)('select ?', 1));
        $this->assertEquals('select 1, 2', (sql_bind)('select ?, ?', [1, 2]));
        $this->assertEquals('select 1', (sql_bind)('select :name', ['name' => 1]));
        $this->assertEquals('select ":name"', (sql_bind)('select ":name"', ['xxx' => 1]));
        $this->assertEquals('select 1, 3, 2, 4', (sql_bind)('select ?, :hoge, ?, :fuga', [1, 2, 'hoge' => 3, 'fuga' => 4]));
        $this->assertEquals("select 'a', 'c', 'b', 'd'", (sql_bind)('select ?, :hoge, ?, :fuga', ['a', 'b', 'hoge' => 'c', 'fuga' => 'd']));
    }

    function test_sql_format_create()
    {
        $this->assertFormatSql('
CREATE TABLE t_table (
  id INT(10) UNSIGNED NOT NULL COMMENT "primary",
  name VARCHAR(32) NOT NULL COMMENT "table_name" COLLATE "utf8_bin",
  PRIMARY KEY(id),
  INDEX idx_name(name),
  CONSTRAINT fk_name FOREIGN KEY(name) REFERENCES t_other(other_name) ON UPDATE CASCADE ON DELETE CASCADE 
) COMMENT = "TableComment" COLLATE = "utf8_bin" ENGINE = InnoDB ROW_FORMAT = DYNAMIC
', 'CREATE TABLE t_table (
  id INT(10) UNSIGNED NOT NULL COMMENT "primary",
  name VARCHAR(32) NOT NULL COMMENT "table_name" COLLATE "utf8_bin",
  PRIMARY KEY (id),
  INDEX idx_name (name),
  CONSTRAINT fk_name FOREIGN KEY (name) REFERENCES t_other (other_name) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT="TableComment"
COLLATE="utf8_bin"
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC
');

        $this->assertFormatSql('
CREATE TABLE IF NOT EXISTS t_table(
  id INT(10) UNSIGNED NOT NULL COMMENT "primary" 
)
', 'CREATE TABLE IF NOT EXISTS t_table (id INT(10) UNSIGNED NOT NULL COMMENT "primary")');

        $this->assertFormatSql('
CREATE INDEX part_of_name ON customer(name, id)
', 'CREATE INDEX part_of_name ON customer (name, id)');
    }

    function test_sql_format_drop()
    {
        $this->assertFormatSql('
drop table tbl
', 'drop table tbl');

        $this->assertFormatSql('
drop table IF EXISTS tbl
', 'drop table IF EXISTS  tbl');
    }

    function test_sql_format_alter()
    {
        $this->assertFormatSql('
ALTER TABLE TABLE_NAME 
  ADD COLUMN colA INT(11) NULL DEFAULT NULL COMMENT "comment1" AFTER hoge,
  ADD COLUMN colB DATETIME NULL DEFAULT NULL COMMENT "comment2" AFTER fuga,
  DROP COLUMN colC,
  CHANGE COLUMN colD colD TINYINT(1) DEFAULT 0 NOT NULL COMMENT "comment4",
  ADD INDEX idx_name(name),
  add CONSTRAINT fk_name FOREIGN KEY(name) REFERENCES t_other(other_name) ON UPDATE CASCADE ON DELETE CASCADE
', 'ALTER TABLE TABLE_NAME
  ADD COLUMN colA INT(11)  NULL DEFAULT NULL COMMENT "comment1" AFTER hoge,
  ADD COLUMN colB DATETIME NULL DEFAULT NULL COMMENT "comment2" AFTER fuga,
  DROP COLUMN colC,
  CHANGE COLUMN colD colD TINYINT(1) DEFAULT 0 NOT NULL COMMENT "comment4",
  ADD INDEX idx_name(name),
  add CONSTRAINT fk_name FOREIGN KEY (name) REFERENCES t_other (other_name) ON UPDATE CASCADE ON DELETE CASCADE
');
    }

    function test_sql_format_select()
    {
        // select
        $this->assertFormatSql('
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
', 'select
    T.*,
    exists(select * from t_sub S where (S.id = T.id)) as e,
    greatest(ifnull(a, 9), ifnull(b, 9)) as g
  from (select * from t_table where (status = "active")) T
  left outer join t_join1 on t_join1.id = t_table.id
  right join t_join2 on t_join2.id = (select max(id) from t_sub where (A and B))
  inner join t_join3 using (id)
  where (a and (b and (c and (d in (1,2,3)))))
  group by id having count(misc) > 10 order by id desc limit 10 offset 5');

        // for update
        $this->assertFormatSql('
select
  * 
from
  t_table 
for update
', 'select * from t_table for update');

        // lock in share mode
        $this->assertFormatSql('
select
  * 
from
  t_table 
lock in share mode
', 'select * from t_table lock in share mode');
    }

    function test_sql_format_insert()
    {
        // insert
        $this->assertFormatSql('
insert into
  t_table(a, b, c)
values
  (1, 2, 3),
  (4, 5, 6)
', 'insert into t_table (a,b,c) values (1,2,3), (4,5,6)');

        // insert set
        $this->assertFormatSql('
insert into
  t_table 
set
  a = 1,
  b = 2,
  c = 3
', 'insert into t_table set a=1, b=2, c=3');

        // insert select
        $this->assertFormatSql('
insert into
  t_table(a, b, c)
select
  a,
  b,
  c 
from
  t_table2 T2
', 'insert into t_table (a,b,c) select a,b,c from t_table2 T2');

        // insert duplicate key
        $this->assertFormatSql('
insert OPTIONS into
  t_table 
set
  a = 1,
  b = 2,
  c = 3 
on duplicate key update
  x = values(a)
', 'insert OPTIONS into t_table set a=1, b=2, c=3 on duplicate key update x=values(a)');
    }

    function test_sql_format_replace()
    {
        // insert
        $this->assertFormatSql('
replace into
  t_table(a, b, c)
values
  (1, 2, 3),
  (4, 5, 6)
', 'replace into t_table (a,b,c) values (1,2,3), (4,5,6)');

        // insert set
        $this->assertFormatSql('
replace into
  t_table 
set
  a = 1,
  b = 2,
  c = 3
', 'replace into t_table set a=1, b=2, c=3');

        // insert select
        $this->assertFormatSql('
replace into
  t_table(a, b, c)
select
  a,
  b,
  c 
from
  t_table2 T2
', 'replace into t_table (a,b,c) select a,b,c from t_table2 T2');

        // insert duplicate key
        $this->assertFormatSql('
replace DELAYED into
  t_table 
set
  a = 1,
  b = 2,
  c = 3 
on duplicate key update
  x = values(a)
', 'replace DELAYED into t_table set a=1, b=2, c=3 on duplicate key update x=values(a)');
    }

    function test_sql_format_update()
    {
        // update
        $this->assertFormatSql('
update
  t_table 
set
  a = 1,
  b = 2,
  c = 3 
where
  x IN(1, 2, 3)
', 'update t_table set a=1, b=2, c=3 where x IN (1,2,3)');

        // update multi1
        $this->assertFormatSql('
update
  t1,
  t2 as D 
set
  t1.a = D.a,
  t1.b = D.b 
where
  t1.id = D.id
', 'update t1, t2 as D set t1.a=D.a, t1.b=D.b where t1.id=D.id');

        // update multi2
        $this->assertFormatSql('
update
  t_table T 
join
  t_join J using(id)
set
  T.v = J.v 
where
  A 
  and B
', 'update t_table T join t_join J using(id) set T.v = J.v where A and B');
    }

    function test_sql_format_delete()
    {
        // delete
        $this->assertFormatSql('
delete
from
  t_table 
where
  x IN(1, 2, 3)
', 'delete from t_table where x IN (1,2,3)');

        // delete multi
        $this->assertFormatSql('
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
', 'DELETE t1, t2 FROM t1 INNER JOIN t2 INNER JOIN t3 WHERE t1.id=t2.id AND t2.id=t3.id');
    }

    function test_sql_format_comment()
    {
        $this->assertFormatSql("
-- this is hyphen `comment1`
select
  * 
from
  -- this is hyphen comment2
  table
", "
-- this is hyphen `comment1`
select *
from
  -- this is hyphen comment2
  table");

        $this->assertFormatSql('
# this is sharp comment1
select
  * 
from
  # this is sharp comment2
  table
', '
# this is sharp comment1
select *
from
  # this is sharp comment2
  table');

        $this->assertFormatSql('
/*
  this
  is
  block
  comment1
*/
select
  * 
from
  /**
    this
    is
    docblock
    comment2
  */
  table
', '
/*
  this
  is
  block
  comment1
*/
select *
from
  /**
    this
    is
    docblock
    comment2
  */
  table');
    }

    function test_sql_format_options()
    {
        // misc
        $this->assertFormatSql("
select
	(
		A 
		and (B and (C and (D and (E))))
	)
", "select (A and (B and (C and (D and (E)))))", ['indent' => "\t", 'nestlevel' => 4]);

        // case
        $this->assertFormatSql("
/* comment */
SELECT
  'abc' str,
  123 AS num,
  t.xxx 
FROM
  t_table t
", "/* comment */select 'abc' str, 123 as num, t.xxx from t_table t", ['case' => true]);
        $this->assertFormatSql("
/* comment */
select
  'abc' str,
  123 as num,
  t.xxx 
from
  t_table t
", "/* comment */SELECT 'abc' str, 123 as num, t.xxx FROM t_table t", ['case' => false]);

        // highlight auto
        $this->assertFormatSql("
\e[33m/* comment */\e[m
\e[1mSelect\e[m
  \e[31m'<abc>'\e[m str,
  \e[36m123\e[m \e[1mAs\e[m num,
  t.xxx 
\e[1mFrom\e[m
  t_table t
", "/* comment */select '<abc>' str, 123 as num, t.xxx from t_table t", ['highlight' => true, 'case' => 'ucfirst']);

        // highlight cli
        $this->assertFormatSql("
\e[33m/* comment */\e[m
\e[1mselect\e[m
  \e[31m'<abc>'\e[m str,
  \e[36m123\e[m \e[1mas\e[m num,
  t.xxx 
\e[1mfrom\e[m
  t_table t
", "/* comment */select '<abc>' str, 123 as num, t.xxx from t_table t", ['highlight' => 'cli']);

        // highlight html
        $this->assertFormatSql("
<span style='color:#FF8000;'>/* comment */</span>
<span style='font-weight:bold;'>select</span>
  <span style='color:#DD0000;'>'&lt;abc&gt;'</span> str,
  <span style='color:#0000BB;'>123</span> <span style='font-weight:bold;'>as</span> num,
  t.xxx 
<span style='font-weight:bold;'>from</span>
  t_table t
", "/* comment */select '<abc>' str, 123 as num, t.xxx from t_table t", ['highlight' => 'html']);

        // highlight exception
        $this->assertException('highlight must be', sql_format, "", ['highlight' => 'hoge']);
    }

    function test_sql_format_other()
    {
        // contain tag
        $this->assertFormatSql("
select
  '{:RM'
", "select '{:RM'");

        // literal
        $this->assertFormatSql("
select
  '
 ' 
from
  `dual`
", "select '\n ' from `dual`");

        // between
        $this->assertFormatSql('
select
  (id between A and B) as bw 
from
  t_table 
where
  status 
  or id between A and B
', 'select (id between A and B) as bw from t_table where status or id between A and B');

        // case when end
        $this->assertFormatSql('
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
  end z 
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
', 'select
case a when 1 then 10 when 2 then 20 end as x,
case when a=1 then 10 when a=2 then 20 else null end as y,
case when count(ifnull(a, 1)) end z
from t_table
where exists(select * from T where case a when 1 then 10 when 2 then 20 end = 99 and (other_cond))
');

        // semicoron
        $this->assertFormatSql('
select
  1 
;
select
  2 
;
', 'select 1; select 2;');

        // union
        $this->assertFormatSql('
select
  1 
union all
select
  2
', 'select 1 union all select 2');

        $this->assertFormatSql('
select
  * 
from
  (
    (select * from T1)
  union 
    (select * from T2)
  ) as T
', 'select * from ((select *  from T1) union (select *  from T2)) as T');

        // for mysql load data
        $this->assertFormatSql('
LOAD DATA INFILE "/tmp/test.txt" INTO TABLE test 
  FIELDS TERMINATED BY "," LINES STARTING BY "xxx"
', 'LOAD DATA INFILE "/tmp/test.txt" INTO TABLE test FIELDS TERMINATED BY ","  LINES STARTING BY "xxx"');

        // with
        $this->assertFormatSql('
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
  * 
FROM
  cte
', '
WITH RECURSIVE cte AS
(
  SELECT * from t_something1 where (A and B)
  UNION ALL
  SELECT * from t_something2 where (C and D)
)
SELECT * FROM cte');

        // keyword function
        $this->assertFormatSql('
select
  left(a, 1),
  right(b, 1)
from
  t_from 
left join
  t_left on 1 
right join
  t_right using(x)
', 'select left(a, 1), right(b, 1) from t_from left join t_left on 1 right join t_right using(x)');

        // nest comment select
        $this->assertFormatSql('
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
', 'select (/* comment */select a from tt where A and (B and C)) as x');
    }

    private function assertFormatSql($expected, $actual, $options = [])
    {
        $actual = (sql_format)($actual, $options);
        $this->assertEquals(trim($expected), $actual, "actual:\n$actual\n");
    }
}
