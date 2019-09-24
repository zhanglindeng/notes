FROM allen5201/php:7.2-fpm

RUN apk add --update \
		tzdata \
		bash \
		supervisor \
		nginx \
	&& cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
	&& echo "Asia/Shanghai" > /etc/timezone \
	&& rm -rf /tmp/* /var/cache/apk/*

ADD php.ini /usr/local/etc/php

COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN sed -i "s#127.0.0.1:9000#/run/php-fpm.sock#g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s#9000#/run/php-fpm.sock#g" /usr/local/etc/php-fpm.d/zz-docker.conf

COPY nginx.conf /etc/nginx/
RUN echo "upstream php-upstream { server unix:/run/php-fpm.sock; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf
ADD default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app

ADD startup.sh /opt/startup.sh
RUN sed -i 's/\r//g' /opt/startup.sh
CMD ["/bin/bash", "/opt/startup.sh"]

EXPOSE 80
