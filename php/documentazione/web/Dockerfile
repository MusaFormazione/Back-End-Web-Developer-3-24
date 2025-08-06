FROM php:8.4-apache

RUN chown -R www-data:www-data /var/www/html

RUN echo "ServerName docker-php-server" >> "/etc/apache2/apache2.conf"

RUN echo "upload_tmp_dir = /var/www/tmp" > /usr/local/etc/php/conf.d/99-upload-dir.ini
RUN echo "session.save_path = /var/www/session-tmp" > /usr/local/etc/php/conf.d/99-session-save-path.ini

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN docker-php-ext-enable pdo_mysql mysqli

EXPOSE 80

CMD ["apache2-foreground"]