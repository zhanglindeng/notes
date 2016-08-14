# wnmp

Windows+Nginx+MySQL+PHP7


## 下载
- [Nginx](http://nginx.org/en/download.html)
- [MySQL](http://dev.mysql.com/downloads/mysql/)
- [PHP7](http://windows.php.net/download#php-7.0)


## 配置

### Nginx
- 在nginx的conf文件夹下新建 `vhosts.conf`
- 修改 `nginx.conf`：在最后一个花括号前加 `include vhosts.conf;`
- vhosts.conf
```shell
server {
        listen       80;
        server_name  example.com; #域名
        root   "D:/wnmp/www/example.com"; #代码目录
        location / {
            index  index.html index.php;
            #autoindex  on;
        }
        location ~ \.php(.*)$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO  $fastcgi_path_info;
            fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
            include        fastcgi_params;
        }
}
# 可以添加多个 server，修改域名和目录即可
```

### PHP7、MySQL自行配置


## 启动

### PHP
```shell
# cd到php目录
php-cgi.exe -b 127.0.0.1:9000
```

### MySQL
```shell
# cd到mysql的bin目录
mysqld.exe
```

### nginx
```shell
# cd到nginx目录
nginx.exe -p D:/wnmp/nginx # -p <nginx安装目录>
```

## 关闭

```bat
@echo off
taskkill /F /IM nginx.exe > nul
taskkill /F /IM mysqld.exe > nul
taskkill /F /IM php-cgi.exe > nul
pause

```
