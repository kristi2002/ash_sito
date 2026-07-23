# ---- Dipendenze Composer ----
FROM composer:2 AS deps
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ---- Runtime PHP + Apache ----
FROM php:8.3-apache
WORKDIR /var/www/html

RUN a2enmod rewrite headers

# Limiti di upload per gli allegati del modulo preventivo
# (5 file x 8 MB ciascuno, con margine per l'overhead del multipart)
RUN { \
        echo "upload_max_filesize = 8M"; \
        echo "post_max_size = 45M"; \
        echo "max_file_uploads = 5"; \
    } > /usr/local/etc/php/conf.d/uploads.ini

COPY . .
COPY --from=deps /app/vendor ./vendor

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
