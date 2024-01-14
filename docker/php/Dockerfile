FROM php:8.0-fpm

RUN usermod -u 1000 www-data

ADD www.conf /usr/local/etc/php-fpm.d/www.conf

RUN apt-get clean

RUN apt-get update && apt-get install -y \
    locales \
    && sed -i 's/# tr_TR.UTF-8 UTF-8/tr_TR.UTF-8 UTF-8/' /etc/locale.gen \
    && locale-gen

RUN apt-get install -y \
    git \
    curl \
    libonig-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer
