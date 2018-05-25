### PHP 弱类型的底层实现 / PHP的变量是怎么存储的

- [参考](https://blog.csdn.net/a_haogg/article/details/72896787)

在 PHP 中声明的所有变量，ZE 中都是用结构体 zval 来保存的

### innodb和myisam的特性，区别，用途

- [参考](https://blog.csdn.net/xifeijian/article/details/20316775)
- [参考](https://my.oschina.net/junn/blog/183341)

- MyISAM 不支持事务，而 InnoDB 支持事务和外键以及行级锁
- InnoDB 不支持 FULLTEXT 类型索引
- InnoDB 中不保存表的具体行数，执行 `select count(*) from table` 时，InnoDB 会全表扫描，MyISAM 只要读取出保存好的行数即可，注意的是，当 `count(*)` 包含 where 语句时，两者操作是一样的。
- 对于 AUTO_INCREMENT 类型的字段，InnoDB 中必须包含该字段的索引，但是在 MyISAM 中，可以和其他字段一起建立联合索引
- DELETE FORM TABLE 时，InnoDB 不会重新建立表，而是一行一行的删除。
- LOAD TABLE FROM MASTER 操作对 InnoDB 是不起作用的，解决办法是首先把 InnoDB 表改成 MyISAM 表，导入数据后再改成 InnoDB 表，但是对于使用的额外的 InnoDB 特性（例如外键）的表不适用

**两种类型最主要的差别就是 InnoDB 支持事务与外键和行级锁**

如果数据库平台要达到：99.9% 的稳定性，方便的扩展和高可用性来说的话，MyISAM 绝对是首选。

- 平台上承载的大部分项目是读多写少，而 MyISAM 的读性能比 InnoDB 好
- MyISAM 的索引和数据是分开的，并且索引是由压缩的，内存使用率就对应提高不少。能加载更多索引，而 InnoDB 是索引和数据是紧密捆绑的，没有使用压缩从而会造成 InnoDB 比 MyISAM 体积庞大不小


### MySQL 多列索引的生效规则

- [参考](https://www.cnblogs.com/codeAB/p/6387148.html)
- [参考](http://m635674608.iteye.com/blog/2393713)
- [参考](https://www.jianshu.com/p/c1f66abaae8f)

MyISAM 和 InnoDB 默认使用的是 Btree 索引

在 MySQL 中执行查询时，只能使用一个索引，MySQL 会选择一个最严格(获得结果集记录最少)的索引

索引是排好序的

**组合索引的生效原则是：从前往后依次使用生效，如果中间某个索引没有使用，那么断点前面的索引部分起作用，断点后面的索引没有起作用**

满足左前缀要求

组合索引用上了就行，跟 where 写的顺序无关

(a,b,c) 和 (a,c,b) 是不一样的

索引不能包含有 NULL 值的列，在查询的时候索引值包含 NULL 或者在组合索引中包含 NULL 值得情况下，索引是无效的。


- `select * from mytable where a=3 and b>7 and c=3;` a用到了，b也用到了，c没有用到，这个地方b是范围值，也算断点，只不过自身用到了索引
- `select * from mytable where b=3 and c=4;` 因为a索引没有使用，所以这里 bc都没有用上索引效果
- `select * from mytable where a>4 and b=7 and c=9;` a用到了  b没有使用，c没有使用
- `select * from mytable where a=3 order by b;` a用到了索引，b在结果排序中也用到了索引的效果，前面说了，a下面任意一段的b是排好序的
- `select * from mytable where a=3 order by c;` a用到了索引，但是这个地方c没有发挥排序效果，因为中间断点了，使用 explain 可以看到 filesort
- `select * from mytable where b=3 order by a;` b没有用到索引，排序中a也没有发挥索引效果


### MySQL 优化小技巧

- [参考](http://www.cnblogs.com/codeAB/p/6391627.html)

**碎片整理**

开始存是有序的，update 频繁，数据就会形成很多碎片，拖慢速度和不利于索引

- `alter table user engine innodb;` 其实 user 表原先也是 innodb 的，这句话看上去没有任何意义，但是 mysql 会重新整理数据
- `optimize table user;` 也可以修复

> 碎片优化是一种很费 CPU 和内存的事，最好在夜里执行


**非常规的 min max 优化**

快：`select min(age) from table;`
慢：`select min(age) from table where status=1;` 通过 `explain` 查看是全表扫描
快：`select min(age) from table use index(age) where status=1 limit 1;` 强制使用索引，前提是有 age 索引


**count 非常规优化**

快：`select count(*) from table;`
慢：`select count(*) from table where id>100;` 从 100 开始扫描
快：`select count(*) from table where id<100;` 扫描前 100 条
快：`( select count(*) from table ) - ( select  count(*) from table where id<100 )` 利用数字优化

**union优化**
连接查询结果的时候 如非必要 尽量使用 union all，因为union all 不过滤数据，效率高，而union要过滤数据，代价很大；