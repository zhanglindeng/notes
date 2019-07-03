### CentOS 7 编译安装 php 7.2

- CentOS 7.3
- PHP 7.2.19


**下载 PHP 代码**
```
wget https://www.php.net/distributions/php-7.2.19.tar.gz
```

**解压**
```
tar -zxvf php-7.2.19.tar.gz
```

**安装依赖**
```
yum install gcc \
    autoconf \
    gcc-c++ \
    libxml2 \
    libxml2-devel \
    openssl \
    openssl-devel \
    bzip2 \
    bzip2-devel \
    libcurl \
    libcurl-devel \
    libjpeg \
    libjpeg-devel \
    libpng \
    libpng-devel \
    freetype \
    freetype-devel \
    gmp \
    gmp-devel \
    readline \
    readline-devel \
    libxslt \
    libxslt-devel \
    systemd-devel \
    openjpeg-devel
```

**创建php-fpm用户**
```
groupadd php-fpm

useradd -s /sbin/nologin -g php-fpm -M php-fpm
```

**配置**

进入到 php-7.2.19 目录

```
./configure \
    --prefix=/usr/local/php \
    --with-config-file-path=/etc/php \
    --with-zlib-dir \
    --with-freetype-dir \
    --enable-mbstring \
    --with-libxml-dir=/usr \
    --enable-xmlreader \
    --enable-xmlwriter \
    --enable-soap \
    --enable-calendar \
    --with-curl \
    --with-zlib \
    --with-gd \
    --with-pdo-sqlite \
    --with-pdo-mysql \
    --with-mysqli \
    --with-mysql-sock \
    --enable-mysqlnd \
    --enable-inline-optimization \
    --with-bz2 \
    --with-zlib \
    --enable-sockets \
    --enable-sysvsem \
    --enable-sysvshm \
    --enable-pcntl \
    --enable-mbregex \
    --enable-exif \
    --enable-bcmath \
    --with-mhash \
    --enable-zip \
    --with-pcre-regex \
    --with-jpeg-dir=/usr \
    --with-png-dir=/usr \
    --with-openssl \
    --enable-ftp \
    --with-kerberos \
    --with-gettext \
    --with-xmlrpc \
    --with-xsl \
    --enable-fpm \
    --with-fpm-user=php-fpm \
    --with-fpm-group=php-fpm \
    --with-fpm-systemd
```

**编译安装**
```
make && make install
```

**配置文件**

- php.ini

```
# 和上面的 --with-config-file-path=/etc/php 对应

cp php.ini-production /etc/php/php.ini
```

- php-fpm.conf

进去到 /usr/local/php/etc 目录

```
cp php-fpm.conf.default php-fpm.conf
```

- www.conf

进去到 /usr/local/php/etc/php-fpm.d 目录

```
cp www.conf.default  www.conf
```

**开机启动 php-fpm**

进入到 php-7.2.19 目录

```
cp ./sapi/fpm/php-fpm.service /usr/lib/systemd/system/

# 开机启动
systemctl enable php-fpm

# 启动 php-fpm
systemctl start php-fpm

# 查看 php-fpm 状态
systemctl status php-fpm
```

**环境变量**

vim  /etc/profile
```
export PATH=$PATH:/usr/local/php/bin:/usr/local/php/sbin
```

使环境变量生效
```
source /etc/profile
```

**检查**
```
php -v
```

**完**


### [ubuntu 16.04 php 7.1](https://www.rosehosting.com/blog/install-php-7-1-with-nginx-on-an-ubuntu-16-04-vps/)

### [CentOS PHP7](https://www.tecmint.com/install-php-7-in-centos-7/amp/)


### PHPStorm
- (material-theme-ui)[https://plugins.jetbrains.com/plugin/8006-material-theme-ui]

### PHP-CS
- [http://cs.sensiolabs.org/](http://cs.sensiolabs.org/)
- [php-cs-fixer](https://packagist.org/packages/friendsofphp/php-cs-fixer)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

### PHPMD
- [https://phpmd.org/](https://phpmd.org/)
- [https://github.com/overtrue/phpmd-rulesets](https://github.com/overtrue/phpmd-rulesets)
- [phpmd](https://github.com/manuelpichler/phpmd)

### [webtatic](https://webtatic.com/packages/php56/)

### error handler
- register_shutdown_function 总是运行，set_error_handler,set_exception_handler 没有处理的话，$errors 就不为 null
- set_error_handler 一般错误
- set_exception_handler 致命错误，不会捕获一般错误

### header
- header_list()

### Log Level
```
严重程度的级别，从低到高为: debug、 info、notice、 warning、error、critical、alert、emergency
```
