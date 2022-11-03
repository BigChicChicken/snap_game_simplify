FROM php:8.1-fpm-alpine3.15

# PHP extensions

RUN echo 'memory_limit = -1' > /usr/local/etc/php/conf.d/memory-limit.ini && \
    echo 'date.timezone = "Europe/Paris"' > /usr/local/etc/php/conf.d/date-timezone.ini

# Composer

RUN	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php && \
	php -r "unlink('composer-setup.php');" && \
	mv composer.phar /usr/local/bin/composer

###

WORKDIR /home/www-data/snap/