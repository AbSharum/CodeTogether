FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN a2enmod rewrite

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf


COPY ./app /var/www/html

#shows PHP errors
RUN echo "display_errors=On\nerror_reporting=E_ALL\nlog_errors=On\nerror_log=/var/log/apache2/php_errors.log" > /usr/local/etc/php/conf.d/dev.ini
