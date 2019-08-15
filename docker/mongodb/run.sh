docker run --name mongo \
	-p 27017:27017 \
	-v /etc/localtime:/etc/localtime:ro \
	-v $(pwd)/data:/data/db \
	-e MONGO_INITDB_ROOT_USERNAME=root \
	-e MONGO_INITDB_ROOT_PASSWORD=JrbW4m7+zaE3IWzAER6kaucg \
	--restart always \
	-d mongo:3.6
