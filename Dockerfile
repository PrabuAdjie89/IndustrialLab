FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}