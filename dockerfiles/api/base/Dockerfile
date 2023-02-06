FROM php:7.4-fpm

# Change this line and commit to repo to trigger api base container pipeline build

# Install system dependencies
RUN apt-get update --fix-missing; \
    apt-get upgrade -y; \
    apt-get install -y \
    git \
    libcurl4 \
    libcurl4-openssl-dev \
    curl \
    zip \
    unzip \
    libzip-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev \
    jpegoptim \
    optipng \
    pngquant \
    supervisor \
    nginx \
    htop \
    nano \
    ghostscript

# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j"$(nproc)" pdo_mysql exif pcntl bcmath gd zip soap intl opcache mbstring

RUN pecl install apcu xdebug

# Setup the Composer installer with a patch to exclude temp files / folders to be sync with lsyncd
COPY ./dockerfiles/api/base/php/composer.patch /tmp

RUN php -r "readfile('https://getcomposer.org/installer');" > /tmp/composer-setup.php && \
    php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot && \
    rm -rf /tmp/composer-setup.php && \
    git clone https://github.com/composer/composer.git /tmp/composer && \
    cd /tmp/composer && \
    composer install && \
    mv /tmp/composer.patch /tmp/composer && \
    patch -p1 < /tmp/composer/composer.patch && \
    php -d phar.readonly=false /tmp/composer/bin/compile && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

RUN cd /usr/local/bin && \
    curl -sLO https://github.com/gordalina/cachetool/releases/latest/download/cachetool.phar && \
    chmod +x cachetool.phar

# Install php.ini
RUN { \
        echo "upload_max_filesize = 10M"; \
        echo "post_max_size = 10M"; \
        echo "max_execution_time = 300"; \
        echo "max_input_time = 300"; \
        echo "default_socker_timeout = 300"; \
        echo "memory_limit = 256M"; \
        echo "max_input_vars = 5000"; \
        echo "opcache.enable = 0"; \
        echo "opcache.enable_cli = 0"; \
    } > /usr/local/etc/php/php.ini

COPY ./dockerfiles/api/base/php/php-fpm.d/* /usr/local/etc/php-fpm.d/

COPY ./dockerfiles/api/base/nginx/nginx.conf /etc/nginx/nginx.conf
# Nothing in here.... for now
# COPY ./dockerfiles/api/base/nginx/conf.d/* /etc/nginx/conf.d/
COPY ./dockerfiles/api/base/nginx/sites-enabled/* /etc/nginx/sites-enabled/

COPY ./dockerfiles/api/base/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./dockerfiles/api/base/supervisor/supervisor.d/*  /etc/supervisor/conf.d/

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone

WORKDIR /var/www/html

EXPOSE 80 443 9001

ENTRYPOINT ["/usr/bin/supervisord", "-n"]
