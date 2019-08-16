# docker

## CentOS 安装 Docker

#### docker

参考网址：https://docs.docker.com/install/linux/docker-ce/centos/

```
$ sudo yum install -y yum-utils \
  device-mapper-persistent-data \
  lvm2
$ sudo yum-config-manager \
    --add-repo \
    https://download.docker.com/linux/centos/docker-ce.repo
$ yum list docker-ce --showduplicates | sort -r
$ sudo yum install docker-ce docker-ce-cli containerd.io
$ sudo systemctl start docker
$ sudo docker run hello-world
```
- 开机启动docker `sudo systemctl enable docker`
- 启动docker `sudo systemctl start docker`
- 查看docker状态 `sudo systemctl status docker`
- 重启docker `sudo systemctl restart docker`
- 停止docker `sudo systemctl stop docker`
- 查看运行的container `sudo docker ps -a`

#### docker compose
 
參考網址：https://docs.docker.com/compose/install/

- 最新穩定版本（2019-06-13）：`1.24.0`

下載文件：

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" \
 -o /usr/local/bin/docker-compose
```

添加執行權限：

```
sudo chmod +x /usr/local/bin/docker-compose
```

檢查是否安裝成功：

```
docker-compose --version
```

顯示類似下面的信息表示安裝成功
```
docker-compose version 1.24.0, build 0aa59064
```


### 使用 docker php-fpm 示例

> 以 `php-fpm 7.1` 为例

**构建镜像**
```
sudo docker build -t local/php:7.1-fpm .
```

**运行容器**
```
sudo docker run --name site.domain.com \
    --restart=always \
    -p 9000:9000 \
    -v /var/www/site.domain.com:/var/www/site.domain.com \
    -d local/php:7.1-fpm
```

**配置 nginx**
```
location ~ \.php$ {
    # 要和上面 -v 的一样
    root           /var/www/site.domain.com
    fastcgi_pass   127.0.0.1:9000;
    fastcgi_index  index.php;
    fastcgi_buffers 16 16k;
    fastcgi_buffer_size 32k;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include        fastcgi_params;
}
```


### 刪除 none 的 image
```
docker rmi $(docker images --filter "dangling=true" -q --no-trunc)
```

### 私有仓库
[参考网页](https://www.cnblogs.com/fengzheng/p/5168951.html)

### ngixn proxy https => http
```php
if (!function_exists('asset_url')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool $secure
     * @return string
     */
    function asset_url($path, $secure = null)
    {
        // nginx 使用 https 代理了 http
        // 配置 http, server, location: proxy_set_header X-Forwarded-Proto $scheme;
        // 有 HTTP_X_FORWARDED_PROTO 并且是 https 就认为是 https
        // 开发时可能是 http，上线时是 https
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https'
        ) {
            return asset($path, true);
        }
        return asset($path, $secure);
    }
}
```
