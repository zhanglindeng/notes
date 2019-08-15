docker run --name zookeeper \
	--restart always \
	-p 2181:2181 \
	-d zookeeper:3.5
