FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT /code

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

FROM php:7.4-apache
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
ADD . /var/www/html
EXPOSE 80

RUN echo "date.timezone = Europe/Vilnius" > /usr/local/etc/php/php.ini
