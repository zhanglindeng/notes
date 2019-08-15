docker run --name redis \
	-p 6379:6379 \
	--restart always \
	-d redis:5 \
	--requirepass "s+pbwwkA8GR4FV4g"
