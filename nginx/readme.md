### [在线生成配置文件](https://nginxconfig.io/)

### certbot 指定 nginx 配置文件路径
- let's encrypt
```
certbot renew --nginx --nginx-server-root=/usr/local/nginx/conf
```

### docker 代理
```
server {
	listen 80;
	server_name abc.domain.com;

	gzip on;
	client_max_body_size 10m;
	charset UTF-8;

	access_log /var/log/nginx/abc.domain.com.access.log;
	error_log /var/log/nginx/abc.domain.com.error.log;

	location / {
		proxy_set_header X-Real-IP $remote_addr;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header Host $http_host;
		proxy_set_header X-Forwarded-Proto $scheme;
		proxy_read_timeout 600;
		proxy_redirect off;
		proxy_pass http://127.0.0.1:8080;
	}
}
```

### 隐藏版本号
```
http {
   server_tokens off;
}
```

### [nginx GeoIP](http://blog.topspeedsnail.com/archives/7410)

### [速率限制](https://www.nginx.com/blog/rate-limiting-nginx/)
- `limit_req_zone`
- `limit_req`


### 最大请求大小
```
Syntax:	client_max_body_size size;
Default: client_max_body_size 1m;
Context: http, server, location
```

### 负载均衡（轮询）
```
upstream test {
    server 127.0.0.1:8010 weight=5;# 5/6
    server 127.0.0.1:8020 max_fails=1 fail_timeout=10s; #失效1次，接下来10s内不会分发请求到该server
    server 127.0.0.1:8030 backup; # 备份server
}

server {
	listen 80;
	server_name test.dev;
	
	index index.php index.html;
	
	access_log logs/test.dev.access.log;
	error_log logs/test.dev.error.log;

	location / {
		proxy_set_header X-Real-IP $remote_addr;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header Host $http_host;
		proxy_set_header X-Forwarded-Proto $scheme;
		proxy_redirect off;
		proxy_connect_timeout 10s; # 停掉 8020，10s后超时转到8010
		proxy_pass http://test;
	}
}
```

自动更新代码：

停掉8020 -> 更新8020 -> 启动8020 -> 停掉8010 -> 更新8010 -> 启动8010 -> 停掉8030 -> 更新8030 -> 启动8030
