# MySQL 5.7 主从复制

> GTID 模式

## 主服务

**my.ini**

```ini
[mysqld]
# 服务器id，一般是IP最后的数字
server_id=14

# 二进制日志文件名
log-bin=mysql-bin

# 其他格式可能造成数据不一致
binlog_format=row

# 是否记录从服务器同步数据动作
log-slave-updates=1

# 启用gitd功能
gtid-mode=on

# 开启强制GTID一致性
enforce-gtid-consistency=on

# 记录IO线程读取已经读取到的master binlog位置
# 用于slave宕机后IO线程根据文件中的POS点重新拉取binlog日志
master-info-repository=TABLE

# 记录SQL线程读取Master binlog的位置
# 用于Slave 宕机后根据文件中记录的pos点恢复Sql线程
relay-log-info-repository=TABLE

# 启用确保无信息丢失；任何一个事务提交后, 将二进制日志的文件名及事件位置记录到文件中
sync-master-info=1

# 设定从服务器的复制线程数；0表示关闭多线程复制功能
slave-parallel-workers=4

# 设置binlog校验算法（循环冗余校验码）
binlog-checksum=CRC32

# 设置主服务器是否校验
master-verify-checksum=1

# 设置从服务器是否校验
slave-sql-verify-checksum=1

# 用于在二进制日志记录事件相关的信息，可降低故障排除的复杂度
binlog-rows-query-log_events=1

# 保证master crash safe，该参数必须设置为1
sync_binlog=1

# 保证master crash safe，该参数必须设置为1
innodb_flush_log_at_trx_commit=1
```

**创建专门用于主从复制的账号**

```mysql
grant replication slave on *.* to 'slaveuser'@'192.168.1.%' identified by 'Slave-2021';

flush privileges;

show grants for 'slaveuser'@'192.168.1.%';
```

- 用户名：slaveuser
- 密码：Slave-2021
- 授权IP：192.168.1.0 - 192.168.1.255

**查看 master 状态**

```mysql
show master status;
show slave hosts;

show global variables like '%uuid%';

-- 查看确认 GTID 功能打开
show global variables like '%gtid%';

-- 查看确认 Binlog 日志功能打开
show variables like 'log_bin';
```



## 从服务

> 不开启 binlog

**my.ini**

```ini
[mysqld]
# 服务器id，一般是IP最后的数字，比主服务的id大
server_id=15

# 启用gitd功能
gtid-mode=on

# 开启强制GTID一致性
enforce-gtid-consistency=on

# 设置不用复制的数据库
replicate_ignore_db=information_schema
replicate_ignore_db=mysql
replicate_ignore_db=performance_schema
replicate_ignore_db=sys
```

**配置主服务**

```mysql
change master to master_host='192.168.1.14', master_user='slaveuser', master_password='Slave-2021',master_port=3306,master_auto_position=1;

-- master_auto_position=1 从库自动找同步点
```

**启动复制**

```mysql
start slave;
```

**查看复制状态**

```mysql
show slave status\G
```

- Slave_IO_State  从站的当前状态
- Slave_IO_Running：Yes  读取主程序二进制日志的I/O线程是否正在运行 
- Slave_SQL_Running：Yes  执行读取主服务器中二进制日志事件的SQL线程是否正在运行。与I/O线程一样 
- Seconds_Behind_Master  是否为0，0就是已经同步了

>如果再次查询状态仍然 发现Slave_IO_Running 或者Slave_SQL_Running 不同时为YES，尝试执行
>
>- stop slave;
>- reset slave;
>- start slave;

**停止复制**

```mysql
stop slave;
```

**清除主从设置**

```mysql
stop slave;
reset slave all;
show slave status\G
```

