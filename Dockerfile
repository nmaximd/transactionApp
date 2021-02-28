FROM php:7.4-fpm

RUN mkdir /var/www/transactionApp

WORKDIR /var/www/transactionApp

RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6 \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    cron

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www/transactionApp

RUN chown -R www:www .

RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap/cache

RUN crontab -l | { cat; echo "* * * * * php /app/artisan schedule:run >> /dev/null 2>&1"; } | crontab -

USER www

EXPOSE 9000
CMD ["php-fpm"]
