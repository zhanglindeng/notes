docker run --name jenkins \
	-u root \
	-p 10086:8080 \
	-p 50000:50000 \
	-v /etc/localtime:/etc/localtime \
	-v $(pwd)/jenkins_home:/var/jenkins_home \
	--restart always \
	-d jenkins/jenkins:lts
