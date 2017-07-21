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
