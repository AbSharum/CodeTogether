FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install sockets

RUN a2enmod rewrite

COPY ./apache-config.conf /etc/apache2/conf-available/app-overrides.conf
RUN a2enconf app-overrides

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf


COPY ./app /var/www/html

#shows PHP errors
RUN echo "display_errors=On\nerror_reporting=E_ALL\nlog_errors=On\nerror_log=/var/log/apache2/php_errors.log" > /usr/local/etc/php/conf.d/dev.ini
