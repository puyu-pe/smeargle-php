FROM php:8.2-fpm-bullseye
ARG UID

#config userapp
RUN adduser -u ${UID} --disabled-password --gecos "" appuser \
    && mkdir /home/appuser/.ssh \
    && chown -R appuser:appuser /home/appuser/ \
    && echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config \
    && echo "export COLUMNS=300" >> /home/appuser/.bashrc \
    && echo "alias sf='php bin/console'" >> /home/appuser/.bashrc

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.4.0\
    && composer --version

# Config php.ini \
COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

# Config XDEBUG
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/library
