FROM php:7.4-fpm

WORKDIR /var/www/html

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
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

RUN apt-get install -y cron

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY cron /etc/cron.d/scheduler

RUN crontab -u www /etc/cron.d/scheduler && touch /var/log/cron.log

CMD cron && tail -f /var/log/cron.log
