docker run --name elasticsearch \
	-p 9200:9200 \
	-p 9300:9300 \
	-e ES_JAVA_OPTS="-Xms1g -Xmx1g" \
	-e "discovery.type=single-node" \
	-d elasticsearch:7.2.0
