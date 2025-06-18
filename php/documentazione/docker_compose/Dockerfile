FROM php:8.4-apache

RUN chown -R www-data:www-data /var/www/html

RUN echo "ServerName docker-php-server" >> "/etc/apache2/apache2.conf"

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN docker-php-ext-enable pdo_mysql mysqli

EXPOSE 80

CMD ["apache2-foreground"]