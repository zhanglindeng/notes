# MySQL

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
