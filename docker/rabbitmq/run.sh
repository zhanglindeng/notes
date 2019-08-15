docker run --name rabbitmq \
	-p 5672:5672 \
	-p 15672:15672 \
	-e RABBITMQ_DEFAULT_USER=root \
	-e RABBITMQ_DEFAULT_PASS=root \
	-d rabbitmq:3-management
