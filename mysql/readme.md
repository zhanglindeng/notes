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
