FROM allen5201/php:7.2-fpm

RUN apk add --update \
		tzdata \
		bash \
		nginx \
	&& cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
	&& rm -rf /tmp/* /var/cache/apk/*

ADD php.ini /usr/local/etc/php

ARG PHP_UPSTREAM_CONTAINER=localhost
ARG PHP_UPSTREAM_PORT=9000

COPY nginx.conf /etc/nginx/
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf
ADD default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app

ADD startup.sh /opt/startup.sh
RUN sed -i 's/\r//g' /opt/startup.sh
CMD ["/bin/bash", "/opt/startup.sh"]

EXPOSE 80
