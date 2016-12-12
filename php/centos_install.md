### 在 centos 6.8 上安装 php 5.6

```
创建 www 用户
# groupadd www
# useradd -g www -s /sbin/nologin -M www
#
依赖安装(抄swoole的)
yum -y install gcc gcc-c++ autoconf libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glibc glibc-devel glib2 glib2-devel bzip2 bzip2-devel ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel krb5 krb5-devel libidn libidn-devel openssl openssl-devel openldap openldap-devel nss_ldap openldap-clients openldap-servers gd gd2 gd-devel gd2-devel perl-CPAN pcre-devel

安装配置(抄swoole的)
./configure --prefix=/usr/local/php --with-config-file-path=/etc/php --enable-fpm --enable-pcntl --enable-mysqlnd --enable-opcache --enable-sockets --enable-sysvmsg --enable-sysvsem  --enable-sysvshm --enable-shmop --enable-zip --enable-ftp --enable-soap --enable-xml --enable-mbstring --disable-rpath --disable-debug --disable-fileinfo --with-mysql=mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --with-pcre-regex --with-iconv --with-zlib --with-mcrypt --with-gd --with-openssl --with-mhash --with-xmlrpc --with-curl --with-imap-ssl

失败
1、configure: error: mcrypt.h not found. Please reinstall libmcrypt
执行：rpm -ivh “http://dl.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm”后，再安装：yum install libmcrypt-devel

编译
make && make install

配置文件
cp php.ini-development /etc/php

添加环境变量
vim ~/.bashrc

export PATH=/usr/local/php/bin:$PATH
export PATH=/usr/local/php/sbin:$PATH

保存后：
source ~/.bashrc

参考网页
https://segmentfault.com/a/1190000002488216
http://blog.aboutc.net/linux/65/compile-and-install-php-on-linux
https://github.com/LinkedDestiny/swoole-doc/blob/master/01-%E7%8E%AF%E5%A2%83%E6%90%AD%E5%BB%BA%E5%8F%8A%E6%89%A9%E5%B1%95%E5%AE%89%E8%A3%85.md


安装 nginx
yum install nginx

配置 nginx php-fpm
location ~ \.php$ {
            root           html;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }

```
