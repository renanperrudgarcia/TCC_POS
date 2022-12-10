FROM php:8.1.0-fpm as prod

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN usermod -u 1000 -s /bin/bash www-data && groupmod -g 1000 www-data

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    nginx \
    zlib1g-dev \
    unzip \
    unixodbc \
    unixodbc-dev \
    freetds-dev \
    freetds-bin \
    libpng-dev \
    tdsodbc \
    libxml2-dev \
    libicu-dev \
    locales-all \
    task-brazilian-portuguese \
    ghostscript \
    libaio-dev \
    libzip-dev \
    wget \
    curl \
    openssl \
    nano \
    locales \
    tzdata \
    dos2unix \
    iproute2 \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-install gd \
    && docker-php-ext-install soap \
    && docker-php-ext-install sockets

# Define locale PT-BR
RUN echo "pt_BR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen "pt_BR.UTF-8" && \
    dpkg-reconfigure --frontend=noninteractive locales && \
    update-locale LANG="pt_BR.UTF-8"

# Define Timezone America/Sao_Paulo
RUN ln -fs /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

#Nginx configure default application
RUN rm /etc/nginx/sites-available/default
ADD .docker/nginx/sites-available/default /etc/nginx/sites-available/default

#PHP Configuration
ADD .docker/php/php.ini /usr/local/etc/php/php.ini

ADD .docker/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN rm -Rf /var/www/* && \
    mkdir /var/www/html/

#Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Add application source to container
ADD . /var/www/html/

RUN chown -R 1000:1000 /var/www/html
WORKDIR "/var/www/html"
RUN composer install

EXPOSE 80

ADD .docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/*

CMD ["nginx", "-g", "daemon off;"]

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

FROM prod AS dev

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.mode = debug" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.start_with_request = yes" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.client_host = host.docker.internal" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.client_port = 9000" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.cli_color = 2" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.dump.* = *" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.dump_globals = true" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.force_display_errors = 1" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.log = /var/www/html/log/xdebug.log" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.log_level = 7" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
