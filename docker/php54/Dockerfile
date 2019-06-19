FROM centos:7

# ADD CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo

RUN \
    yum -y update \
    && yum -y install --setopt=tsflags=nodocs \
    epel-release \
    php \
    php-gd \
    php-mysql \
    php-curl \
    php-mbstring \
    php-bcmath \
    php-mcrypt \
    php-xml \
    php-zip \
    php-dom \
    php-ctype \
    php-fileinfo \
    php-intl \
    php-pdo-mysql \
    php-openssl \
    mod_ssl \
    less \
    which \
    && yum clean all \
    && sed -ri 's/#ServerName www.example.com:80/ServerName localhost:80/g' /etc/httpd/conf/httpd.conf \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/httpd/conf/httpd.conf \
    && sed -ri -e 's!^(\s*CustomLog)\s+\S+!\1 /proc/self/fd/1!g' \
	       -e 's!^(\s*ErrorLog)\s+\S+!\1 /proc/self/fd/2!g' \
	       /etc/httpd/conf/httpd.conf

ADD php.ini /etc/php.ini
ADD index.php /var/www/html

WORKDIR /var/www/html

EXPOSE 80

ADD run-httpd.sh /run-httpd.sh
RUN chmod -v +x /run-httpd.sh

CMD ["/run-httpd.sh"]
