# docker hub

**allen5201/php**

```
FROM php:7.2-fpm-alpine

RUN apk add --update \
		autoconf \
		g++ \
		libtool \
		make \
	&& docker-php-ext-install pdo_mysql \
	&& docker-php-ext-install opcache \
	&& docker-php-ext-install bcmath \
  && apk add --update libzip-dev \
  && docker-php-ext-configure zip --with-libzip=/usr/include \
  && docker-php-ext-install zip \
  && apk add --update \
        freetype \
        freetype-dev \
        libpng \
        libpng-dev \
        libjpeg-turbo \
        libjpeg-turbo-dev \
  && docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include \
      --with-jpeg-dir=/usr/include \
  && docker-php-ext-install -j$(nproc) gd \
	&& apk del \
      autoconf \
      g++ \
      libtool \
      make \
      freetype-dev \
      libpng-dev \
      libjpeg-turbo-dev \
	&& rm -rf /tmp/* /var/cache/apk/*

# https://gist.github.com/Mikulas/449746102591d636640467910eaf8aad
```
