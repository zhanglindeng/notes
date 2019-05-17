# MySQL

### my.ini
```
[client]

# pipe
# socket=0.0
port=3306

[mysql]
no-beep

default-character-set=utf8
[mysqld]
# The default character set that will be used when a new schema or table is
# created and no character set is defined
character-set-server=utf8mb4

# The default storage engine that will be used when create new tables when
default-storage-engine=INNODB

# Set the SQL mode to strict
sql-mode="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"

# Enable Windows Authentication
# plugin-load=authentication_windows.dll

# General and Slow logging.
log-output=FILE
general-log=0
general_log_file="mysql.log"
slow-query-log=1
slow_query_log_file="mysql-slow.log"
long_query_time=10

# The maximum size of one packet or any generated or intermediate string, or any parameter sent by the
# mysql_stmt_send_long_data() C API function.
max_allowed_packet=128M
```

### 新建USER和授权

- 用户名：`wechat_dev`
- 密码：`wechat_dev`
- 数据库：`wechat_dev`

```sql
CREATE USER 'wechat_dev'@'%' IDENTIFIED BY 'wechat_dev';

GRANT SELECT, INSERT, UPDATE, REFERENCES, DELETE, CREATE, DROP, ALTER, INDEX, TRIGGER, CREATE VIEW, SHOW VIEW, EXECUTE, ALTER ROUTINE, CREATE ROUTINE, CREATE TEMPORARY TABLES, LOCK TABLES, EVENT ON `wechat\_dev`.* TO 'wechat_dev'@'%';

GRANT GRANT OPTION ON `wechat\_dev`.* TO 'wechat_dev'@'%';
```

### 修改MySQL的root账号密码
```
alert user 'root'@'localhost' identified by 'newPaSS4!';
```


### MySQL 5.7 主从配置
- [CSDN](http://blog.csdn.net/lysc_forever/article/details/52216929)

### CentOS 7 安装 MySQL
- [参考网页](https://dev.mysql.com/doc/mysql-yum-repo-quick-guide/en/)
- sudo rpm -Uvh mysql57-community-release-el6-n.noarch.rpm
- yum repolist all | grep mysql
- yum repolist enabled | grep mysql
- sudo yum install mysql-community-server
- sudo service mysqld start
- sudo service mysqld status
- sudo grep 'temporary password' /var/log/mysqld.log
- mysql -uroot -p
- ALTER USER 'root'@'localhost' IDENTIFIED BY 'MyNewPass4!';
- sudo yum list installed | grep "^mysql"

### utf8mb4
- 使用utf8mb4代替utf8
- utf8最多是3个字节，utf8mb4最多是4个字节
- utf8mb4可以支持更多的字符，如：Emoji表情，不常用的汉字
- mb4 的意思是：most bytes 4
- 5.5.3以后的版本才支持(select version();)
- 可以使用varchar代替char

### create database
- `create database if not exists dbname default charset utf8mb4 collate utf8mb4_unicode_ci`

### create table
```sql
create table if not exists users (
  id int(10) auto_increment,
  email varchar(128) null,
  password varchar(255) null,
  primary key(id),
  unique key users_unique_email(email)
)engine=InnoDB default charset utf8mb4 collate utf8mb4_unicode_ci;
```

### 设置时区
```sql
# 全局
set global time_zone = '+8:00'
# 当前
set time_zone = '+8:00'
# 立即生效
flush privileges;

# 配置文件
[mysqld]
default-time_zone = '+8:00'

# 查看时间
select now();
```

### 重启
`/etc/init.d/mysql restart|start|stop`


