docker run --name mysql \
	-p 3306:3306 \
	-e MYSQL_ROOT_PASSWORD=ws+sT9sDasNs906x7jlmtWAP \
	-v $(pwd)/conf.d:/etc/mysql/conf.d \
	-v $(pwd)/data:/var/lib/mysql \
	--restart always \
	-d mysql:5.7
