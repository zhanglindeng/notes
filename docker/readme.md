# docker

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
