### 在子目录中安装 laravel

```
location /laravel/ {  
    index  index.html index.htm index.php;  
    if (!-e $request_filename){  
        rewrite  ^/laravel/(.*)$  /laravel/index.php?s=$1  last;  
    }  
}  
```
