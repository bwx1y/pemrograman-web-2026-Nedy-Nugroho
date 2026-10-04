# Gunakan image resmi PHP dengan web server Apache
FROM php:8.2-apache

# Instal pustaka PostgreSQL dan ekstensi PDO PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Salin semua file project ke dalam container
COPY . /var/www/html/

# Buka port 80 untuk akses web
EXPOSE 80