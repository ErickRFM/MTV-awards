FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    default-mysql-client \
    unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername \
    && mkdir -p /var/www/html/public/uploads/artists \
       /var/www/html/public/uploads/albums \
       /var/www/html/public/uploads/users \
       /var/www/html/public/uploads/songs \
    && chown -R www-data:www-data /var/www/html/public/uploads \
    && chmod +x /var/www/html/start.sh

RUN echo "display_errors=On" >> /usr/local/etc/php/conf.d/render.ini \
    && echo "display_startup_errors=On" >> /usr/local/etc/php/conf.d/render.ini \
    && echo "log_errors=On" >> /usr/local/etc/php/conf.d/render.ini \
    && echo "error_reporting=E_ALL" >> /usr/local/etc/php/conf.d/render.ini

EXPOSE 80

CMD ["/var/www/html/start.sh"]
