FROM php:7.4.4-cli

RUN apt-get clean
RUN apt-get -y autoremove
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt-get update

RUN touch /var/log/cron.log
RUN touch /var/log/queue.log
RUN touch /var/log/supervisord.log

RUN apt-get install -y supervisor

COPY supervisord.conf /etc/supervisor/supervisord.conf

RUN apt-get install -y cron
COPY cron.d/schedule /etc/cron.d
RUN chmod -R 644 /etc/cron.d
RUN crontab /etc/cron.d/schedule	

# Zip
RUN apt-get install -y libzip-dev zip && docker-php-ext-configure zip && docker-php-ext-install zip

# Curl
RUN apt-get install -y libcurl3-dev curl && docker-php-ext-install curl

# PHP Redis extension
RUN pecl install redis
RUN docker-php-ext-enable redis

# PostgreSQL
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

COPY php.ini /usr/local/etc/php/php.ini

RUN apt-get clean
RUN apt-get -y autoremove
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /etc/supervisor/conf.d/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
