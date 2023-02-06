FROM red6sixacr.azurecr.io/api-php-nginx-base:BUILD_NO_API_BASE

RUN apt-get update --fix-missing; \
    apt-get upgrade -y; \
    apt-get install -y cron sudo; \
    userdel -f www-data; \
    if getent group www-data; then groupdel www-data; fi; \
    groupadd -g 33 www-data; \
    useradd -l -u 33 -g www-data -s /bin/bash www-data; \
    install -d -m 0755 -o www-data -g www-data /home/www-data; \
    mkdir -p /var/log/cron

COPY ./dockerfiles/api/production/crontab /root/crontab

RUN chmod 0644 /root/crontab; \
    crontab /root/crontab

COPY ./dockerfiles/api/production/supervisor/conf.d/cron.conf /etc/supervisor/conf.d/cron.conf

RUN { \
        echo "opcache.enable = 1"; \
        echo "opcache.enable_cli = 1"; \
        echo "opcache.memory_consumption = 256"; \
        echo "opcache.interned_strings_buffer = 16"; \
        echo "opcache.max_accelerated_files = 8000"; \
        echo "opcache.save_comments = 0"; \
        echo "opcache.revalidate_freq = 0"; \
        echo "opcache.validate_timestamps = 0"; \
        echo "session.gc_maxlifetime = 86400"; \
    } >> /usr/local/etc/php/php.ini

COPY ./src/ /var/www/html


# There's a Kubernetes persistent vol and claim mounted to /mnt/azure/
# We want the app storage to be shared amongst pods so the below 'warms'
# the required directory, creates a symlink from the app storage/app dir to
# /mnt/azure/app, then installs required dependencies and links at the app level
# When PVC is mounted on pod run, these links persist as expected achieving shared
# storage for multiple app pods
RUN mkdir -p /mnt/azure/app; \ 
    cd /var/www/html; \
    rm -rf storage/app; \
    ln -s /mnt/azure/app storage/app; \
    composer install --no-ansi --no-dev --no-interaction --no-scripts --optimize-autoloader; \
    chown -R www-data:www-data .; \
    php artisan storage:link